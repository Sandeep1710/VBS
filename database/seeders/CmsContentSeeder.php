<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\Faq;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class CmsContentSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['about-us', 'About Us', '<p>Vehicle Battery Store is your trusted destination for genuine automotive batteries with doorstep delivery and old battery exchange.</p>', true],
            ['contact-us', 'Contact Us', '<p>Reach us at <a href="mailto:support@vehiclebattery.test">support@vehiclebattery.test</a> or call 1800-XXX-XXXX.</p>', true],
            ['privacy-policy', 'Privacy Policy', '<p>We respect your privacy. This policy describes how we collect, use, and protect your personal information.</p>', true],
            ['terms-and-conditions', 'Terms & Conditions', '<p>By using this website you agree to the following terms and conditions.</p>', true],
        ];

        foreach ($pages as $i => [$slug, $title, $content, $footer]) {
            CmsPage::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title, 'content' => $content,
                    'is_active' => true, 'show_in_footer' => $footer, 'sort_order' => $i + 1,
                    'meta_title' => "$title | Vehicle Battery Store",
                    'meta_description' => "$title page of Vehicle Battery Store.",
                ],
            );
        }

        $faqs = [
            ['Order', 'How long does delivery take?', 'Most metro pincodes get same-day or next-day delivery. Other locations take 2-4 business days.'],
            ['Order', 'Can I cancel my order?', 'Yes, you can cancel your order before it is dispatched from your account.'],
            ['Battery', 'What is old battery exchange?', 'You can return your old battery and get an exchange discount on the new battery.'],
            ['Battery', 'How is the warranty period calculated?', 'Warranty starts from the date of delivery and is provided by the battery manufacturer.'],
            ['Payment', 'What payment methods are supported?', 'UPI, debit/credit cards, and Cash on Delivery.'],
            ['Payment', 'Is COD available?', 'Yes, COD is available for orders below ₹20,000 in most pincodes.'],
        ];

        foreach ($faqs as $i => [$cat, $q, $a]) {
            Faq::updateOrCreate(
                ['question' => $q],
                ['category' => $cat, 'answer' => $a, 'sort_order' => $i + 1, 'is_active' => true],
            );
        }

        $testimonials = [
            ['Rahul Sharma', 'Software Engineer', 'Bangalore', 5, 'Smooth ordering and the battery was delivered the next day. Excellent service!'],
            ['Priya Mehta', 'Doctor', 'Mumbai', 5, 'Genuine battery and great exchange value for my old one. Highly recommended.'],
            ['Aman Verma', 'Business Owner', 'Delhi', 4, 'Better price than the local shop and full warranty. Will buy again.'],
            ['Sneha Reddy', 'Teacher', 'Hyderabad', 5, 'Easy checkout, reliable product. Loved the exchange discount.'],
        ];

        foreach ($testimonials as $i => [$name, $designation, $city, $rating, $comment]) {
            Testimonial::updateOrCreate(
                ['name' => $name],
                [
                    'designation' => $designation, 'city' => $city,
                    'rating' => $rating, 'comment' => $comment,
                    'is_active' => true, 'sort_order' => $i + 1,
                ],
            );
        }
    }
}
