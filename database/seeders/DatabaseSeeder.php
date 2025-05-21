<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database in the exact migration order
     * to preserve foreign key constraints without disabling checks.
     */
    public function run(): void
    {
        // 1. Core tables (no dependencies)
        $this->call([
            // Authentication & Authorization
            \Modules\Authorization\database\seeders\RoleSeeder::class,
            \Modules\Authorization\database\seeders\PermissionSeeder::class,
            \Modules\Authorization\database\seeders\RolePermissionSeeder::class,
            \Modules\Admin\database\seeders\AdminSeeder::class,
            \Modules\Authorization\database\seeders\TemporaryPermissionSeeder::class,

            // Analytics & Search
            \Modules\AnalyticsAndReporting\database\seeders\AnalyticSeeder::class,
            \Modules\SearchAndFiltering\database\seeders\FilterSeeder::class,

            // Content Management
            \Modules\Notification\database\seeders\NotificationTemplateSeeder::class,
            \Modules\CustomerSupport\database\seeders\FaqSeeder::class,
            \Modules\AnalyticsAndReporting\database\seeders\ReportSeeder::class,

            // Promotions
            \Modules\PromotionAndCoupon\database\seeders\PromotionSeeder::class,
            \Modules\PromotionAndCoupon\database\seeders\DiscountRuleSeeder::class,

            // Content
            \Modules\ContentManagement\database\seeders\MediaSeeder::class,
            \Modules\ContentManagement\database\seeders\PageSeeder::class,
            \Modules\ContentManagement\database\seeders\BlogSeeder::class,
        ]);

        // 2. Users and user-related tables
        $this->call([
            \Modules\Authorization\database\seeders\UserSeeder::class,
            \Modules\Authorization\database\seeders\OAuthSeeder::class,
            \Modules\Notification\database\seeders\NotificationSeeder::class,
            \Modules\Notification\database\seeders\NotificationSubscriptionSeeder::class,
            \Modules\SearchAndFiltering\database\seeders\SearchLogSeeder::class,
            \Modules\CustomerSupport\database\seeders\SupportTicketSeeder::class,
            \Modules\CustomerSupport\database\seeders\ChatSeeder::class,
            \Modules\User\database\seeders\ProfileSeeder::class,
            \Modules\User\database\seeders\AddressSeeder::class,
            \Modules\User\database\seeders\UserSettingSeeder::class,
            \Modules\Authorization\database\seeders\PasswordResetSeeder::class,
        ]);

        // 3. Business entities
        $this->call([
            \Modules\Business\database\seeders\VendorSeeder::class,
            \Modules\Business\database\seeders\VendorProfileSeeder::class,
        ]);

        // 4. Product catalog
        $this->call([
            \Modules\Category\database\seeders\CollectionSeeder::class,
            \Modules\Category\database\seeders\CategorySeeder::class,
            \Modules\Category\database\seeders\BrandSeeder::class,
            \Modules\Product\database\seeders\ProductSeeder::class,
            \Modules\Category\database\seeders\ProductCategorySeeder::class,
            \Modules\Category\database\seeders\ProductBrandSeeder::class,
            \Modules\Category\database\seeders\ProductCollectionSeeder::class,
            \Modules\Product\database\seeders\ProductVariantSeeder::class,
            \Modules\Product\database\seeders\ProductMediaSeeder::class,
            \Modules\Product\database\seeders\ProductAttributeSeeder::class,
            \Modules\Product\database\seeders\AttributeVariantSeeder::class,
        ]);

        // 5. Cart and Wishlist
        $this->call([
            \Modules\Cart\database\seeders\CartSeeder::class,
            \Modules\PromotionAndCoupon\database\seeders\CouponSeeder::class,
            \Modules\Cart\database\seeders\CartCouponSeeder::class,
            \Modules\List\database\seeders\WishlistSeeder::class,
            \Modules\List\database\seeders\WishlistItemSeeder::class,
            \Modules\Cart\database\seeders\CartItemSeeder::class,
        ]);

        // 6. Orders and Transactions
        $this->call([
            \Modules\Order\database\seeders\OrderSeeder::class,
            \Modules\Order\database\seeders\OrderStatusSeeder::class,
            \Modules\Order\database\seeders\OrderInvoiceSeeder::class,
            \Modules\Order\database\seeders\VendorOrderSeeder::class,
            \Modules\Order\database\seeders\OrderItemSeeder::class,
            \Modules\Order\database\seeders\ReturnRequestSeeder::class,

            // Financial transactions
            \Modules\Payment\database\seeders\PaymentSeeder::class,
            \Modules\Payment\database\seeders\RefundSeeder::class,
            \Modules\Payment\database\seeders\TransactionSeeder::class,

            // Commissions and payouts
            \Modules\CommissionAndPayout\database\seeders\CommissionSeeder::class,
            \Modules\CommissionAndPayout\database\seeders\PayoutSeeder::class,
            \Modules\Business\database\seeders\VendorCommissionSeeder::class,
        ]);

        // 7. Reviews and ratings
        $this->call([
            \Modules\Reaction\database\seeders\ReviewSeeder::class,
            \Modules\Reaction\database\seeders\RatingSeeder::class,
        ]);
    }
}