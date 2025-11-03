<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderStatus;
use Modules\Authorization\app\Models\User;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $customer;
    protected $order;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com'
        ]);

        // Create customer user
        $this->customer = User::factory()->create([
            'role' => 'customer',
            'email' => 'customer@test.com'
        ]);

        // Create test order
        $this->order = Order::factory()->create([
            'user_id' => $this->customer->id,
            'status' => 'pending',
            'total_amount' => 100.00
        ]);
    }

    /** @test */
    public function admin_can_view_orders_index()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.orders.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.index');
        $response->assertSee($this->order->formatted_order_number);
    }

    /** @test */
    public function admin_can_view_order_details()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.orders.show', $this->order));

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.show');
        $response->assertSee($this->order->formatted_order_number);
        $response->assertSee($this->customer->name);
    }

    /** @test */
    public function admin_can_update_order_status()
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.orders.update-status', $this->order), [
                'status' => 'confirmed',
                'notes' => 'Order confirmed by admin'
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'status' => 'confirmed'
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'confirmed'
        ]);

        $this->assertDatabaseHas('order_statuses', [
            'order_id' => $this->order->id,
            'status' => 'confirmed',
            'notes' => 'Order confirmed by admin'
        ]);
    }

    /** @test */
    public function admin_can_filter_orders_by_status()
    {
        // Create orders with different statuses
        $confirmedOrder = Order::factory()->create([
            'user_id' => $this->customer->id,
            'status' => 'confirmed'
        ]);

        $shippedOrder = Order::factory()->create([
            'user_id' => $this->customer->id,
            'status' => 'shipped'
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.orders.index', ['status' => 'confirmed']));

        $response->assertStatus(200);
        $response->assertSee($confirmedOrder->formatted_order_number);
        $response->assertDontSee($this->order->formatted_order_number); // pending order
        $response->assertDontSee($shippedOrder->formatted_order_number);
    }

    /** @test */
    public function admin_can_search_orders()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.orders.index', ['search' => $this->customer->name]));

        $response->assertStatus(200);
        $response->assertSee($this->order->formatted_order_number);
    }

    /** @test */
    public function admin_can_bulk_update_order_status()
    {
        $order2 = Order::factory()->create([
            'user_id' => $this->customer->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.orders.bulk-update-status'), [
                'order_ids' => [$this->order->id, $order2->id],
                'status' => 'confirmed'
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'updated_count' => 2
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'confirmed'
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order2->id,
            'status' => 'confirmed'
        ]);
    }

    /** @test */
    public function invalid_status_transition_is_rejected()
    {
        // Try to change from pending directly to delivered (invalid transition)
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.orders.update-status', $this->order), [
                'status' => 'delivered'
            ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Invalid status transition'
        ]);

        // Order status should remain unchanged
        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'pending'
        ]);
    }

    /** @test */
    public function non_admin_cannot_access_order_management()
    {
        $response = $this->actingAs($this->customer)
            ->get(route('admin.orders.index'));

        $response->assertStatus(403);
    }
}