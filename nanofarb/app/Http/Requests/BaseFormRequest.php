<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 19.01.19
 * Time: 13:11.
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Request;
use Waavi\Sanitizer\Laravel\SanitizesInput;

abstract class BaseFormRequest extends FormRequest
{
    use SanitizesInput;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * https://github.com/Waavi/Sanitizer#adding-custom-filters.
     *
     * @return array
     */
    public function customFilters()
    {
        return [
            //'phone_sanitize' => function ($value, $options = []) {
            //    return preg_replace('/[^0-9]/si', '', $value);
            //},
            //'remove_strings' => RemoveStringsFilter::class,
            // url_sanitize
            'url_without_root' => function ($value, $options = []) {
                $path = str_replace_first(Request::root(), '', $value);

                return $path == '/' ? '/' : trim($path, '/');
            },
        ];
    }
}
