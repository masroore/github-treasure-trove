<?php

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
        }

        return $return;
    }
}

if (!function_exists('generate_random_string')) {
    /** generate random string */
    function generate_random_string($size = 6)
    {
        $digits = substr(str_shuffle('0123456789'), 0, 4);
        $chars = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTVWXYZ'), 0, 2);
        $string = $digits . $chars;

        return substr(str_shuffle($string), 0, $size);
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

if (!function_exists('removeSpecialChars')) {
    function removeSpecialChars($string)
    {
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9-]/', '', $string);

        return preg_replace('/-+/', '-', $string);
    }
}

if (!function_exists('onefile')) {
    function onefile($file, $path, $string)
    {
        $name = time() . $string . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path($path);
        $file->move($destinationPath, $name);

        return $name;
    }
}

if (!function_exists('multiFile')) {
    function multiFile($files = [])
    {
        //dd($files[1]);
        $images = [];
        foreach ($files as $key => $request) {
            $filenamewithextension = $request->getClientOriginalName();
            //get filename without extension
            $filename = pathinfo($filenamewithextension, \PATHINFO_FILENAME);
            //get file extension
            $extension = $request->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . $key . '_.' . $extension;

            //small thumbnail name
            $smallthumbnail = $filename . '_small_' . $key . '_.' . $extension;

            //medium thumbnail name
            $mediumthumbnail = $filename . '_medium_' . $key . '_.' . $extension;

            //large thumbnail name
            $largethumbnail = $filename . '_large_' . $key . '_.' . $extension;

            //Upload File
            $request->storeAs('public/profile_images', $filenametostore);
            $request->storeAs('public/profile_images/thumbnail', $smallthumbnail);
            $request->storeAs('public/profile_images/thumbnail', $mediumthumbnail);
            $request->storeAs('public/profile_images/thumbnail', $largethumbnail);

            //create small thumbnail

            $smallthumbnailpath = public_path('storage/profile_images/thumbnail/' . $smallthumbnail);
            $mediumthumbnailname = createThumbnail($smallthumbnailpath, 150, 93);

            //create medium thumbnail
            $mediumthumbnailpath = public_path('storage/profile_images/thumbnail/' . $mediumthumbnail);
            $mediumthumbnailname = createThumbnail($mediumthumbnailpath, 300, 185);

            //create large thumbnail
            $largethumbnailpath = public_path('storage/profile_images/thumbnail/' . $largethumbnail);
            $largethumbnailname = createThumbnail($largethumbnailpath, 550, 340);

            $images[$request->getClientOriginalName()] = ['full' => $filenametostore, 'large' => $largethumbnail, 'medium' => $mediumthumbnail, 'small' => $smallthumbnail];
        }

        return $images;
    }
}

if (!function_exists('createThumbnail')) {
    function saveImagesCopies($img_name): string
    {
        //dd($img_name);
        $img_instance = Image::make(public_path($img_name))->encode('webp', 60);
        $name = pathinfo(public_path($img_name), \PATHINFO_FILENAME);
        $image = Image::make(public_path($img_name))->resize(130, 110)->encode('webp');
        Storage::disk('local')->put('images/' . $name . '-S.webp', $image);
        $image = Image::make(public_path($img_name))->resize(370, 260)->encode('webp');
        Storage::disk('local')->put('images/' . $name . '-M.webp', $image);
        $image = Image::make(public_path($img_name))->resize(670, 440)->encode('webp');
        Storage::disk('local')->put('images/' . $name . '-L.webp', $image);

        $img_instance->resize(null, 500, function ($constraint): void {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        Storage::disk('local')->put('images/' . $name . '-XL.webp', $img_instance);

        return 'images/' . $name;
    }

    $file_dimensions = [
        'full' => ['width' => 1600, 'height' => 1000, 'ext' => 'webp'],
        'large' => ['width' => 1200, 'height' => 750,  'ext' => 'webp'],
        'medium' => ['width' => 800,  'height' => 500,  'ext' => 'webp'],
        'full_jpeg' => ['width' => 800,  'height' => 500,  'ext' => 'jpg'],
        'small' => ['width' => 400,  'height' => 250,  'ext' => 'webp'],
    ];
    $download_url = ABSPATH . '../uploads/temp_images/';
    $upload_url = '../uploads/store/media/';
    $files_data = [
        'files' => $files,
        'imgz_states' => $img_states,
        'download_url' => $download_url,
        'upload_url' => $upload_url,
        'file_dimensions' => $file_dimensions,
        'type' => 'store',
        // 'count'           => $this->_existing_images_count,
        'store_name' => $store_name,
    ];
    $upload_images = new MoveImages();
    $message = $upload_images->upload($files_data);
}
