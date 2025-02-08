<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MasterSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        User::factory()->create([
            'name' => 'Dimas',
            'email' => 'dimas@mail.com',
            'password' => bcrypt('password')
        ]);
        
        $this->call([
            MasterSeeder::class
        ]);
        
        Product::factory(20)->create();
    }
}
