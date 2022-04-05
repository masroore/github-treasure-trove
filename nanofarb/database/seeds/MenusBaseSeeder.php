<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 11.02.19
 * Time: 18:39.
 */
abstract class MenusBaseSeeder extends \Illuminate\Database\Seeder
{
    protected function seedMenu(array $menus): void
    {
        foreach ($menus as $menu) {
            $menu_model = \App\Models\Menu\Menu::updateOrCreate([
                'system_name' => $menu['system_name'],
            ], [
                'name' => $menu['name'],
                'data' => $menu['data'] ?? null,
                'safe' => $menu['safe'] ?? true,
            ]);
            if (!empty($menu['children'])) {
                $this->seedMenuItem($menu['children'], $menu_model->id);
            }
        }
    }

    protected function seedMenuItem(array $menu_items, int $menu_id, ?int $parent_id = null): void
    {
        foreach ($menu_items as $menu_item) {
            $menu_item_model = \App\Models\Menu\MenuItem::updateOrCreate([
                'name' => $menu_item['name'],
                'menu_id' => $menu_id,
            ], [
                'parent_id' => $parent_id,
                'path' => $menu_item['path'] ?? null,
                'target' => $menu_item['target'] ?? null,
                'data' => $menu_item['data'] ?? null,
            ]);
            if (!empty($menu_item['children'])) {
                $this->seedMenuItem($menu_item['children'], $menu_id, $menu_item_model->id);
            }
        }
    }

    abstract public function getData(): array;
}
