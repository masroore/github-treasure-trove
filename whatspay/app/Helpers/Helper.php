<?php

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

if (!function_exists('get_whatsapp_message')) {
    /**
     * Returns a whatsapp message.
     *
     * @param string $purpose
     *                        Purpose contains the purpose of the message
     * @param array  $params
     *                        Extra params needed to create the message
     *
     * @return string a whatsapp message
     *
     * */
    function get_whatsapp_message($purpose, $params)
    {
        switch ($purpose) {
            case 'customer_support':
                $whatsapp = ADMIN_WHATSAPP;
                $text = 'Hello WhatsPays,'
                  . NEW_LINE
                  . NEW_LINE
                  . 'I am interested in your services but have some queries. Would appreciate if you could respond with feedback.'
                  . NEW_LINE
                  . NEW_LINE
                  . 'Regards,'
                  . NEW_LINE
                  . '*{{name}}*';
            break;
            case 'create-store':
                $whatsapp = ADMIN_WHATSAPP;
                $text = 'Hello WhatsPays,'
                    . NEW_LINE
                    . NEW_LINE
                    . 'Thank you for creating your store with whatspays.'
                    . NEW_LINE
                    . NEW_LINE
                    . 'Regards,'
                    . NEW_LINE
                    . '*{{name}}*';
                break;
        }

        $message = 'https://api.whatsapp.com/send?phone=' . $whatsapp . '&text=' . $text;

        return replace_messge_variables($message, $params);
    }
}

if (!function_exists('replace_messge_variables')) {
    /** replace variables in a string */
    function replace_messge_variables($message, $fields)
    {
        foreach ($fields as $key => $value) {
            $message = str_replace('{{' . $key . '}}', urlencode($value), $message);
        }

        return $message;
    }
}

if (!function_exists('get_email_subject')) {
    /** get email subject */
    function get_email_subject($purpose, $params)
    {
        switch ($purpose) {
            case 'register':
                $return = 'Hey ' . $params . ' - Welcome! Thank you for registering on WhatsPays.';
                break;
            case 'reactivate':
                $return = 'Hey ' . $params . ' - Welcome Back! Thank you for reactivating on WhatsPays.';
                break;
            case 'forgot-password':
                $return = 'Hey ' . $params . ' - Forgot your password?';
                break;
            case 'reset-password':
                $return = 'Hey ' . $params . ' - Security Alert! You have successfully reset your password.';
                break;
            case 'resendcode':
                $return = 'Hey ' . $params . ' - Welcome Back! Thank you for reactivating on WhatsPays.';
                break;
            case 'create-store':
                $return = 'Hey ' . $params . ' - Welcome! Thank you for creating your store on WhatsPays.';
                break;
        }

        return $return;
    }
}

if (!function_exists('generate_random_string')) {
    /**
     * generate random string.
     *
     * @param int $size
     */
    function generate_random_string($size = 6)
    {
        $digits = substr(str_shuffle('0123456789'), 0, 4);
        $chars = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTVWXYZ'), 0, 2);
        $string = $digits . $chars;
        $string = substr(str_shuffle($string), 0, $size);

        return strtoupper($string);
    }
}

if (!function_exists('extract_number_and_cc')) {
    // extract country code and number
    function extract_number_and_cc($request)
    {

        // 1. get whatsapp and country code from post array
        $phone = (int) $request['phone'];
        $country_code = (int) $request['country_code'];

        // echo var_dump((string) $phone); exit();

        // 2. see whether country code exist in whatsapp number
        $find_cc = strpos((string) $phone, (string) $country_code);

        if (false === $find_cc || $find_cc > 0) {
            // 2.a if not concate the code with number
            $post = $country_code . (string) ((int) $phone);
        } else {
            // 2.b if exist return it as it is just remove any zeros in the start
            $post = (string) ((int) $phone);
        }

        // number with country code
        $with_cc = $post;

        //number without country code

        $without_cc = str_replace($country_code, '', $with_cc);

        return [
            'with_cc' => $with_cc,
            'without_cc' => $without_cc,
        ];
    }
}

if (!function_exists('onefile')) {
    function onefile($file, $path, $string)
    {
        $name = time() . $string;
        $name = slugify($name);
        $name = $name . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path($path);
        $file->move($destinationPath, $name);

        return $name;
    }
}

if (!function_exists('multiFile')) {
    function multiFile($files = [], $dimensions)
    {
        $images = [];
        foreach ($files as $key => $request) {
            $filenamewithextension = $request->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, \PATHINFO_FILENAME);
            //get file extension
            $extension = $request->getClientOriginalExtension();
            $filenametostore = rand() . '.' . $extension;
            //Upload File
            $request->storeAs($dimensions['full']['model'] . '/images', $filenametostore);
            //create small thumbnail
            $smallthumbnailpath = $dimensions['full']['model'] . '/images/' . $filenametostore;
            $mediumthumbnailname = createThumbnail($smallthumbnailpath, $dimensions);
            $images[] = $mediumthumbnailname;
        }

        return json_encode($images);
    }
}

if (!function_exists('createThumbnail')) {
    function createThumbnail($img_name1, $dimensions): string
    {
        $quality = 70;
        $img_name = 'storage/' . $img_name1;
        $name = pathinfo(public_path($img_name), \PATHINFO_FILENAME);
        foreach ($dimensions as $key=>$dimension) {
            $image = Image::make(public_path($img_name))->resize($dimension['width'], $dimension['width'])->encode($dimension['ext'], $quality);
            Storage::disk('local')->put($dimension['model'] . '/images/' . $name . $dimension['key'] . '.' . $dimension['ext'], $image);
        }
        if (file_exists($img_name)) {
            $deleteOriinal = Storage::disk('local')->delete($img_name1);
        }

        return $image->basename;
    }
}

if (!function_exists('multiImagesDelete')) {
    function multiImagesDelete($images, $info)
    {
        $deleteImages = true;
        if ($images) {
            foreach ($images as $image) {
                $data = explode('/', $image);
                $name = $data[count($data) - 1];
                $corname = explode('-', $name)[0];
                foreach ($info as $key => $file) {
                    $address = $file['model'] . '/images/' . $corname . $file['key'] . '.' . $file['ext'];
                    if (file_exists('storage/' . $address)) {
                        $deleteImages = Storage::disk('local')->delete($address);
                    }
                }
            }
        }

        return $deleteImages;
    }
}

if (!function_exists('hasAnyPermission')) {
    function hasAnyPermission($permissions, $user, $store_id)
    {
        $roles = $user->role;
        foreach ($roles as $role) {
            if ($role->pivot->store_id == $store_id) {
                $user_permissions = $role->permissions;
                break;
            }
        }

        $hasPermission = false;
        if ($user_permissions) {
            [$module, $permission] = explode('.', $permissions);
            $user_permissions = json_decode($user_permissions, true);
            if (isset($user_permissions[strtolower($module)][strtolower($permission)])) {
                if (true === $user_permissions[strtolower($module)][strtolower($permission)]) {
                    $hasPermission = true;
                }
            }
        }

        return $hasPermission;
    }
}

if (!function_exists('averageRating')) {
    function averageRating($id, $model)
    {
        $ratingAverage = \App\Models\Comment::where('commentable_id', $id)
            ->where('commentable_type', $model)->selectRaw('SUM(rating)/COUNT(user_id) AS avg_rating')
            ->first()->avg_rating;
        $star_count = \App\Models\Comment::where('commentable_id', $id)
            ->where('commentable_type', $model)
            ->select('rating', DB::raw('count(id) as count'))
            ->groupBy('rating')
            ->get();

        return ['average'=>$ratingAverage, 'total'=>$star_count->sum('count'), 'count'=>$star_count];
    }
}

if (!function_exists('slugify')) {
    function slugify($string, string $divider = '-')
    {

        // replace non letter or digits by divider
        $string = preg_replace('~[^\pL\d]+~u', $divider, $string);

        // transliterate
        $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);

        // remove unwanted characters
        $string = preg_replace('~[^-\w]+~', '', $string);

        // trim
        $string = trim($string, $divider);

        // remove duplicate divider
        $string = preg_replace('~-+~', $divider, $string);

        // lowercase
        $string = strtolower($string);

        if (empty($string)) {
            return false;
        }

        return $string;
    }
}
if (!function_exists('array_equal')) {
    /**
     * @return bool
     */
    function array_equal(array $first, array $second)
    {
        if (count($first) != count($second)) {
            return false;
        }

        return !array_diff($first, $second) && !array_diff($second, $first);
    }
}

if (!function_exists('createSlug')) {
    function createSlug($data)
    {
        $model = get_class($data);
        $title = ($data->name) ?: $data->store_name;
        $slug = SlugService::createSlug(App\Models\Slug::class, 'slug', $title);
        \App\Models\Slug::create(['slug'=>$slug, 'slugable_type'=>$model, 'slugable_id'=>$data->id]);

        return $slug;
    }
}

if (!function_exists('getIdBySlug')) {
    function getIdBySlug($slug, $model)
    {
        return \App\Models\Slug::where('slugable_type', $model)
            ->where('slug', $slug)->pluck('slugable_id')->first();
    }
}

if (!function_exists('getStoreDeliveryTime')) {
    function getStoreDeliveryTime($store)
    {
        $delivery = '';
        $delivery_hours = $store->delivery_hours;
        $delivery_minutes = $store->delivery_minutes;
        $store_timings = json_decode($store->store_timings);
        $delivery_days = count((array) $store_timings);
        $delivery_timings = getDeliveryTimings($delivery_hours, $delivery_minutes, $delivery_days);
        if ($delivery_timings) {
            $delivery = $delivery_timings['timing'] . ' ' . $delivery_timings['type'];
        }

        return $delivery;
    }
}

if (!function_exists('getDeliveryTimings')) {
    function getDeliveryTimings($hr = 0, $min = 0, $days = 0)
    {
        if ($hr > 0 || $min > 0) {
            $delivery_time = ($hr * 60) + $min;

            return ['timing' => $delivery_time, 'type' => 'min'];
        }
        if ($days > 0) {
            $type = ($days > 1) ? ' Days' : ' Day';

            return ['timing' => $days, 'type' => $type];
        }

        return false;
    }
}

if (!function_exists('promoCode')) {
    function promoCode()
    {
        return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
    }
}
if (!function_exists('sendNotification')) {
    function sendNotification($data)
    {
        $notifications = new App\Models\Notification();
        $notifications->notifiable_id = $data['notifiable_id'];
        $notifications->notifiable_type = $data['notifiable_type'];
        $notifications->sender_id = $data['sender_id'];
        $notifications->type = $data['type'];
        $notifications->redirect = $data['redirect'];
        $notifications->title = $data['title'];
        $notifications->body = $data['body'];
        $notifications->save();

        return 'success';
    }
}

if (!function_exists('sendnote')) {
    function sendnote($notifiable_type, $notifiable_id, $sender_id, $body, $title, $type, $redirect = null)
    {
        $data['notifiable_type'] = $notifiable_type;
        $data['notifiable_id'] = $notifiable_id;
        $data['sender_id'] = $sender_id;
        $data['type'] = $type;
        $data['redirect'] = $redirect;
        $data['title'] = $title;
        $data['body'] = $body;
        event(new App\Events\NotificationEvent($data));

        return 'success';
    }
}
