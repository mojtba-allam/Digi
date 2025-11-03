<?php

namespace Modules\Business\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Authorization\app\Models\User;
use Modules\Business\app\Models\Vendor;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderItem;
use Modules\Product\app\Models\Product;

class VendorOrderTest extends TestCase
{
    use RefreshDatabase;

    protected $vendor;
    protected $user;
    protected $order;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a vendor user
        $this->user = User::factory()->create();
        $this->vendor = Vendor::factory()->create(['user_id' => $this->user->id]);
        
        // Create a product for the vendor
        $product = Product::factory()->create(['vendor_id' => $this->vendor->id]);
        
        // Create an order with items from this vendor
        $this->order = Order::factory()->create();
        OrderItem::factory()->create([
            'order_id' => $this->order->id,
            'product_id' => $product->id
        ]);
    }

    public function test_vendor_can_view_their_orders()
    {
        $response = $this->actingAs($this->user)
            ->get(route('vendor.orders.index'));

        $response->assertStatus(200);
        $response->assertViewIs('business::vendor.orders.index');
    }

    public function test_vendor_can_view_order_details()
    {
        $response = $this->actingAs($this->user)
            ->get(route('vendor.orders.show', $this->order));

        $response->assertStatus(200);
        $response->assertViewIs('business::vendor.orders.show');
    }

    public function test_vendor_can_update_order_status()
    {
        $response = $this->actingAs($this->user)
            ->patchJson(route('vendor.orders.update-status', $this->order), [
                'status' => 'confirmed',
                'notes' => 'Order confirmed by vendor'
            ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        
        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'confirmed'
        ]);
    }

    public function test_vendor_cannot_access_other_vendor_orders()
    {
        // Create another vendor and order
        $otherVendor = Vendor::factory()->create();
        $otherProduct = Product::factory()->create(['vendor_id' => $otherVendor->id]);
        $otherOrder = Order::factory()->create();
        OrderItem::factory()->create([
            'order_id' => $otherOrder->id,
            'product_id' => $otherProduct->id
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('vendor.orders.show', $otherOrder));

        $response->assertStatus(403);
    }

    public function test_non_vendor_user_cannot_access_vendor_orders()
    {
        $regularUser = User::factory()->create();

        $response = $this->actingAs($regularUser)
            ->get(route('vendor.orders.index'));

        $response->assertStatus(403);
    }
}