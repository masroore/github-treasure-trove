<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Photo extends Model
{
    /**
     * @param $request
     */
    public static function getName($request)
    {
        return str_replace('media/images/gallery/' . $request->type . '/' . $request->type_id . '/', '', $request->path);
    }

    /**
     * Upload images for specific type
     * and resource like Blog.
     * Make sure to have
     * file system config setup by type.
     *
     * @param        $image
     * @param        $resource
     * @param string $type         - 'blog', 'category'
     * @param string $resource_tag
     *
     * @return string
     */
    public static function imageUpload($image, $resource, $type = 'blog', $resource_tag = 'image')
    {
        // Set some base vars.
        // Extract image path from resource.
        // Leave resource ID and image name.
        $base_path = config('filesystems.disks.' . $type . '.url');
        $old = str_replace($base_path, '', $resource->{$resource_tag});

        // Check if it's an update and
        // resource has old image stored.
        // If it does, first delete it.
        if (Storage::disk($type)->exists($old)) {
            Storage::disk($type)->delete($old);
        }

        // If the images folder requires Resource ID folder
        if ('blog' == $type) {
            Storage::disk($type)->putFileAs($resource->id, $image, $image->getClientOriginalName());
            $path = $base_path . $resource->id . '/' . $image->getClientOriginalName();
        }

        // If the images are all in Type folder
        if ('category' == $type) {
            $name = Str::slug($resource->name) . '.' . $image->getClientOriginalExtension();
            Storage::disk('gallery')->putFileAs($type, $image, $name);
            $path = $base_path . $name;
        }

        // If it's a product PDF or .docx file
        if ('pdf' == $type) {
            $name = Str::slug($resource->name) . '.' . $image->getClientOriginalExtension();
            Storage::disk('media')->putFileAs($type, $image, $name);
            $path = $base_path . $name;
        }

        return $path;
    }
}
