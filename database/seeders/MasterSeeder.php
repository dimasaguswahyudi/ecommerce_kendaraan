<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() :void
    {
        $categories = [
            'Kudu Entek',
            'Ban Motor',
            'Ban Mobil',
            'Oli Motor',
            'Oli Mobil',
            'Oli Transmisi Dan Oli Samping',
            'Bodyparts Motor',
            'Bodyparts Mobil',
            'Aki Motor',
            'Aki Mobil',
            'Grease Oil',
            'Minyak Rem, Rantai dan Pelumas Lainnya',
            'Cairan Pendingin & Cairan Pembersih lainnya',
            'Body Repair',
            'Oli Outboard',
            'Cairan Pendingin & Cairan Pembersih Mobil Lainnya',
            'Oli Transmisi & Oli Power Steering Mobil',
            'Aki Mobil',
            'Bodyparts Mobil',
        ];

        $categoryIds = [];

        foreach ($categories as $category) {
            $createdCategory = Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);

            // Simpan ID kategori berdasarkan nama
            $categoryIds[$category] = $createdCategory->id;
        }

        // Ambil ID kategori "Kudu Entek"
        $kuduEntekId = $categoryIds['Kudu Entek'] ?? null;

        if ($kuduEntekId) {
            $discounts = [
                ['name' => 'Kudu Entek Discount 30%', 'disc_percent' => 30],
                ['name' => 'Kudu Entek Discount 40%', 'disc_percent' => 40],
                ['name' => 'Kudu Entek Discount 50%', 'disc_percent' => 50],
                ['name' => 'Kudu Entek Discount 60%', 'disc_percent' => 60],
            ];

            foreach ($discounts as $disc) {
                Discount::create([
                    'name' => $disc['name'],
                    'category_id' => $kuduEntekId, // Menggunakan ID dari kategori "Kudu Entek"
                    'disc_percent' => $disc['disc_percent']
                ]);
            }
        }
    }
}
