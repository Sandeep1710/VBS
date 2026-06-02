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
            ['general', 'site_tagline', "Mumbai's #1 battery delivery service · Same-day delivery", 'string', 'Site Tagline', true],
            ['general', 'support_email', 'support@yourdomain.com', 'string', 'Support Email', true],
            ['general', 'support_phone', '022-XXXX-XXXX', 'string', 'Support Phone', true],
            ['general', 'whatsapp_number', '+919XXXXXXXXX', 'string', 'WhatsApp Number', true],
            ['general', 'address', '[Your Shop Address], Mumbai, Maharashtra 400XXX', 'text', 'Office Address', true],

            ['order', 'default_tax_percent', '18', 'integer', 'Default GST % (CGST 9 + SGST 9)'],
            ['order', 'default_delivery_charge', '99', 'integer', 'Default Delivery Charge (₹) for outside-Mumbai pincodes'],
            ['order', 'free_delivery_above', '2000', 'integer', 'Free Delivery Above (₹)'],
            ['order', 'cod_max_amount', '20000', 'integer', 'Max COD Amount (₹)'],

            ['social', 'facebook', 'https://facebook.com/', 'string', 'Facebook URL', true],
            ['social', 'instagram', 'https://instagram.com/', 'string', 'Instagram URL', true],

            ['seo', 'default_meta_title', 'Buy Car & Bike Batteries Online in Mumbai — Same-day Delivery', 'string', 'Default Meta Title'],
            ['seo', 'default_meta_description', "Mumbai's #1 battery delivery service. Buy genuine Exide, Amaron, SF Sonic batteries with same-day delivery, free installation and old battery exchange across Mumbai, Thane and Navi Mumbai.", 'text', 'Default Meta Description'],

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
