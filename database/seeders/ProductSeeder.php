<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // format เวลา เป็น lib ของ laravel
use App\Models\Product;



class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ลบข้อมูลออกไปก่อน
        DB::table('products')->delete();
    
        // เรียก user factory เพื่อ fake ข้อมูล
        Product::factory(5000)->create();
    }
}
