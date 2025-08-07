<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {

        User::factory()->create([
            'name' => 'Test User Janus',
            'username' => 'janus-a4',
            'email' => 'janus@example.com',
            'password' => bcrypt('password'),
        ]);


        $categories = [
            'Technology',
            'Health',
            'Lifestyle',
            'Travel',
            'Food',
            'Education',
        ];
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        //Post::factory(100)->create();


        
        /*$this->call([
            PostSeeder::class,
        ]);*/
    }
}
