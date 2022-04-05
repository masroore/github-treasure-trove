<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenusTableSeeder extends Seeder
{
    private $menuId;

    private $dropdownId = [];

    private $dropdown = false;

    private $sequence = 1;

    private $joinData = [];

    private $translationData = [];

    private $defaultTranslation = 'en';

    private $adminRole;

    private $userRole;

    public function join($roles, $menusId): void
    {
        $roles = explode(',', $roles);
        foreach ($roles as $role) {
            array_push($this->joinData, ['role_name' => $role, 'menus_id' => $menusId]);
        }
    }

    /*
        Function assigns menu elements to roles
        Must by use on end of this seeder
    */
    public function joinAllByTransaction(): void
    {
        DB::beginTransaction();
        foreach ($this->joinData as $data) {
            DB::table('menu_role')->insert([
                'role_name' => $data['role_name'],
                'menus_id' => $data['menus_id'],
            ]);
        }
        DB::commit();
    }

    public function addTranslation($lang, $name, $menuId): void
    {
        array_push($this->translationData, [
            'name' => $name,
            'lang' => $lang,
            'menus_id' => $menuId,
        ]);
    }

    /*
        Function insert All translations
        Must by use on end of this seeder
    */
    public function insertAllTranslations(): void
    {
        DB::beginTransaction();
        foreach ($this->translationData as $data) {
            DB::table('menus_lang')->insert([
                'name' => $data['name'],
                'lang' => $data['lang'],
                'menus_id' => $data['menus_id'],
            ]);
        }
        DB::commit();
    }

    public function insertLink($roles, $name, $href, $icon)
    {
        if ($this->dropdown === false) {
            DB::table('menus')->insert([
                'slug' => 'link',
                //'name' => $name,
                'icon' => $icon,
                'href' => $href,
                'menu_id' => $this->menuId,
                'sequence' => $this->sequence,
            ]);
        } else {
            DB::table('menus')->insert([
                'slug' => 'link',
                //'name' => $name,
                'icon' => $icon,
                'href' => $href,
                'menu_id' => $this->menuId,
                'parent_id' => $this->dropdownId[count($this->dropdownId) - 1],
                'sequence' => $this->sequence,
            ]);
        }
        ++$this->sequence;
        $lastId = DB::getPdo()->lastInsertId();
        $this->join($roles, $lastId);
        $this->addTranslation($this->defaultTranslation, $name, $lastId);
        $permission = Permission::where('name', '=', $name)->get();
        if (empty($permission)) {
            $permission = Permission::create(['name' => 'visit ' . $name]);
        }
        $roles = explode(',', $roles);
        if (in_array('user', $roles)) {
            $this->userRole->givePermissionTo($permission);
        }
        if (in_array('admin', $roles)) {
            $this->adminRole->givePermissionTo($permission);
        }

        return $lastId;

        return $lastId;
    }

    public function insertTitle($roles, $name)
    {
        DB::table('menus')->insert([
            'slug' => 'title',
            //'name' => $name,
            'menu_id' => $this->menuId,
            'sequence' => $this->sequence,
        ]);
        ++$this->sequence;
        $lastId = DB::getPdo()->lastInsertId();
        $this->join($roles, $lastId);
        $this->addTranslation($this->defaultTranslation, $name, $lastId);

        return $lastId;
    }

    public function beginDropdown($roles, $name, $icon)
    {
        if (count($this->dropdownId)) {
            $parentId = $this->dropdownId[count($this->dropdownId) - 1];
        } else {
            $parentId = null;
        }
        DB::table('menus')->insert([
            'slug' => 'dropdown',
            //'name' => $name,
            'icon' => $icon,
            'menu_id' => $this->menuId,
            'sequence' => $this->sequence,
            'parent_id' => $parentId,
        ]);
        $lastId = DB::getPdo()->lastInsertId();
        $this->dropdownId[] = $lastId;
        $this->dropdown = true;
        ++$this->sequence;
        $this->join($roles, $lastId);
        $this->addTranslation($this->defaultTranslation, $name, $lastId);

        return $lastId;
    }

    public function endDropdown(): void
    {
        $this->dropdown = false;
        array_pop($this->dropdownId);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $this->adminRole = Role::where('name', '=', 'admin')->first();
        $this->userRole = Role::where('name', '=', 'user')->first();
        // Create Sidebar menu
        DB::table('menulist')->insert([
            'name' => 'sidebar menu',
        ]);
        $this->menuId = DB::getPdo()->lastInsertId();  //set menuId
        // Create Translation languages
        DB::table('menu_lang_lists')->insert([
            'name' => 'English',
            'short_name' => 'en',
            'is_default' => true,
        ]);
        DB::table('menu_lang_lists')->insert([
            'name' => 'Polish',
            'short_name' => 'pl',
        ]);
        // sidebar menu
        $id = $this->insertLink('guest,admin', 'Dashboard', '/', 'cil-speedometer');
        $this->addTranslation('pl', 'Panel', $id);

        $id = $this->beginDropdown('admin', 'Settings', 'cil-calculator');
        $this->addTranslation('pl', 'Ustawienia', $id);
        $id = $this->insertLink('admin', 'Notes', '/notes', 'iconoDePrueba');
        $this->addTranslation('pl', 'Notatki', $id);
        $id = $this->insertLink('admin', 'Users', '/users', 'iconoDePrueba');
        $this->addTranslation('pl', 'Urzytkownicy', $id);
        $id = $this->insertLink('admin', 'Edit menu', '/menu/menu', 'iconoDePrueba');
        $this->addTranslation('pl', 'Edycja Menu', $id);
        $id = $this->insertLink('admin', 'Edit roles', '/roles', 'iconoDePrueba');
        $this->addTranslation('pl', 'Edycja Ról', $id);
        $id = $this->insertLink('admin', 'Media', '/media', 'iconoDePrueba');
        $this->addTranslation('pl', 'Media', $id);
        $id = $this->insertLink('admin', 'BREAD', '/bread', 'iconoDePrueba');
        $this->addTranslation('pl', 'BREAD', $id);
        $id = $this->insertLink('admin', 'Email', '/mail', 'iconoDePrueba');
        $this->addTranslation('pl', 'Email', $id);
        $id = $this->insertLink('admin', 'Manage Languages', '/languages', 'iconoDePrueba');
        $this->addTranslation('pl', 'Edytuj języki', $id);
        $this->endDropdown();

        $id = $this->insertLink('guest', 'Login', '/login', 'cil-account-logout');
        $this->addTranslation('pl', 'Logowanie', $id);
        $id = $this->insertLink('guest', 'Register', '/register', 'cil-account-logout');
        $this->addTranslation('pl', 'Rejestracja', $id);

        $id = $this->insertTitle('admin', 'Theme');
        $this->addTranslation('pl', 'Motyw', $id);
        $id = $this->insertLink('admin', 'Colors', '/colors', 'cil-drop1');
        $this->addTranslation('pl', 'Kolory', $id);
        $id = $this->insertLink('admin', 'Typography', '/typography', 'cil-pencil');
        $this->addTranslation('pl', 'Typografia', $id);
        $id = $this->insertTitle('admin', 'Components');
        $this->addTranslation('pl', 'Komponenty', $id);

        //$id = $this->beginDropdown('user,admin', 'Motor de Búsqueda', 'cil-search'); //cib-twitter
        //$this->addTranslation('pl', 'Tablice', $id);

        $id = $this->insertLink('user,admin,gestor', 'Mantenedores de Datos', '/mantenedores', 'cil-columns');
        $this->addTranslation('pl', 'Mantenedores', $id);

        $id = $this->insertLink('user,admin,gestor', 'Gastos por Establecimiento', '/reportes', 'cil-chart');
        $this->addTranslation('pl', 'Reportes', $id);

        /*$id = $this->insertLink('user,admin,gestor', 'Buscador','/tables/buscador', 'cil-search');
        $this->addTranslation('pl', 'Buscador', $id);

        $id = $this->insertLink('user,admin,gestor', 'Resultados: Redes Sociales','/tables/consulta_resultados_def', 'cil-globe-alt');
        $this->addTranslation('pl', 'Consulta resultados de la búsuqeda', $id);

        $id = $this->insertLink('user,admin,gestor', 'Resultados: Medios Sociales','/tables/consulta_medios', 'cil-rss');
        $this->addTranslation('pl', 'Consulta resultados de la búsuqeda', $id);

        $id = $this->insertLink('user,admin,gestor', 'Campañas','/tables/campañas_def', 'cil-newspaper');
        $this->addTranslation('pl', 'Campañas', $id);

        $id = $this->insertLink('admin,gestor', 'Exportar Base de Datos','/tables/export_all_database', 'cil-data-transfer-down');
        $this->addTranslation('pl', 'Export', $id);

        $id = $this->beginDropdown('gestor', 'Panel de Control', 'cil-puzzle');
        $this->addTranslation('pl', 'Control Panel', $id);

            $id = $this->insertLink('gestor', 'Busquedas','/control_busquedas', 'cil-data-transfer-down');
            $this->addTranslation('pl', 'Busquedas', $id);

            $id = $this->insertLink('gestor', 'Resultados Asincronos','/control_async', 'cil-data-transfer-down');
            $this->addTranslation('pl', 'Async', $id);

            $id = $this->insertLink('gestor', 'Web Services','/control_ws', 'cil-data-transfer-down');
            $this->addTranslation('pl', 'WS', $id);

            $id = $this->insertLink('gestor', 'Usuarios','/control_roles', 'cil-data-transfer-down');
            $this->addTranslation('pl', 'Users', $id);

            $id = $this->insertLink('gestor', 'Medios Sociales','/control_medios', 'cil-data-transfer-down');
            $this->addTranslation('pl', 'Media RSS', $id);
            */

        $this->endDropdown();

        /*$id = $this->insertLink('user,admin', 'Menú Dashboard','/tables/menu_dashboard', 'iconoDePrueba');
        $this->addTranslation('pl', 'Menú Dashboard', $id);*/
        /*$id = $this->insertLink('admin', 'TwitterTables','/tables/twittertables');
        $this->addTranslation('pl', 'Tablas de busqueda Twitter', $id);*/

        //$this->endDropdown();

        $id = $this->beginDropdown('admin', 'Base', 'cil-puzzle');
        $this->addTranslation('pl', 'Podstawa', $id);
        $id = $this->insertLink('admin', 'Breadcrumb', '/base/breadcrumb', 'iconoDePrueba');
        $this->addTranslation('pl', 'Chlebek', $id);
        $id = $this->insertLink('admin', 'Cards', '/base/cards', 'iconoDePrueba');
        $this->addTranslation('pl', 'Karty', $id);
        $id = $this->insertLink('admin', 'Carousel', '/base/carousel', 'iconoDePrueba');
        $this->addTranslation('pl', 'Karuzela', $id);
        $id = $this->insertLink('admin', 'Collapse', '/base/collapse', 'iconoDePrueba');
        $this->addTranslation('pl', 'Zapadki', $id);
        $id = $this->insertLink('admin', 'Jumbotron', '/base/jumbotron', 'iconoDePrueba');
        $this->addTranslation('pl', 'Karta', $id);
        $id = $this->insertLink('admin', 'List group', '/base/list-group', 'iconoDePrueba');
        $this->addTranslation('pl', 'Zgrupowana lista', $id);
        $id = $this->insertLink('admin', 'Navs', '/base/navs', 'iconoDePrueba');
        $this->addTranslation('pl', 'Nawigacja', $id);
        $id = $this->insertLink('admin', 'Pagination', '/base/pagination', 'iconoDePrueba');
        $this->addTranslation('pl', 'Paginacja', $id);
        $id = $this->insertLink('admin', 'Popovers', '/base/popovers', 'iconoDePrueba');
        $this->addTranslation('pl', 'Podpowiedź', $id);
        $id = $this->insertLink('admin', 'Progress', '/base/progress', 'iconoDePrueba');
        $this->addTranslation('pl', 'Pasek postępu', $id);
        $id = $this->insertLink('admin', 'Scrollspy', '/base/scrollspy', 'iconoDePrueba');
        $this->addTranslation('pl', 'Śledzenie przesunięcia', $id);
        $id = $this->insertLink('admin', 'Switches', '/base/switches', 'iconoDePrueba');
        $this->addTranslation('pl', 'Przełączniki', $id);
        $id = $this->insertLink('admin', 'Tabs', '/base/tabs', 'iconoDePrueba');
        $this->addTranslation('pl', 'Zakładki', $id);
        $id = $this->insertLink('admin', 'Tooltips', '/base/tooltips', 'iconoDePrueba');
        $this->addTranslation('pl', 'Wskazówka', $id);
        $this->endDropdown();
        $id = $this->beginDropdown('admin', 'Buttons', 'cil-cursor');
        $this->addTranslation('pl', 'Przyciski', $id);
        $id = $this->insertLink('admin', 'Buttons', '/buttons/buttons', 'iconoDePrueba');
        $this->addTranslation('pl', 'Przyciski', $id);
        $id = $this->insertLink('admin', 'Brand Buttons', '/buttons/brand-buttons', 'iconoDePrueba');
        $this->addTranslation('pl', 'Przyciski z logotypami', $id);
        $id = $this->insertLink('admin', 'Buttons Group', '/buttons/button-group', 'iconoDePrueba');
        $this->addTranslation('pl', 'Grupy przycisków', $id);
        $id = $this->insertLink('admin', 'Dropdowns', '/buttons/dropdowns', 'iconoDePrueba');
        $this->addTranslation('pl', 'Przyciski z rozwijanym menu', $id);
        $id = $this->insertLink('admin', 'Loading Buttons', '/buttons/loading-buttons', 'iconoDePrueba');
        $this->addTranslation('pl', 'Przyciski z oczekiwaniem', $id);
        $this->endDropdown();
        $id = $this->insertLink('admin', 'Charts', '/charts', 'cil-chart-pie');
        $this->addTranslation('pl', 'Wykresy', $id);
        $id = $this->beginDropdown('admin', 'Editors', 'cil-code');
        $this->addTranslation('pl', 'Edytor', $id);
        $id = $this->insertLink('admin', 'Code Editor', '/editors/code-editor', 'iconoDePrueba');
        $this->addTranslation('pl', 'Edytor kodu', $id);
        $id = $this->insertLink('admin', 'Markdown', '/editors/markdown-editor', 'iconoDePrueba');
        $this->addTranslation('pl', 'Edytor markdown', $id);
        $id = $this->insertLink('admin', 'Rich Text Editor', '/editors/text-editor', 'iconoDePrueba');
        $this->addTranslation('pl', 'Bogaty edytor tekstu', $id);
        $this->endDropdown();
        $id = $this->beginDropdown('admin', 'Forms', 'cil-notes');
        $this->addTranslation('pl', 'Formularze', $id);
        $id = $this->insertLink('admin', 'Basic Forms', '/forms/basic-forms', 'iconoDePrueba');
        $this->addTranslation('pl', 'Podstawowe formularze', $id);
        $id = $this->insertLink('admin', 'Advanced', '/forms/advanced-forms', 'iconoDePrueba');
        $this->addTranslation('pl', 'Zaawansowane formularze', $id);
        $id = $this->insertLink('admin', 'Validation', '/forms/validation', 'iconoDePrueba');
        $this->addTranslation('pl', 'Walidacja', $id);
        $this->endDropdown();
        $id = $this->insertLink('admin', 'Google Maps', '/google-maps', 'cil-map');
        $this->addTranslation('pl', 'Mapy Google', $id);
        $id = $this->beginDropdown('admin', 'Icons', 'cil-star');
        $this->addTranslation('pl', 'Ikony', $id);
        $id = $this->insertLink('admin', 'CoreUI Icons', '/icon/coreui-icons', 'iconoDePrueba');
        $this->addTranslation('pl', 'CoreUI ikony', $id);
        $id = $this->insertLink('admin', 'Flags', '/icon/flags', 'iconoDePrueba');
        $this->addTranslation('pl', 'Flagi', $id);
        $id = $this->insertLink('admin', 'Brands', '/icon/brands', 'iconoDePrueba');
        $this->addTranslation('pl', 'Logotypy', $id);
        $this->endDropdown();
        $id = $this->beginDropdown('admin', 'Notifications', 'cil-bell');
        $this->addTranslation('pl', 'Powiadomienia', $id);
        $id = $this->insertLink('admin', 'Alerts', '/notifications/alerts', 'iconoDePrueba');
        $this->addTranslation('pl', 'Alerty', $id);
        $id = $this->insertLink('admin', 'Badge', '/notifications/badge', 'iconoDePrueba');
        $this->addTranslation('pl', 'Etykieta', $id);
        $id = $this->insertLink('admin', 'Modals', '/notifications/modals', 'iconoDePrueba');
        $this->addTranslation('pl', 'Okno powiadomienia', $id);
        $id = $this->insertLink('admin', 'Toastr', '/notifications/toastr', 'iconoDePrueba');
        $this->addTranslation('pl', 'Tosty', $id);
        $this->endDropdown();
        $id = $this->beginDropdown('admin', 'Plugins', 'cil-bolt');
        $this->addTranslation('pl', 'Wtyczki', $id);
        $id = $this->insertLink('admin', 'Calendar', '/plugins/calendar', 'iconoDePrueba');
        $this->addTranslation('pl', 'Kalendarz', $id);
        $id = $this->insertLink('admin', 'Draggable', '/plugins/draggable-cards', 'iconoDePrueba');
        $this->addTranslation('pl', 'Elementy przesówne', $id);
        $id = $this->insertLink('admin', 'Spinners', '/plugins/spinners', 'iconoDePrueba');
        $this->addTranslation('pl', 'Kręciołki', $id);
        $this->endDropdown();
        $id = $this->beginDropdown('admin', 'Tables', 'cil-columns');
        $this->addTranslation('pl', 'Tablice', $id);

        $id = $this->insertLink('admin', 'Standard Tables', '/tables/tables', 'iconoDePrueba');
        $this->addTranslation('pl', 'Standardowe tablice', $id);

        $id = $this->insertLink('admin', 'DataTables', '/tables/datatables', 'iconoDePrueba');
        $this->addTranslation('pl', 'Arkusze danych', $id);

        $this->endDropdown();
        $id = $this->insertLink('admin', 'Widgets', '/widgets', 'cil-calculator');
        $this->addTranslation('pl', 'Widżety', $id);
        $id = $this->insertTitle('admin', 'Extras');
        $this->addTranslation('pl', 'Ekstra', $id);
        $id = $this->beginDropdown('admin', 'Pages', 'cil-star');
        $this->addTranslation('pl', 'Strony', $id);
        $id = $this->insertLink('admin', 'Login', '/login', 'iconoDePrueba');
        $this->addTranslation('pl', 'Logowanie', $id);
        $id = $this->insertLink('admin', 'Register', '/register', 'iconoDePrueba');
        $this->addTranslation('pl', 'Rejestracja', $id);
        $id = $this->insertLink('admin', 'Error 404', '/404', 'iconoDePrueba');
        $this->addTranslation('pl', 'Błąd 404', $id);
        $id = $this->insertLink('admin', 'Error 500', '/500', 'iconoDePrueba');
        $this->addTranslation('pl', 'Błąd 500', $id);
        $this->endDropdown();
        $id = $this->beginDropdown('admin', 'Apps', 'cil-layers');
        $this->addTranslation('pl', 'Aplikacje', $id);
        $id = $this->beginDropdown('admin', 'Invoicing', 'cil-description');
        $this->addTranslation('pl', 'Faktury', $id);
        $id = $this->insertLink('admin', 'Invoice', '/apps/invoicing/invoice', 'iconoDePrueba');
        $this->addTranslation('pl', 'Faktura', $id);
        $this->endDropdown();
        $id = $this->beginDropdown('admin', 'Email', 'cil-envelope-open');
        $this->addTranslation('pl', 'E-mail', $id);
        $id = $this->insertLink('admin', 'Inbox', '/apps/email/inbox', 'iconoDePrueba');
        $this->addTranslation('pl', 'Skrzynka odbiorcza', $id);
        $id = $this->insertLink('admin', 'Message', '/apps/email/message', 'iconoDePrueba');
        $this->addTranslation('pl', 'Wiadomość', $id);
        $id = $this->insertLink('admin', 'Compose', '/apps/email/compose', 'iconoDePrueba');
        $this->addTranslation('pl', 'Nowa wiadomość', $id);
        $this->endDropdown();
        $this->endDropdown();

        $id = $this->insertLink('guest,admin', 'Download CoreUI', 'https://coreui.io', 'cil-cloud-download');
        $this->addTranslation('pl', 'Pobierz CoreUI', $id);
        $id = $this->insertLink('guest,admin', 'Try CoreUI PRO', 'https://coreui.io/pro/', 'cil-layers');
        $this->addTranslation('pl', 'Wypróbuj CoreUI PRO', $id);

        /* Create top menu
        DB::table('menulist')->insert([
            'name' => 'top menu'
        ]);
        $this->menuId = DB::getPdo()->lastInsertId();  //set menuId
        $id = $this->insertLink('guest,admin', 'Dashboard',    '/');
        $this->addTranslation('pl', 'Panel', $id);
        $id = $this->insertLink('admin', 'Notes',              '/notes');
        $this->addTranslation('pl', 'Notatki', $id);
        $id = $this->insertLink('admin', 'Users',                   '/users');
        $this->addTranslation('pl', 'Urzytkownicy', $id);
        $id = $this->beginDropdown('admin', 'Settings');
        $this->addTranslation('pl', 'Ustawienia', $id);

        $id = $this->insertLink('admin', 'Edit menu',               '/menu/menu');
        $this->addTranslation('pl', 'Edytuj Menu', $id);
        $id = $this->insertLink('admin', 'Edit menu elements',      '/menu/element');
        $this->addTranslation('pl', 'Edytuj elementy menu', $id);
        $id = $this->insertLink('admin', 'Manage Languages',          '/languages');
        $this->addTranslation('pl', 'Edytuj języki', $id);
        $id = $this->insertLink('admin', 'Edit roles',              '/roles');
        $this->addTranslation('pl', 'Edytuj role', $id);
        $id = $this->insertLink('admin', 'Media',                   '/media');
        $this->addTranslation('pl', 'Media', $id);
        $id = $this->insertLink('admin', 'BREAD',                   '/bread');
        $this->addTranslation('pl', 'BREAD', $id);

        $this->endDropdown();
        */

        $this->joinAllByTransaction();   ///   <===== Must by use on end of this seeder
        $this->insertAllTranslations();  ///   <===== Must by use on end of this seeder
    }
}
