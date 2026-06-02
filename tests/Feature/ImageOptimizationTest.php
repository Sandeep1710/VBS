<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Services\Media\ImageOptimizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageOptimizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_optimizer_resizes_oversized_image(): void
    {
        Storage::fake('public');

        $optimizer = new ImageOptimizer(maxWidth: 800, maxHeight: 800, quality: 80);
        $upload = UploadedFile::fake()->image('huge.jpg', 4000, 3000);

        $path = $optimizer->storeAs($upload, 'test');

        Storage::disk('public')->assertExists($path);

        // Verify the resized file actually fits the bounds
        $absolutePath = Storage::disk('public')->path($path);
        [$w, $h] = getimagesize($absolutePath);
        $this->assertLessThanOrEqual(800, $w);
        $this->assertLessThanOrEqual(800, $h);
    }

    public function test_review_with_image_uploads_creates_review_image_row(): void
    {
        Storage::fake('public');

        $user = $this->makeCustomer();
        $product = $this->makeProduct();

        // Make user a verified buyer for this product
        $order = Order::create([
            'order_number' => 'VBS' . str_pad((string) random_int(1, 99999), 8, '0', STR_PAD_LEFT),
            'user_id' => $user->id,
            'subtotal' => 100, 'total' => 100,
            'billing_name' => 'T', 'billing_phone' => '1', 'billing_line1' => 'X',
            'billing_city' => 'X', 'billing_state' => 'X', 'billing_pincode' => '111111',
            'shipping_name' => 'T', 'shipping_phone' => '1', 'shipping_line1' => 'X',
            'shipping_city' => 'X', 'shipping_state' => 'X', 'shipping_pincode' => '111111',
            'payment_method' => 'cod',
            'status' => Order::STATUS_DELIVERED,
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'quantity' => 1, 'price' => 100, 'subtotal' => 100, 'total' => 100,
        ]);

        $this->actingAs($user)
            ->post(route('account.reviews.store', $product), [
                'rating' => 5,
                'comment' => 'Great battery, very happy with the purchase.',
                'images' => [
                    UploadedFile::fake()->image('photo1.jpg', 600, 400),
                    UploadedFile::fake()->image('photo2.jpg', 600, 400),
                ],
            ])
            ->assertRedirect();

        $review = Review::where('user_id', $user->id)->first();
        $this->assertNotNull($review);
        $this->assertEquals(2, $review->images()->count());

        foreach ($review->images as $img) {
            Storage::disk('public')->assertExists($img->path);
        }
    }

    public function test_review_image_count_capped_at_5(): void
    {
        Storage::fake('public');

        $user = $this->makeCustomer();
        $product = $this->makeProduct();

        $images = [];
        for ($i = 0; $i < 6; $i++) {
            $images[] = UploadedFile::fake()->image("p$i.jpg");
        }

        $this->actingAs($user)
            ->from(route('products.show', $product))
            ->post(route('account.reviews.store', $product), [
                'rating' => 5,
                'comment' => 'Six photos should be rejected',
                'images' => $images,
            ])
            ->assertSessionHasErrors('images');
    }
}
