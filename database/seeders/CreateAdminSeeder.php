<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'lethuybinh',
            'password' => Hash::make('12345678'),
            'name' => 'Lê Thị Thúy Bình'
        ]);

        User::create([
            'username' => 'danhdat',
            'password' => Hash::make('12345678'),
            'name' => 'Danh Đạt'
        ]);
    }
}
