# Deployment Guide — Vehicle Battery Store

A practical checklist for moving this Laravel app from local dev to a real
production environment.

## 1. Server requirements

- PHP 8.3+ with extensions: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd` (or `imagick`), `curl`, `redis` (recommended)
- MySQL 8.0+ (or MariaDB 10.6+)
- Composer 2.x
- Node.js 22+ and npm (for the asset build only — no Node runtime needed in production)
- A web server: **Nginx** or Apache with a PHP-FPM pool
- HTTPS certificate (Let's Encrypt is fine)

## 2. First-time setup on the server

```bash
git clone <your-repo> /var/www/vehicle-battery-store
cd /var/www/vehicle-battery-store

# Install PHP dependencies (no dev packages, optimized autoloader)
composer install --no-dev --prefer-dist --optimize-autoloader

# Install Node deps and build assets
npm ci
npm run build

# Permissions (Linux)
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## 3. Environment

Copy `.env.example` to `.env` and configure:

```env
APP_NAME="Vehicle Battery Store"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_KEY=                              # php artisan key:generate

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vehicle_battery_store
DB_USERNAME=app_user                  # NOT root in production
DB_PASSWORD=                          # strong password

SESSION_DRIVER=database               # or redis
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true            # HTTPS only

QUEUE_CONNECTION=database             # or redis (preferred)

CACHE_STORE=database                  # or redis (preferred)

# Real mail in production — pick one:
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=postmaster@yourdomain.com
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=orders@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Optional: Redis for cache + queue + session
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

Then:

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force          # only on first deploy
php artisan storage:link

# Performance: cache the app metadata
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## 4. Web server

### Nginx

```nginx
server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    root /var/www/vehicle-battery-store/public;
    index index.php;

    ssl_certificate     /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header Referrer-Policy "strict-origin-when-cross-origin";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}

server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$host$request_uri;
}
```

## 5. Queue worker (required for emails)

Order confirmation, dispatch, delivery, and password reset emails are queued
via the `database` queue connection. Set up a supervisor process to keep a
worker running:

`/etc/supervisor/conf.d/vbs-worker.conf`:

```ini
[program:vbs-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/vehicle-battery-store/artisan queue:work --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/vbs-worker.log
stopwaitsecs=3600
```

Then:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start vbs-worker:*
```

If you don't have supervisor: `nohup php artisan queue:work --tries=3 &` works
for testing but is **not** production-grade.

## 6. Scheduler (cron)

Add to crontab:

```cron
* * * * * cd /var/www/vehicle-battery-store && php artisan schedule:run >> /dev/null 2>&1
```

## 7. SMS / WhatsApp notifications

Stubs are wired (see `app/Services/Notifications/Log*Gateway.php`). To send for real:

1. Implement `App\Contracts\Notifications\SmsGatewayContract` (or `WhatsAppGatewayContract`) for your provider — e.g. Twilio, MSG91, Gupshup, Meta Cloud API.
2. Bind your implementation in `app/Providers/AppServiceProvider.php`:

```php
$this->app->singleton(SmsGatewayContract::class, MyTwilioGateway::class);
```

3. In the database (`settings` table), set `notifications.sms_enabled` or `notifications.whatsapp_enabled` to `1`.

## 8. Payment gateways

`payment_method` accepts `cod`, `upi`, `card`. UPI/Card are stubbed — orders go in
with `payment_status='pending'` and admin marks them paid manually.
For real payment processing, integrate a gateway such as Razorpay/Stripe/PayU
inside `App\Services\Checkout\CheckoutService::placeOrder()` (after the order
row is created, redirect to the gateway and update payment status on callback).

## 9. Hardening

- `APP_DEBUG=false` and `APP_ENV=production`
- Use a non-root MySQL user with only the privileges this app needs
- `chmod 600 .env`
- Rate-limit `/login` and `/admin/login` further if needed (currently 5/min via `RateLimiter`)
- HTTPS-only cookies: `SESSION_SECURE_COOKIE=true`, `SESSION_SAME_SITE=lax`
- Trust your reverse-proxy headers if behind one (`TrustProxies` middleware)
- Run a CDN / Cloudflare in front for static assets and DDoS protection
- Back up MySQL nightly, plus `storage/app/public` (uploaded product images)
- Monitor with Sentry / Bugsnag / Laravel Pulse

## 10. Deploy script (subsequent deploys)

```bash
#!/bin/bash
set -e
cd /var/www/vehicle-battery-store
php artisan down --refresh=15
git pull
composer install --no-dev --prefer-dist --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart
php artisan up
```

## 11. Local dev recap

```bash
php artisan serve                    # 127.0.0.1:8000 only
php artisan serve --host=0.0.0.0     # all interfaces — LAN-accessible
npm run dev                          # Vite dev server with HMR
php artisan queue:work               # process queued emails locally
php artisan test                     # run the test suite (22 feature tests)
```

## Test credentials (seeded)

| Role     | Email                          | Password   |
| -------- | ------------------------------ | ---------- |
| Admin    | admin@vehiclebattery.test      | password   |
| Customer | customer@vehiclebattery.test   | password   |
