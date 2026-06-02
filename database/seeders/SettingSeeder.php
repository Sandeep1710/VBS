<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['general', 'site_name', 'Vehicle Battery Store', 'string', 'Site Name', true],
            ['general', 'site_tagline', 'Genuine Batteries. Free Doorstep Delivery.', 'string', 'Site Tagline', true],
            ['general', 'support_email', 'support@vehiclebattery.test', 'string', 'Support Email', true],
            ['general', 'support_phone', '1800-XXX-XXXX', 'string', 'Support Phone', true],
            ['general', 'whatsapp_number', '+919000000000', 'string', 'WhatsApp Number', true],
            ['general', 'address', 'Sector 18, Industrial Area, Mumbai 400001', 'text', 'Office Address', true],

            ['order', 'default_tax_percent', '18', 'integer', 'Default GST %'],
            ['order', 'default_delivery_charge', '99', 'integer', 'Default Delivery Charge (₹)'],
            ['order', 'free_delivery_above', '2000', 'integer', 'Free Delivery Above (₹)'],
            ['order', 'cod_max_amount', '20000', 'integer', 'Max COD Amount (₹)'],

            ['social', 'facebook', 'https://facebook.com/', 'string', 'Facebook URL', true],
            ['social', 'instagram', 'https://instagram.com/', 'string', 'Instagram URL', true],

            ['seo', 'default_meta_title', 'Vehicle Battery Store - Buy Car & Bike Batteries Online', 'string', 'Default Meta Title'],
            ['seo', 'default_meta_description', 'Buy genuine car and bike batteries online with free doorstep delivery, warranty, and old battery exchange.', 'text', 'Default Meta Description'],

            ['payment', 'cod_enabled', '1', 'boolean', 'Enable COD'],
            ['payment', 'upi_enabled', '1', 'boolean', 'Enable UPI'],
            ['payment', 'card_enabled', '1', 'boolean', 'Enable Card'],
        ];

        foreach ($settings as $row) {
            [$group, $key, $value, $type, $label] = $row;
            $isPublic = $row[5] ?? false;
            Setting::updateOrCreate(
                ['group' => $group, 'key' => $key],
                ['value' => $value, 'type' => $type, 'label' => $label, 'is_public' => $isPublic],
            );
        }
    }
}
