<?php

namespace App\Models\Helpers;

use App\Models\Front\Blog;
use App\Models\Front\Category\Category;
use Illuminate\Support\Str;

class Url
{
    public static function set(string $type, int $id): string
    {
        if ('category' == $type) {
            $category = Category::find($id);

            if ($category && 0 == $category->parent_id) {
                return route('gcp_route', ['group' => Str::slug($category->group), 'cat' => $category->slug]);
            }

            $parent = Category::find($category->parent_id);

            return route('gcp_route', ['group' => Str::slug($category->group), 'cat' => $parent->slug, 'subcat' => $category->slug]);
        }

        if ('page' == $type) {
            $page = Blog::find($id);

            if (isset($page->subcat)) {
                return route('blogovi', ['cat' => $page->cat->slug, 'subcat' => $page->subcat->slug, 'blog' => $page->slug]);
            }

            return route('blogovi', ['cat' => $page->cat->slug, 'subcat' => $page->slug]);
        }

        // If type is not found.
        return '';
    }
}
