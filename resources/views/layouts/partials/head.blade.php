@php
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
    $defaultMetaTitle = \App\Models\Setting::get('default_meta_title', $siteName, 'seo');
    $defaultMetaDescription = \App\Models\Setting::get('default_meta_description', '', 'seo');
    $supportPhone = \App\Models\Setting::get('support_phone', '+91 9920971479');
    $supportEmail = \App\Models\Setting::get('support_email', 'vbs622026@gmail.com');
    $facebook = \App\Models\Setting::get('facebook', null, 'social');
    $instagram = \App\Models\Setting::get('instagram', null, 'social');

    $gaId = trim((string) \App\Models\Setting::get('google_analytics_id', '', 'seo'));
    $gtmId = trim((string) \App\Models\Setting::get('google_tag_manager_id', '', 'seo'));
    $gscToken = trim((string) \App\Models\Setting::get('google_search_console', '', 'seo'));
    $fbPixelId = trim((string) \App\Models\Setting::get('facebook_pixel_id', '', 'seo'));
    $bingToken = trim((string) \App\Models\Setting::get('bing_verification', '', 'seo'));

    $pageTitle = $title ?? ($pageTitle ?? $defaultMetaTitle);
    $pageDescription = $metaDescription ?? $defaultMetaDescription;
    $pageUrl = $canonical ?? url()->current();
    $pageOgImage = $ogImage ?? asset('storage/banners/hero-2.jpg');
    $pageOgType = $ogType ?? 'website';
    $isNoindex = isset($noindex) && $noindex;
@endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="theme-color" content="#dc2626">

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
<link rel="canonical" href="{{ $pageUrl }}">

@if($isNoindex)
    <meta name="robots" content="noindex, nofollow">
@else
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
@endif

{{-- Search engine verification (rendered only when filled in admin settings) --}}
@if($gscToken)
    <meta name="google-site-verification" content="{{ $gscToken }}">
@endif
@if($bingToken)
    <meta name="msvalidate.01" content="{{ $bingToken }}">
@endif

{{-- Open Graph (WhatsApp, Facebook, LinkedIn link previews) --}}
<meta property="og:type" content="{{ $pageOgType }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $pageUrl }}">
<meta property="og:image" content="{{ $pageOgImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="en_IN">

{{-- Twitter card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $pageOgImage }}">

{{-- Favicons --}}
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">

{{-- Site-wide structured data: LocalBusiness + WebSite + Organization --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'LocalBusiness',
            '@id' => url('/') . '#business',
            'name' => $siteName,
            'image' => asset('storage/banners/hero-2.jpg'),
            'logo' => asset('favicon.svg'),
            'url' => url('/'),
            'telephone' => $supportPhone,
            'email' => $supportEmail,
            'priceRange' => '₹₹',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'R-30, MIDC Area Rd, MIDC Industrial Area',
                'addressLocality' => 'Rabale, Navi Mumbai',
                'addressRegion' => 'Maharashtra',
                'postalCode' => '400701',
                'addressCountry' => 'IN',
            ],
            'openingHoursSpecification' => [[
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
                'opens' => '09:00',
                'closes' => '20:00',
            ]],
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Mumbai'],
                ['@type' => 'City', 'name' => 'Thane'],
                ['@type' => 'City', 'name' => 'Navi Mumbai'],
            ],
            'sameAs' => array_values(array_filter([$facebook, $instagram])),
        ],
        [
            '@type' => 'WebSite',
            '@id' => url('/') . '#website',
            'url' => url('/'),
            'name' => $siteName,
            'publisher' => ['@id' => url('/') . '#business'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/products') . '?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Google Tag Manager --}}
@if($gtmId)
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});
        var f=d.getElementsByTagName(s)[0], j=d.createElement(s), dl=l!='dataLayer'?'&l='+l:'';
        j.async=true; j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl; f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $gtmId }}');
    </script>
@endif

{{-- Google Analytics 4 (skip if GTM is present; use GTM to load GA4) --}}
@if($gaId && !$gtmId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $gaId }}', { anonymize_ip: true });
    </script>
@endif

{{-- Meta / Facebook Pixel --}}
@if($fbPixelId)
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $fbPixelId }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" alt=""
        src="https://www.facebook.com/tr?id={{ $fbPixelId }}&ev=PageView&noscript=1"></noscript>
@endif

@stack('head')
