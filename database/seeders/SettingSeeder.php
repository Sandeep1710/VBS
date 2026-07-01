<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['general', 'site_name', 'Trikuti Battery', 'string', 'Site Name', true],
            ['general', 'site_tagline', "Navi Mumbai's #1 battery delivery service · Same-day delivery", 'string', 'Site Tagline', true],
            ['general', 'support_email', 'vbs622026@gmail.com', 'string', 'Support Email', true],
            ['general', 'support_phone', '+91 9920971479', 'string', 'Support Phone', true],
            ['general', 'whatsapp_number', '+919920971479', 'string', 'WhatsApp Number', true],
            ['general', 'address', 'R-30, MIDC Area Rd, MIDC Industrial Area, Rabale, Navi Mumbai, Maharashtra 400701', 'text', 'Office Address', true],

            ['order', 'default_tax_percent', '18', 'integer', 'Default GST % (CGST 9 + SGST 9)'],
            ['order', 'default_delivery_charge', '99', 'integer', 'Default Delivery Charge (₹) for outside-Mumbai pincodes'],
            ['order', 'free_delivery_above', '2000', 'integer', 'Free Delivery Above (₹)'],
            ['order', 'cod_max_amount', '20000', 'integer', 'Max COD Amount (₹)'],

            ['social', 'facebook', 'https://facebook.com/', 'string', 'Facebook URL', true],
            ['social', 'instagram', 'https://instagram.com/', 'string', 'Instagram URL', true],

            ['seo', 'default_meta_title', 'Buy Car & Bike Batteries Online in Mumbai — Same-day Delivery', 'string', 'Default Meta Title'],
            ['seo', 'default_meta_description', "Mumbai's #1 battery delivery service. Buy genuine Exide, Amaron, SF Sonic batteries with same-day delivery, free installation and old battery exchange across Mumbai, Thane and Navi Mumbai.", 'text', 'Default Meta Description'],
            ['seo', 'google_analytics_id', '', 'string', 'Google Analytics 4 ID (G-XXXXXXX)'],
            ['seo', 'google_search_console', '', 'string', 'Google Search Console verification token (content of google-site-verification meta)'],
            ['seo', 'google_tag_manager_id', '', 'string', 'Google Tag Manager container ID (GTM-XXXXXXX)'],
            ['seo', 'facebook_pixel_id', '', 'string', 'Facebook / Meta Pixel ID'],
            ['seo', 'bing_verification', '', 'string', 'Bing Webmaster verification token'],

            // Lead-gen mode: only COD enabled. Admin follows up manually.
            // Switch upi/card to '1' after Razorpay KYC approval to accept online payments.
            ['payment', 'cod_enabled', '1', 'boolean', 'Enable COD'],
            ['payment', 'upi_enabled', '0', 'boolean', 'Enable UPI (requires Razorpay)'],
            ['payment', 'card_enabled', '0', 'boolean', 'Enable Card (requires Razorpay)'],
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
