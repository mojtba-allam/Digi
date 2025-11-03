<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Authorization\app\Models\User;
use Modules\Authorization\app\Models\Role;
use Laravel\Sanctum\Sanctum;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Create admin user
        $this->adminUser = User::factory()->create();
        $this->adminUser->roles()->attach($adminRole->id);
    }

    public function test_admin_can_access_api_overview()
    {
        Sanctum::actingAs($this->adminUser);

        $response = $this->getJson('/api/admin/');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Admin API endpoints available'
                ]);
    }

    public function test_admin_can_get_user_statistics()
    {
        Sanctum::actingAs($this->adminUser);

        $response = $this->getJson('/api/admin/users/statistics');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'total_users',
                        'active_users',
                        'inactive_users',
                        'suspended_users'
                    ]
                ]);
    }

    public function test_admin_can_get_product_statistics()
    {
        Sanctum::actingAs($this->adminUser);

        $response = $this->getJson('/api/admin/products/statistics');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'total_products',
                        'active_products',
                        'inactive_products'
                    ]
                ]);
    }

    public function test_admin_can_get_analytics_overview()
    {
        Sanctum::actingAs($this->adminUser);

        $response = $this->getJson('/api/admin/analytics/overview');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'total_revenue',
                        'revenue_growth',
                        'total_orders',
                        'orders_growth'
                    ]
                ]);
    }

    public function test_non_admin_cannot_access_admin_api()
    {
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customer = User::factory()->create();
        $customer->roles()->attach($customerRole->id);

        Sanctum::actingAs($customer);

        $response = $this->getJson('/api/admin/');

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_access_admin_api()
    {
        $response = $this->getJson('/api/admin/');

        $response->assertStatus(401);
    }
}