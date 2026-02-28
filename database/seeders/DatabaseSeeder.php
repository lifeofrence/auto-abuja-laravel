<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Business;
use App\Models\Product;
use App\Models\News;
use App\Models\Advertisement;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Categories
        $categories = [
            ['name' => 'Auto Mechanics & Technicians', 'slug' => 'mechanics', 'description' => 'Find certified mechanics and workshops', 'icon' => 'fa-wrench'],
            ['name' => 'Automobile Dealerships', 'slug' => 'dealers', 'description' => 'Reliable car dealers and showrooms', 'icon' => 'fa-car'],
            ['name' => 'Auto Spare Parts', 'slug' => 'spare-parts', 'description' => 'Genuine spare parts', 'icon' => 'fa-cogs'],
            ['name' => 'Tow Truck Operators', 'slug' => 'towing', 'description' => '24/7 towing services', 'icon' => 'fa-truck-pickup'],
            ['name' => 'Auto Dismantlers & Recyclers', 'slug' => 'recyclers', 'description' => 'Recycling services', 'icon' => 'fa-recycle'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 2. Subcategories
        $subcategories = [
            ['cat' => 'mechanics', 'name' => 'Grade A - Standardized Workshops', 'slug' => 'grade-a'],
            ['cat' => 'dealers', 'name' => 'Used Vehicles (Tokunbo)', 'slug' => 'tokunbo'],
            ['cat' => 'spare-parts', 'name' => 'Light Duty Parts', 'slug' => 'light-duty'],
            ['cat' => 'towing', 'name' => 'Emergency Towing', 'slug' => 'emergency'],
        ];

        foreach ($subcategories as $sub) {
            $catId = Category::where('slug', $sub['cat'])->first()->id;
            Subcategory::firstOrCreate(
                ['slug' => $sub['slug'], 'category_id' => $catId],
                ['name' => $sub['name']]
            );
        }

        // 3. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@autoabuja.com'],
            ['name' => 'System Admin', 'phone' => '08000000000', 'password' => Hash::make('admin123'), 'role' => 'admin', 'status' => 'active']
        );

        // 4. Users
        $usersData = [
            ['email' => 'tech@autoabuja.com', 'name' => 'Musa Mechanics', 'phone' => '08022221111', 'password' => Hash::make('password'), 'role' => 'user', 'status' => 'active'],
            ['email' => 'sales@abuja-autos.com', 'name' => 'Abuja Auto Sales', 'phone' => '08033332222', 'password' => Hash::make('password'), 'role' => 'user', 'status' => 'active'],
            ['email' => 'john@towing.com', 'name' => 'John Towing Services', 'phone' => '08044443333', 'password' => Hash::make('password'), 'role' => 'user', 'status' => 'active'],
            ['email' => 'spareparts@kado.com', 'name' => 'Kado Parts World', 'phone' => '08055554444', 'password' => Hash::make('password'), 'role' => 'user', 'status' => 'active'],
            ['email' => 'user@example.com', 'name' => 'Abuja Car Owner', 'phone' => '08066665555', 'password' => Hash::make('password'), 'role' => 'user', 'status' => 'active'],
        ];
        foreach ($usersData as $u) {
            User::firstOrCreate(['email' => $u['email']], $u);
        }

        $uTech = User::where('email', 'tech@autoabuja.com')->first()->id;
        $uSales = User::where('email', 'sales@abuja-autos.com')->first()->id;
        $uSpare = User::where('email', 'spareparts@kado.com')->first()->id;
        $uTowing = User::where('email', 'john@towing.com')->first()->id;
        $uCustomer = User::where('email', 'user@example.com')->first()->id;

        // 5. Businesses
        $businessesData = [
            [
                'user_id' => $uTech,
                'category_id' => Category::where('slug', 'mechanics')->first()->id,
                'subcategory_id' => Subcategory::where('slug', 'grade-a')->first()->id,
                'business_name' => 'Musa Advanced Technicians',
                'slug' => 'musa-advanced-technicians',
                'description' => 'Modern auto-repair center specializing in German and Japanese vehicles.',
                'address' => 'Plot 44, Garki II Industrial Area, Abuja',
                'phone' => '08022221111',
                'email' => 'info@musatech.com',
                'status' => 'approved',
                'is_featured' => true
            ],
            [
                'user_id' => $uSales,
                'category_id' => Category::where('slug', 'dealers')->first()->id,
                'subcategory_id' => Subcategory::where('slug', 'tokunbo')->first()->id,
                'business_name' => 'Unity Car Showroom',
                'slug' => 'unity-car-showroom',
                'description' => 'The best Tokyo-imported vehicles in Abuja.',
                'address' => 'Beside Banex Plaza, Wuse 2, Abuja',
                'phone' => '08033332222',
                'email' => 'sales@unitycars.com',
                'status' => 'approved',
                'is_featured' => true
            ],
            [
                'user_id' => $uSpare,
                'category_id' => Category::where('slug', 'spare-parts')->first()->id,
                'subcategory_id' => Subcategory::where('slug', 'light-duty')->first()->id,
                'business_name' => 'Kado Genuine Parts',
                'slug' => 'kado-genuine-parts',
                'description' => 'Wholesale and retail of genuine Toyota, Honda, and Nissan spare parts.',
                'address' => 'Shop 22, Kado Spare Parts Market, Abuja',
                'phone' => '08055554444',
                'email' => 'parts@kadoworld.com',
                'status' => 'approved',
                'is_featured' => false
            ],
            [
                'user_id' => $uTowing,
                'category_id' => Category::where('slug', 'towing')->first()->id,
                'subcategory_id' => Subcategory::where('slug', 'emergency')->first()->id,
                'business_name' => 'Abuja Rapid Response Towing',
                'slug' => 'abuja-rapid-response-towing',
                'description' => '24/7 emergency roadside assistance and towing.',
                'address' => 'Opposite Total Filling Station, Berger, Abuja',
                'phone' => '08044443333',
                'email' => 'help@abujatowing.com',
                'status' => 'approved',
                'is_featured' => false
            ],
        ];

        foreach ($businessesData as $b) {
            Business::firstOrCreate(['slug' => $b['slug']], $b);
        }

        // 6. Products
        foreach (Business::all() as $biz) {
            $products = [];
            if (strpos($biz->business_name, 'Technicians') !== false) {
                $products = [['name' => 'Full Engine Overhaul', 'price' => 150000], ['name' => 'Computerized Diagnostic Scan', 'price' => 10000]];
            } elseif (strpos($biz->business_name, 'Showroom') !== false) {
                $products = [['name' => '2015 Toyota Camry (Tokunbo)', 'price' => 7500000], ['name' => '2018 Honda Accord (Tokunbo)', 'price' => 9800000]];
            } elseif (strpos($biz->business_name, 'Parts') !== false) {
                $products = [['name' => 'Toyota Brake Pads (Set)', 'price' => 12000], ['name' => 'Premium Oil Filter', 'price' => 3500]];
            } elseif (strpos($biz->business_name, 'Towing') !== false) {
                $products = [['name' => 'City Towing', 'price' => 15000], ['name' => 'Jump Start Service', 'price' => 5000]];
            }

            foreach ($products as $p) {
                Product::firstOrCreate(
                    ['slug' => Str::slug($p['name'])],
                    ['business_id' => $biz->id, 'user_id' => $biz->user_id, 'name' => $p['name'], 'price' => $p['price'], 'is_available' => true]
                );
            }

            // Generate a review for each business
            Review::firstOrCreate(
                ['business_id' => $biz->id, 'user_id' => $uCustomer],
                ['rating' => 5, 'review_text' => 'Great service! Highly recommended.', 'status' => 'approved']
            );
            $biz->update(['rating_average' => 5, 'rating_count' => 1]);
        }

        // 7. News & Ads
        News::firstOrCreate(['slug' => 'vio-abuja-new-standards'], [
            'title' => 'VIO Abuja Begins New Inspection Standards',
            'content' => 'The Directorate of Road Traffic Services (DRTS) in Abuja has announced a new set of inspection standards...',
            'category' => 'Regulation',
            'author_id' => $admin->id,
            'status' => 'published',
            'is_featured' => true
        ]);

        Advertisement::firstOrCreate(['title' => 'Premium Car Wash'], [
            'image' => 'img/ads/carwash.jpg',
            'position' => 'sidebar',
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
            'is_active' => true
        ]);
    }
}
