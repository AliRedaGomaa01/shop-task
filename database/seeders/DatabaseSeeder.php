<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'a',
            'email' => 'a@a.a',
            'password' => bcrypt('a')
        ]);

        foreach (['ad1' , 'ad2'] as $admin) {
            Admin::create([
                'name' => $admin ,
                'email' => $admin . '@a.a',
                'password' => bcrypt($admin)
            ]);
        }

        $categories = ['category 1' , 'category 2' , 'category 3' , 'category 4' , 'category 5']; 
        
        foreach ( $categories as $category) {
            Category::create([
                'title' => $category,
            ]);
        }

        $productTitles = ['title 1' , 'title 2' , 'title 3' , 'title 4' , 'title 5'];
        $productDetails = ['details 1' , 'details 2' , 'details 3' , 'details 4' , 'details 5'];
        $productImages = ['1.png' , '2.png' , '3.png'];

        foreach ( range(1,5) as $index) {

            shuffle($productImages);

            Product::create([
                'title' => $productTitles[$index - 1],
                'details' => $productDetails[$index - 1],
                'image' => 'images/' . $productImages[0],
                'category_id' => rand(1,5),
                'price' => rand(10,20),
            ]);

        }

        foreach ( ['create products' , 'create categories'] as $name) {
            Permission::create([
                'name' => $name,
            ]);
        }

        foreach ( Admin::all() as $index => $admin )  {
            $admin->permissions()->attach( $index + 1);
        }
    }
}
