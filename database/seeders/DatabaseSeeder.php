<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Package;
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

        User::factory()->create([
            'name' => 'fazal',
            'email' => 'fazal@example.com',
            "password" => bcrypt("pass")
        ]);
        Feature::create([
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_jWDUppSUmwPpPE4VPWy3kWbkxVCwlQIn0g&s',
            'route_name' => 'feature1.index',
            "name" => "Calculate Sum",
            "description" => "calculate sum of two numbers",
            "required_credits" => 1,
            "active" => true
        ]);
        Feature::create([
            'image' => 'https://www.svgrepo.com/show/34372/minus.svg',
            'route_name' => 'feature2.index',
            "name" => "Calculate Different",
            "description" => "calculate Different of two numbers",
            "required_credits" => 3,
            "active" => true
        ]);
        Package::create([
            "name" => 'Basic',
            'price' => 5,
            "credits" => 20
        ]);
        Package::create([
            "name" => 'Silver',
            'price' => 20,
            "credits" => 100
        ]);
        Package::create([
            "name" => 'Gold',
            'price' => 50,
            "credits" => 500
        ]);
    }
}
