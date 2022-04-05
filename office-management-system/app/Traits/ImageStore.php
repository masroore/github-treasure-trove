<?php

namespace App\Traits;

use Carbon\Carbon;
use File;
use Intervention\Image\Facades\Image;

trait ImageStore
{
    public function saveImage($image, $height = null, $lenght = null)
    {
        if (isset($image)) {
            $current_date = Carbon::now()->format('d-m-Y');
            if (!File::isDirectory('public/uploads/images/' . $current_date)) {
                File::makeDirectory('public/uploads/images/' . $current_date, 0777, true, true);
            }
            $image_extention = str_replace('image/', '', Image::make($image)->mime());
            if ($height != null && $lenght != null) {
                $img = Image::make($image)->resize($height, $lenght);
            } else {
                $img = Image::make($image);
            }
            $img_name = 'public/uploads/images/' . $current_date . '/' . uniqid() . '.' . $image_extention;
            $img->save($img_name);

            return $img_name;
        }

        return null;
    }

    public function saveSettingsImage($image, $height = null, $lenght = null)
    {
        if (isset($image)) {
            $current_date = Carbon::now()->format('d-m-Y');
            $image_extention = str_replace('image/', '', Image::make($image)->mime());
            if ($height != null && $lenght != null) {
                $img = Image::make($image)->resize($height, $lenght);
            } else {
                $img = Image::make($image);
            }
            $img_name = 'public/uploads/settings' . '/' . uniqid() . '.' . $image_extention;
            $img->save($img_name);

            return $img_name;
        }

        return null;
    }

    public function deleteImage($url)
    {
        if (isset($url)) {
            if (File::exists($url)) {
                File::delete($url);

                return true;
            }

            return false;
        }

        return null;
    }

    public function saveAvatar($image, $height = null, $lenght = null)
    {
        if (isset($image)) {
            $current_date = Carbon::now()->format('d-m-Y');
            if (!File::isDirectory('public/uploads/avatar/' . $current_date)) {
                File::makeDirectory('public/uploads/avatar/' . $current_date, 0777, true, true);
            }
            $image_extention = str_replace('image/', '', Image::make($image)->mime());
            if ($height != null && $lenght != null) {
                $img = Image::make($image)->resize($height, $lenght);
            } else {
                $img = Image::make($image);
            }
            $img_name = 'public/uploads/avatar/' . $current_date . '/' . uniqid() . '.' . $image_extention;
            $img->save($img_name);

            return $img_name;
        }

        return null;
    }

    public function saveFile($file)
    {
        $name = $file->getClientOriginalName();
        $file->move('public/uploads/document/', $name);

        return $name;
    }
}
