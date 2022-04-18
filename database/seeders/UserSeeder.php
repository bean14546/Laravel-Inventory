<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ลบข้อมูลออกไปก่อน
        DB::table('users')->delete();

        // เรียก user factory เพื่อ fake ข้อมูล
        User::factory(100)->create();
    }
}
