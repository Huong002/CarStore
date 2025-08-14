<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Employee;
use App\Models\OrderDetail;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,

            CustomerSeeder::class,
            EmployeeSeeder::class,

            UserSeeder::class,
            ColorSeeder::class,
            ProductSeeder::class,
            CartSeeder::class,
            CartItemSeeder::class,
            ImageSeeder::class,

            OrderSeeder::class,
            OrderDetailSeeder::class,
            ReviewsTableSeeder::class,
            NotificationSeeder::class,
            UserNotificationSeeder::class,

            // Blog-related seeders
            BlogCategorySeeder::class,
            BlogSeeder::class,
            BlogCommentSeeder::class,
            FaqSeeder::class,
        ]);
    }
}