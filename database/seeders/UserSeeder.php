<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('users')->count() != 0) return;
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 's1tes-maker@ya.ru',
            //'password' => Hash::make('password'),
            'password' => '$2y$10$buTFCJ8dGY3S/WoZj4e3o.mZ68R/F/02NzILwRxshFLUV2KEhKGA2',
            'role_id' => 1,
        ]);
    }
}
