<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\AccountCategory;
use Modules\Account\Entities\ChartAccount;
use Modules\Attendance\Entities\Attendance;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\StockReport;
use Modules\Product\Entities\Variant;
use Modules\Product\Entities\VariantValues;
use Modules\Setting\Entities\Theme;
use Modules\Setting\Model\Currency;

if (!function_exists('userName')) {
    function userName($id)
    {
        if (User::find($id) != null) {
            return User::find($id)->name;
        }

        return null;
    }
}

if (!function_exists('showroomName')) {
    function showroomName()
    {
        if (ShowRoom::find(Auth::user()->staff->showroom_id) != null) {
            return ShowRoom::find(Auth::user()->staff->showroom_id)->name;
        }

        return null;
    }
}

if (!function_exists('checkCurrency')) {
    function checkCurrency($currency_code)
    {
        $currency = Currency::where('code', $currency_code)->first();
        if ($currency != null) {
            return true;
        }

        return null;
    }
}

if (!function_exists('account_type')) {
    function account_type($type)
    {
        if ($type == 1) {
            return 'Asset';
        } elseif ($type == 2) {
            return 'Liability';
        } elseif ($type == 3) {
            return 'Expense';
        } elseif ($type == 4) {
            return 'Income';
        } elseif ($type == 5) {
            return 'Equity';
        }
    }
}

if (!function_exists('accountCodeGenerate')) {
    function accountCodeGenerate($type, $parent_id, $id)
    {
        if ($parent_id == null) {
            if ($type == 1) {
                return function ($type, $id) {
                    return '01-' . $id;
                };
            } elseif ($type == 2) {
                return function ($type) {
                    return '02';
                };

                return 'Liability';
            } elseif ($type == 3) {
                return function ($type) {
                    return '03';
                };

                return 'Expense';
            } elseif ($type == 4) {
                return function ($type) {
                    return '04';
                };

                return 'Income';
            } else {
                return '05';
            }

            return 'Others';
        }
        $ParentAccount = ChartAccount::where('parent_id', $parent_id)->select('id', 'name')->first();

        return $ParentAccount . '-' . $id;
    }
}

if (!function_exists('showStatus')) {
    function showStatus($status)
    {
        if ($status == 1) {
            return __('common.Active');
        }

        return __('common.DeActive');
    }
}

if (!function_exists('permissionCheck')) {
    function permissionCheck($route_name)
    {
        if (auth()->check()) {
            if (auth()->user()->role->type == 'system_user') {
                return true;
            }
            $roles = app('permission_list');
            $role = $roles->where('id', auth()->user()->role_id)->first();
            if ($role != null && $role->permissions->contains('route', $route_name)) {
                return true;
            }

            return false;
        }

        return false;
    }
}

//formats price to home default price with convertion
if (!function_exists('single_price')) {
    function single_price($price)
    {
        if (!$price) {
            $price = 0;
        }

        if (app('general_setting')->currency_symbol != null) {
            return app('general_setting')->currency_symbol . ' ' . number_format($price, 2);
        }

        return number_format($price, 2) . ' bdt';
    }
}

if (!function_exists('single_price_pdf')) {
    function single_price_pdf($price)
    {
        if (!$price) {
            $price = 0;
        }
        if (app('general_setting')->currency_symbol != null && app('general_setting')->currency_code != 'BDT') {
            return app('general_setting')->currency_symbol . ' ' . number_format($price, 2);
        }

        return number_format($price, 2) . ' BDT';
    }
}

if (!function_exists('selected_account_config')) {
    function selected_account_config($category_id, $account_id)
    {
        $acc_category = AccountCategory::find($category_id);
        if ($acc_category->chart_accounts->contains('id', $account_id)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('attendanceCheck')) {
    function attendanceCheck($user_id, $type, $date)
    {
        $attendance = Attendance::where('user_id', $user_id)->whereDate('date', Carbon::parse($date)->format('Y-m-d'))->first();
        if ($attendance != null) {
            if ($attendance->attendance == $type) {
                return true;
            }

            return false;
        }

        return false;
    }
}

if (!function_exists('attendanceNote')) {
    function attendanceNote($user_id)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', Carbon::today()->toDateString())->first();
        if ($todayAttendance != null) {
            return true;
        }

        return false;
    }
}

if (!function_exists('Note')) {
    function Note($user_id)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', Carbon::today()->toDateString())->first();
        if ($todayAttendance != null && $todayAttendance->note != null) {
            return $todayAttendance->note;
        }

        return false;
    }
}

if (!function_exists('urlShortener')) {
    function urlShortener()
    {
        return url()->current();
    }
}

if (!function_exists('leadingZeroTwo')) {
    function leadingZeroTwo($value)
    {
        return sprintf('%02d', $value);
    }
}

if (!function_exists('houseName')) {
    function houseName($name)
    {
        $explode = explode('\\', $name);

        return $explode[3];
    }
}

if (!function_exists('CommissionDateRange')) {
    function CommissionDateRange($user_id, $start_date, $end_date)
    {
        $date = [];
        $sales = \Modules\Sale\Entities\Sale::where('agent_user_id', $user_id)->whereBetween('date', [$start_date, $end_date])->where('is_approved', 1)->get();

        if (count($sales) > 0) {
            $date['start'] = Carbon::parse($sales->first()->date)->format('Y-m-d');
            $date['end'] = Carbon::parse($sales->last()->date)->format('Y-m-d');
        }

        return $date;
    }
}

if (!function_exists('stockList')) {
    function stockList($houseable_id, $houseable_type, $supplier, $product_sku_id, $brand_id)
    {
        $stocks = StockReport::query();
        if ($supplier) {
            $stocks->where('houseable_id', $houseable_id)->where('houseable_type', $houseable_type);
            $stocks->Supplier($supplier);
        }
        if ($brand_id) {
            $stocks->where('houseable_id', $houseable_id)->where('houseable_type', $houseable_type);
            $stocks->BrandProduct($brand_id);
        }
        if ($product_sku_id) {
            $stocks->where('product_sku_id', $product_sku_id);
        }

        return $stocks->with('purchase.supplier')->get();
    }
}
if (!function_exists('variantName')) {
    function variantName($item)
    {
        $variantName = '';

        $v_name = [];
        $v_value = [];
        $p_name = [];
        $p_qty = [];
        if ($item->productable->product && $item->productable->product_variation) {
            foreach (json_decode($item->productable->product_variation->variant_id) as $key => $value) {
                $v_name[] = Variant::find($value)->name;
            }
            foreach (json_decode($item->productable->product_variation->variant_value_id) as $key => $value) {
                $v_value[] = VariantValues::find($value)->value;
            }

            for ($i = 0; $i < count($v_name); ++$i) {
                $variantName .= $v_name[$i] . ' : ' . $v_value[$i];
            }
        } else {
            if (is_array($item->productable->combo_products) || is_object($item->productable->combo_products)) {
                foreach ($item->productable->combo_products as $c_product_detail) {
                    $p_name[] = $c_product_detail->productSku->product->product_name;
                    $p_qty[] = $c_product_detail->product_qty;
                    if ($c_product_detail->productSku->product_variation) {
                        foreach (json_decode($c_product_detail->productSku->product_variation->variant_id) as $key => $value) {
                            $v_name[] = Variant::find($value)->name;
                        }

                        foreach (json_decode($c_product_detail->productSku->product_variation->variant_value_id) as $key => $value) {
                            $v_value[] = VariantValues::find($value)->value;
                        }
                    }
                }

                for ($i = 0; $i < count($p_name); ++$i) {
                    if (!empty($v_name[$i])) {
                        $variantName .= $p_name[$i] . ' -> qty : (' . $p_qty[$i] . ') Specification::' . $v_name[$i] . ' : ' . $v_value[$i] . '; </br>';
                    } else {
                        $variantName .= $p_name[$i] . ' -> qty : (' . $p_qty[$i] . ') ; </br>';
                    }
                }
            }
        }

        return $variantName;
    }
}
if (!function_exists('variantNameFromSku')) {
    function variantNameFromSku($productSku)
    {
        $v_name = [];
        $v_value = [];
        $p_name = [];
        $p_qty = [];
        $variantName = null;
        if ($productSku->product && $productSku->product_variation) {
            foreach (json_decode($productSku->product_variation->variant_id) as $key => $value) {
                $v_name[] = Variant::find($value)->name;
            }
            foreach (json_decode($productSku->product_variation->variant_value_id) as $key => $value) {
                $v_value[] = VariantValues::find($value)->value;
            }

            for ($i = 0; $i < count($v_name); ++$i) {
                $variantName .= $v_name[$i] . ' : ' . $v_value[$i] . ' ; ';
            }
        }

        return $variantName;
    }
}
if (!function_exists('loginPermit')) {
    function loginPermit()
    {
        session(['role_id' => Auth::user()->role_id]);
        if (auth()->user()->is_active == 1) {
            if (auth()->user()->role->type == 'system_user') {
                session()->put('showroom_id', (ShowRoom::first()->id) ?: null);

                return true;
            } elseif (auth()->user()->role->type == 'regular_user') {
                session()->put('showroom_id', auth()->user()->staff->showroom_id);

                return true;
            } elseif (auth()->user()->role->type == 'normal_user') {
                return true;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('chatAccountName')) {
    function chatAccountName($id)
    {
        if (ChartAccount::find($id) != null) {
            return ChartAccount::find($id);
        }

        return null;
    }
}

if (!function_exists('dateConvert')) {
    function dateConvert($input_date)
    {
        try {
            $system_date_format = session()->get('system_date_format');

            if (empty($system_date_format)) {
                $system_date_format = app('general_setting')->dateFormat->format;
                session()->put('system_date_format', $system_date_format);

                return date_format(date_create($input_date), $system_date_format);
            }

            return date_format(date_create($input_date), $system_date_format);
        } catch (\Throwable $th) {
            return $input_date;
        }
    }
}

if (!function_exists('get_file_type')) {
    function get_file_type($file_name)
    {
        $arr = explode('.', $file_name);
        $count = count($arr);
        $type = null;
        if ($count > 1) {
            $type = $arr[$count - 1];
        }

        return $type;
    }
}

if (!function_exists('my_project_configuration')) {
    function my_project_configuration($project, $user = null)
    {
        $configuration = [];

        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            return $configuration;
        }

        foreach ($project->users as $u) {
            if ($u->id == $user->id) {
                $configuration = [
                    'icon' => $u->pivot->icon,
                    'color' => $u->pivot->color,
                    'favourite' => $u->pivot->favourite,
                ];

                break;
            }
        }

        return $configuration;
    }
}

if (!function_exists('getConfigValueByKey')) {
    function getConfigValueByKey($config, $key)
    {
        return ($config->where('key', $key)->first())->value;
    }
}

const COLOR_CODE = [
    'f6f8f9',
    'fb5779',
    'ff7511',
    'ffa800',
    'ffd100',
    'ace60f',
    '19db7e',
    '00d4c8',
    '48dafd',
    '0064fb',
    '6457f9',
    '9f46e4',
    'ff78ff',
    'ff4ba6',
    'ff93af',
    '5a7896',
];

const ICON = [
    'ti-menu-alt',
    'ti-crown',
    'ti-palette',
    'ti-briefcase',
    'ti-package',
    'ti-layout-tab',
    'ti-layout-sidebar-right',
    'ti-widget-alt',
];

/*
 *  Used to get value-list json
 *  @return array
 */

function getVar($list)
{
    $file = resource_path('var/' . $list . '.json');

    return (\File::exists($file)) ? json_decode(file_get_contents($file), true) : [];
}

/*
 *  Used to generate random string of certain lenght
 *  @param
 *  $length as numeric
 *  $type as optional param, can be token or password or username. Default is token
 *  @return random string
 */

function randomString($length, $type = 'token')
{
    if ($type === 'password') {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?';
    } elseif ($type === 'username') {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    } else {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    }
    $token = substr(str_shuffle($chars), 0, $length);

    return $token;
}

function extract_image_url($text)
{
    preg_match_all('/<img[^>]*?\s+src\s*=\s*"([^"]+)"[^>]*?>/i', $text, $matches);

    return gv($matches, 1, []);
}

// get Maximum post size of server

function getPostMaxSize()
{
    if (is_numeric($postMaxSize = ini_get('post_max_size'))) {
        return (int) $postMaxSize;
    }

    $metric = strtoupper(substr($postMaxSize, -1));
    $postMaxSize = (int) $postMaxSize;

    switch ($metric) {
    case 'K':
        return $postMaxSize * 1024;
    case 'M':
        return $postMaxSize * 1048576;
    case 'G':
        return $postMaxSize * 1073741824;
    default:
        return $postMaxSize;
    }
}

function get_file_type($file_name)
{
    $arr = explode('.', $file_name);
    $count = count($arr);
    $type = null;
    if ($count > 1) {
        $type = $arr[$count - 1];
    }

    return $type;
}

function spn_active_link($route_or_path, $class = 'active')
{
    if (is_array($route_or_path)) {
        foreach ($route_or_path as $route) {
            if (request()->is($route)) {
                return $class;
            }
        }

        return in_array(request()->route()->getName(), $route_or_path) ? $class : false;
    }
    if (request()->route()->getName() == $route_or_path) {
        return $class;
    }

    if (request()->is($route_or_path)) {
        return $class;
    }

    return false;
}

function spn_nav_item_open($data, $default_class = 'active')
{
    foreach ($data as $d) {
        if (spn_active_link($d, true)) {
            return $default_class;
        }
    }

    return false;
}

if (!function_exists('canApprove')) {
    function canApprove($staff_id = null)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role_id == 1 || \Illuminate\Support\Facades\Auth::user()->role_id == 2) {
            return true;
        }

        if ($staff_id) {
            $staff = \Modules\HR\Entities\Staff::find($staff_id);
            if ($staff) {
                $department = \Modules\organization\Entities\Department::find($staff->department_id);
                if ($department->user_id && in_array(auth()->id(), $department->user_id)) {
                    return true;
                }
            }
        }

        return false;
    }
}

if (!function_exists('getBackground')) {
    function getBackground($title)
    {
        if (session()->has($title)) {
            return session()->get($title);
        }
        $dashboard_background = DB::table('background_settings')->where([['title', $title], ['is_default', 1]])->first();
        session()->put($title, $dashboard_background);

        return $dashboard_background;
    }
}

if (!function_exists('getThemeColor')) {
    function getThemeColor($color, $default = null)
    {
        if (session()->has('color_theme')) {
            $theme = session('color_theme');
        } else {
            $theme = Theme::with('colors')->where('is_default', 1)->first();
            session()->put('color_theme', $theme);
        }

        $theme_color = $theme->colors()->where('name', $color)->first();
        if ($theme_color) {
            return $theme_color->pivot->value;
        }

        return $default;
    }
}

function checkEmail($email)
{
    $find1 = strpos($email, '@');
    $find2 = strpos($email, '.');

    return $find1 !== false && $find2 !== false && $find2 > $find1;
}
