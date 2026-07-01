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
        $aboutContent = <<<HTML
<h2>Mumbai's trusted battery delivery service</h2>
<p>Trikuti Battery delivers genuine automotive batteries to your doorstep across Mumbai, Thane and Navi Mumbai — with free same-day or next-day delivery for most pincodes.</p>

<h3>Why choose us</h3>
<ul>
<li><strong>Genuine batteries only</strong> — sourced directly from authorised dealers of Exide, Amaron, SF Sonic and other top brands</li>
<li><strong>Same-day delivery in Mumbai</strong> — order before 2pm for same-day delivery to all Mumbai City and Suburbs pincodes</li>
<li><strong>Free installation</strong> — our technician installs the battery and takes your old battery away</li>
<li><strong>Old battery exchange</strong> — get up to ₹800 off when you exchange your old battery</li>
<li><strong>Full manufacturer warranty</strong> — every battery comes with the brand's official warranty (24-60 months)</li>
</ul>

<h3>Service area</h3>
<p>We currently serve:</p>
<ul>
<li>Mumbai City and Suburbs (400001 – 400104) — <strong>free delivery, same/next day</strong></li>
<li>Thane (400601 – 400615) — ₹99 delivery, 2 business days</li>
<li>Navi Mumbai (400701 – 400710) — ₹99 delivery, 2 business days</li>
</ul>

<h3>Payment options</h3>
<p>Pay online via UPI, credit/debit card, or net banking. Cash on Delivery available for orders up to ₹20,000.</p>
HTML;

        $contactContent = <<<HTML
<h2>Get in touch</h2>
<p>We're here to help with your battery purchase, installation, or warranty questions.</p>

<div style="display:grid;gap:1rem;grid-template-columns:1fr 1fr;margin:1.5rem 0;">
  <div>
    <h3>📞 Phone</h3>
    <p><strong>+91 9920971479</strong><br>
    <small>Monday – Saturday, 9am to 8pm</small></p>
  </div>
  <div>
    <h3>💬 WhatsApp</h3>
    <p><strong>+91 9920971479</strong><br>
    <small>Quick replies on quotes and order status</small></p>
  </div>
  <div>
    <h3>📧 Email</h3>
    <p><a href="mailto:vbs622026@gmail.com">vbs622026@gmail.com</a><br>
    <small>Replies within 4 working hours</small></p>
  </div>
  <div>
    <h3>📍 Address</h3>
    <p>Trikuti Battery<br>
    R-30, MIDC Area Rd, MIDC Industrial Area<br>
    Rabale, Navi Mumbai, Maharashtra 400701</p>
  </div>
</div>

<h3>Service hours</h3>
<ul>
<li>Mon – Sat: 9:00 AM – 8:00 PM</li>
<li>Sunday: Closed (emergency orders via WhatsApp)</li>
</ul>

<h3>Delivery area</h3>
<p>All Mumbai (400001 – 400104), Thane (400601 – 400615) and Navi Mumbai (400701 – 400710). Check delivery to your pincode on any product page.</p>
HTML;

        $pages = [
            ['about-us', 'About Us', $aboutContent, true],
            ['contact-us', 'Contact Us', $contactContent, true],
            ['privacy-policy', 'Privacy Policy', '<p>We respect your privacy. <em>Replace this with your real privacy policy.</em></p>', true],
            ['terms-and-conditions', 'Terms & Conditions', '<p><em>Replace this with your real terms and conditions before going live.</em></p>', true],
        ];

        foreach ($pages as $i => [$slug, $title, $content, $footer]) {
            CmsPage::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title, 'content' => $content,
                    'is_active' => true, 'show_in_footer' => $footer, 'sort_order' => $i + 1,
                    'meta_title' => "$title | Mumbai Battery Store",
                    'meta_description' => "$title — Mumbai's trusted battery delivery service.",
                ],
            );
        }

        $faqs = [
            ['Delivery', 'How fast is delivery in Mumbai?', 'For all Mumbai City and Suburbs pincodes (400001 – 400104), we deliver same-day for orders placed before 2pm, and next-day for later orders. Thane and Navi Mumbai take 2 business days.'],
            ['Delivery', 'Is delivery free?', 'Yes — free delivery across all Mumbai City and Suburbs pincodes. Thane and Navi Mumbai have a flat ₹99 delivery charge.'],
            ['Delivery', 'Do you install the battery?', 'Yes, free installation is included with every battery delivery. Our technician will install the new battery and take your old one away.'],
            ['Order', 'Can I cancel my order?', 'Yes, you can cancel from your account any time before the battery is dispatched.'],
            ['Battery', 'How does old battery exchange work?', 'Add the exchange option when adding a battery to cart. Hand over your old battery to the technician during installation and get up to ₹800 off instantly.'],
            ['Battery', 'How is the warranty period calculated?', 'Warranty starts from the date of delivery and is provided directly by the battery manufacturer (Exide, Amaron, etc.).'],
            ['Payment', 'What payment methods do you accept?', 'UPI, credit/debit cards, net banking, and Cash on Delivery (COD) up to ₹20,000.'],
            ['Payment', 'Is COD available across Mumbai?', 'Yes, COD is available for all serviceable pincodes including Mumbai, Thane and Navi Mumbai for orders below ₹20,000.'],
        ];

        foreach ($faqs as $i => [$cat, $q, $a]) {
            Faq::updateOrCreate(
                ['question' => $q],
                ['category' => $cat, 'answer' => $a, 'sort_order' => $i + 1, 'is_active' => true],
            );
        }

        $testimonials = [
            ['Rahul Sharma', 'Software Engineer', 'Andheri West', 5, 'Ordered at 11am, battery installed at my doorstep by 3pm. Couldn\'t believe how fast it was. Genuine Exide product, perfect service.'],
            ['Priya Mehta', 'Doctor', 'Bandra', 5, 'Old battery pickup saved me a trip to the scrap dealer. Got ₹700 off instantly. Highly recommended for anyone in Mumbai.'],
            ['Aman Verma', 'Business Owner', 'Powai', 4, 'Better price than the local Amaron dealer and full warranty card with proper bill. Will buy again.'],
            ['Sneha Reddy', 'Teacher', 'Thane West', 5, 'Was hesitant about ordering a battery online but the experience was smooth. Delivered next day, technician was professional.'],
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
