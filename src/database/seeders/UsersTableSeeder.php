<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => '管理者',
            'email' => 'info@example.com',
            'password' => bcrypt('12345678'),
            'admin' => 0,
        ]);
        User::create([
            'name' => '店舗代表者',
            'email' => 'shop@example.com',
            'password' => bcrypt('12345678'),
            'admin' => 1,
        ]);

        User::factory()->count(10)->create();
    }
}
