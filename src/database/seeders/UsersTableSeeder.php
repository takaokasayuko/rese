<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => '管理者',
            'email' => 'info@example.com',
            'password' => bcrypt('12345678'),
            'admin' => 0,
        ]);
        DB::table('users')->insert([
            'name' => '店舗代表者',
            'email' => 'shop@example.com',
            'password' => bcrypt('12345678'),
            'admin' => 1,
        ]);
    }
}
