<?php

use Illuminate\Database\Seeder;

class IntegrateLocale extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Fomvasss\UrlAliases\Models\UrlAlias::all()->map(function ($item): void {
            if (empty($item->locale_bound)) {
                $item->locale_bound = \Illuminate\Support\Str::uuid()->toString();
                $item->save();
            }
        });

        \Fomvasss\UrlAliases\Models\UrlAlias::where('alias', '/')->update([
            'alias' => 'ru',
        ]);

        $tables = [
            'terms',
            'products',
            'attributes',
            'values',
            'sales',
            'pages',
            'news',
            'orders',
            'forms',
            //'variables',
        ];
        foreach ($tables as $table) {
            \Illuminate\Support\Facades\DB::table($table)->whereNull('locale')
                ->update(['locale' => 'ru']);
        }

        \App\Models\Menu\MenuItem::whereHas('menu', function ($q): void {
            $q->where('system_name', 'main_menu');
        })->update(['locale' => 'ru']);

        \Fomvasss\Variable\Models\Variable::whereNotNull('locale')->update(['locale' => null]);
        \Fomvasss\Variable\Models\Variable::whereIn('key', config('variables.localable', []))->get()
            ->map(function ($item): void {
                if (!\Fomvasss\Variable\Models\Variable::where([
                    'key' => $item->key,
                    'locale' => 'ru',
                ])->first()) {
                    $item->update(['locale' => 'ru']);
                }
            });
    }
}
