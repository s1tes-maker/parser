<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('menu_role')->count() != 0) return;
        DB::table('menu_role')->insert([
            ['menu_id' => 1, 'role_id' => 1],
            ['menu_id' => 2, 'role_id' => 1],
            ['menu_id' => 2, 'role_id' => 2],
            ['menu_id' => 1, 'role_id' => 2]
        ]);
    }
}
