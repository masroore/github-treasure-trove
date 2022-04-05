<?php

if (!function_exists('treeview')) {
    /**
     * Построение массива для фронта treeview
     * TODO: by Igor, check this.
     *
     * @return array
     */
    function treeview(array $tree, array $selected = [])
    {
        $res = [];

        foreach ($tree as $branch) {
            if ($branch['children'] === []) {
                if ($selected && in_array($branch['id'], $selected)) {
                    array_push($res, ['id' => $branch['id'], 'text' => $branch['name'], 'selectable' => false, 'state' => ['expanded' => true, 'checked' => true]]);
                } else {
                    array_push($res, ['id' => $branch['id'], 'text' => $branch['name'], 'selectable' => false, 'state' => ['expanded' => true]]);
                }
            } else {
                if ($selected && in_array($branch['id'], $selected)) {
                    array_push($res, ['id' => $branch['id'], 'text' => $branch['name'], 'selectable' => false, 'state' => ['expanded' => true, 'checked' => true], 'nodes' => treeview($branch['children'], $selected)]);
                } else {
                    array_push($res, ['id' => $branch['id'], 'text' => $branch['name'], 'selectable' => false, 'state' => ['expanded' => true], 'nodes' => treeview($branch['children'], $selected)]);
                }
            }
        }

        return $res;
    }
}

if (!function_exists('build_linear_array_sort')) {
    /**
     * Построить линейный масив с дерева, для записи упорядоченных сущностей.
     *
     * @return array
     */
    function build_linear_array_sort(array $tree_entities, ?int $parent_id = null, bool $use_parent = true)
    {
        $result = [];

        foreach ($tree_entities[0] ?? [] as $key => $entity) {
            $data = [];
            if (!empty($entity['id'])) {
                $data['id'] = (int) $entity['id'];
                $data['weight'] = $key;
                $use_parent ? $data['parent_id'] = $parent_id : null;
                $result[] = $data;
                if (!empty($entity['children'])) {
                    $result = array_merge($result, build_linear_array_sort($entity['children'], $entity['id'], $use_parent));
                }
            }
        }

        return $result;
    }
}

//if (! function_exists('array_merge_sum')) {
//    /**
//     * @param array $ary
//     * @return array
//     */
//    function array_merge_sum(array $a1, array $a2)
//    {
//        $sums = [];
//        foreach (array_keys($a1 + $a2) as $key) {
//            $sums[$key] = ($a1[$key] ?? 0) + ($a2[$key] ?? 0);
//        }
//
//        return $sums;
//    }
//}

if (!function_exists('human_filesize')) {
    /**
     * @return string
     */
    function human_filesize(int $bytes, int $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= 1024 ** $pow;

        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('sanitize_file_name')) {
    /**
     * @return mixed|string
     */
    function sanitize_file_name(string $dangerous_filename, string $platform = 'unix')
    {
        if (in_array(strtolower($platform), ['unix', 'linux'])) {
            // our list of "dangerous characters", add/remove characters if necessary
            $dangerous_characters = [' ', '"', "'", '&', '/', '\\', '?', '#'];
        } else {
            // no OS matched? return the original filename then...
            return $dangerous_filename;
        }

        // every forbidden character is replace by an underscore
        return str_replace($dangerous_characters, '_', $dangerous_filename);
    }
}

// TODO deprecated
if (!function_exists('search_url')) {
    /**
     * @return mixed|string
     */
    function search_url(string $string)
    {
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $string, $match);

        return $match[0][0] ?? '';
    }
}

if (!function_exists('array_search_associative')) {
    /**
     * Example usage: array_search_associative('green', [['name' => 'BLUE', 'key' => 'blue'], ['name' => 'GREEN', 'key' => 'green']], 'key');.
     *
     * @param $needle
     *
     * @return false|int|string
     */
    function array_search_associative($needle, array $haystack, string $key = 'key', ?string $resultKey = null)
    {
        $values = array_column($haystack, $key);

        if (($index = array_search($needle, $values)) === false) {
            return false;
        }

        $result = $haystack[$index] ?? false;

        if ($result !== false && isset($resultKey)) {
            return $result[$resultKey] ?? false;
        }

        return $result;
    }
}

if (!function_exists('array_values_recursive')) {
    /**
     * @return array
     */
    function array_values_recursive(array $ary)
    {
        $lst = [];
        foreach (array_keys($ary) as $k) {
            $v = $ary[$k];
            if (is_scalar($v)) {
                $lst[] = $v;
            } elseif (is_array($v)) {
                $lst = array_merge($lst, array_values_recursive($v));
            }
        }

        return $lst;
    }
}

if (!function_exists('pagination_row_number')) {
    function pagination_row_number(Illuminate\Pagination\LengthAwarePaginator $items, int $loopIndex)
    {
        $total = $items->total();

        return ($total - $items->perPage() * ($items->currentPage() - 1)) - $loopIndex;
    }
}

if (!function_exists('cdek_str_delivery_info')) {
    /**
     * Сформировать строку с информацией о сроках доставки и цене для СДЕК-ответа калькулятора.
     *
     * @param $response
     *
     * @return string
     */
    function cdek_str_delivery_info($response, string $prefix = '')
    {
        $dStr = $prefix ?: 'Информация о доставке';

        if ($response instanceof \CdekSDK\Responses\CalculationResponse) {
            try {
                $dMinTerm = $response->getDeliveryPeriodMin();
                $dMaxTerm = $response->getDeliveryPeriodMax();
                $dPrice = $response->getPrice();
                $dMaxTermStr = $dMaxTerm > 0 && $dMaxTerm != $dMinTerm ? "- $dMaxTerm " : '';
                $dStr .= ": Срок доставки $dMinTerm $dMaxTermStr дня. - $dPrice р.";
            } catch (Exception $exception) {
                \Log::error($exception->getMessage());

                return 'Ошибка данных CDEK!';
            }
        }

        return $dStr;
    }
}

if (!function_exists('variable_json')) {
    /**
     * @param string $default
     *
     * @return mixed
     */
    function variable_json(?string $name = null, $default = '')
    {
        return json_decode(variable($name, json_encode($default)), true);
    }
}
