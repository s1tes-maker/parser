<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('menus')->count() != 0) return;
        DB::table('menus')->insert([
            [
                'title' => 'Настройка запуска',
                'key' => 'Home',
                'icon' => 'icon-cog',
                'order'=> 1],

            [
                'title' => 'Мониторинг процессов',
                'key' => 'statuses',
                'icon' => 'icon-paper',
                'order'=> 2]
        ]);
    }
}
