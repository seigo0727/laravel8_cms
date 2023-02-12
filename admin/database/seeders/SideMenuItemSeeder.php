<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SideMenuItem;

class SideMenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new \DateTime();
        $count = 1;
        $menu = new SideMenuItem();
        $menu->title = '左メニュー';
        $menu->type = 'link';
        $menu->icon = 'fas fa-list-ul';
        $menu->route = 'side_menu_items';
        $menu->belong_to = 'master';
        $menu->sort_num = $count++;
        $menu->status = 'public';
        $menu->save();
    }
}
