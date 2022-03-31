<?php

namespace Modules\AdminApi\Http\Controllers\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use Modules\AdminApi\Http\Controllers\BaseController;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::get()->take(10);
        foreach ($categories as $category) {
            if ('1' == $category->status) {
                $category->status = 'Active';
            } else {
                $category->status = 'Inactive';
            }
            if ('1' == $category->is_featured) {
                $category->is_featured = 'Featured';
            } else {
                $category->is_featured = 'Not-Featured';
            }
            if ('1' == $category->show_on_homepage) {
                $category->show_on_homepage = 'Show';
            } else {
                $category->show_on_homepage = 'Dont Show';
            }
        }

        return $this->success($categories);
    }

    public function navbarCategories(Request $request)
    {
        if (!$this->validateParams($request->only(['isFeatured']))) {
            return $this->failure(['Invalid Params']);
        }

        $categories = Category::query();
        $categories->where('status', 1);
        $fCategories = null;
        if (isset($request->isFeatured)) {
            $fCategories = Category::where('is_featured', 1)
                ->whereNull('category_id')
                ->select('id', 'name', 'slug', 'image', 'description', 'category_id')
                ->with('categories:id,name,slug,image,description,category_id', 'categories.categories:id,name,slug,image,description,category_id')
                ->latest()
                ->take(4)
                ->get();
        }

        return $this->success($fCategories);
    }

    public function homePageParentCategories(Request $request)
    {
        if (!$this->validateParams($request->only(['showOnHomePage']))) {
            return $this->failure(['Invalid Params']);
        }

        $categories = Category::query();
        $categories->where('status', 1);
        $hCategories = null;
        if (isset($request->showOnHomePage)) {
            $hCategories = Category::where('show_on_homepage', 1)
                ->whereNull('category_id')
                ->select('id', 'name', 'slug', 'image', 'category_id')
                ->limit(4)
                ->get();
        }
        foreach ($hCategories as $cat) {
            $cat->setAttribute('image_path', URL('/') . '/images/categories/' . $cat->image);
        }

        return $this->success($hCategories);
    }

    public function homePageParentChildCategories(Request $request)
    {
        if (!$this->validateParams($request->only(['showOnHomePage']))) {
            return $this->failure(['Invalid Params']);
        }

        $categories = Category::query();
        $categories->where('status', 1);
        $hCategories = null;
        if (isset($request->showOnHomePage)) {
            $hCategories = Category::where('show_on_homepage', 1)
                ->whereNull('category_id')
                ->select('id', 'name', 'slug', 'category_id')
                ->with('categories:id,name,slug,category_id')
                ->get();
        }

        return $this->success($hCategories);
    }

    private function validateParams($data)
    {
        if (isset($data['showOnHomePage'])) {
            if ('1' != $data['showOnHomePage'] && '0' != $data['showOnHomePage']) {
                return false;
            }
        }

        if (isset($data['isFeatured'])) {
            if ('1' != $data['isFeatured'] && '0' != $data['isFeatured']) {
                return false;
            }
        }

        return true;
    }
}
