<?php

namespace App\Http\Controllers;

use App\Category;
use App\FooterMenu;
use App\Menu;
use App\Page;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use Session;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('menu.view'), 403, __('User does not have the right permissions.'));

        $lang = Session::get('changed_language');
        $menus = Menu::orderBy('position', 'ASC')->select('title as title', 'id as id', 'status as status', 'link_by as link_by', 'menu_tag as menu_tag', 'show_cat_in_dropdown as show_cat_in_dropdown', 'show_child_in_dropdown as show_child_in_dropdown', 'icon as icon')->get();

        if ($request->ajax()) {
            return DataTables::of($menus)
                ->setRowAttr([
                    'data-id' => function ($row) {
                        return $row->id;
                    },
                ])
                ->setRowClass('row1')
                ->addColumn('multicheck', function ($row) {
                    return $html = '<div class="inline">
                              <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="' . $row->id . '" id="topmenu' . $row->id . '">
                              <label for="checkbox' . $row->id . '" class="material-checkbox"></label>
                            </div>';
                })
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    $html = '<p><b>' . $row->title . '</b></p>';
                    $html .= 1 == $row->status ? '<a href="' . route('menu.quick.update', $row->id) . '" class="btn btn-sm btn-success-rgba rounded">Active</a>' : '<a href="' . route('menu.quick.update', $row->id) . '" class="btn rounded btn-danger-rgba">Deactive</a>';

                    return $html;
                })
                ->addColumn('adtl', 'admin.menu.adtl')
                ->editColumn('action', 'admin.menu.action')
                ->rawColumns(['multicheck', 'title', 'adtl', 'action'])
                ->make(true);
        }

        return view('admin.menu.index');
    }

    public function bulk_delete_top_menu(Request $request)
    {
        abort_if(!auth()->user()->can('menu.delete'), 403, __('User does not have the right permissions.'));

        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()
                ->with('warning', __('Please select one of them to delete'));
        }

        foreach ($request->checked as $checked) {
            $menu = Menu::find($checked);

            if (isset($menu)) {
                $menu->delete();
            }
        }

        return back()->with('deleted', __('Selected menu has been deleted !'));
    }

    public function bulk_delete_footer_menu(Request $request)
    {
        abort_if(!auth()->user()->can('menu.delete'), 403, __('User does not have the right permissions.'));

        $validator = Validator::make($request->all(), ['checked_fm' => 'required']);

        if ($validator->fails()) {
            return back()
                ->with('warning', __('Please select one of them to delete'));
        }

        foreach ($request->checked_fm as $checked) {
            $menu_footer = FooterMenu::find($checked);

            if (isset($menu_footer)) {
                $menu_footer->delete();
            }
        }

        return back()->with('deleted', __('Selected menu has been deleted !'));
    }

    public function sort(Request $request)
    {
        if ($request->ajax()) {
            $posts = Menu::all();
            foreach ($posts as $post) {
                foreach ($request->order as $order) {
                    if ($order['id'] == $post->id) {
                        DB::table('menus')->where('id', $post->id)->update(['position' => $order['position']]);
                    }
                }
            }

            return response()->json('Update Successfully.', 200);
        }
    }

    public function upload_info(Request $request)
    {
        $id = $request['catId'];

        $category = Category::findOrFail($id);
        $upload = $category
            ->subcategory
            ->where('parent_cat', $id)->pluck('title', 'id')
            ->all();

        return response()
            ->json($upload);
    }

    public function onloadchildpanel(Request $request)
    {
        $catid = $request->catId;
        $menuid = $request->menuid;

        if ($menuid) {
            $menufind = Menu::where('id', '=', $menuid)->first();
            $catsids = $menufind->linked_parent;
            $childcats = $menufind->linked_child;
        } else {
            $catsids = [0];
            $childcats = [0];
        }

        return view('admin.menu.ajaxchild', compact('catid', 'catsids', 'childcats'));
    }

    /**
     * Show the form for date_interval_create_from_date_string() a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('menu.create'), 403, __('User does not have the right permissions.'));

        $category = Category::all();
        $pages = Page::all();

        return view('admin.menu.add', compact('category', 'pages'));
    }

    /**
     * Store a newly created retsource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('menu.create'), 403, __('User does not have the right permissions.'));

        $menu = new Menu();

        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => __('Menu title is required !'),
        ]);

        $input = $request->all();

        if (isset($request->status)) {
            $input['status'] = 1;
        } else {
            $input['status'] = 0;
        }

        if (isset($request->menu_tag)) {
            $input['menu_tag'] = 1;
            $input['tag_bg'] = $request->tag_background;
            $input['tag_color'] = $request->tag_color;
            $input['tag_text'] = $request->tag_text;
        } else {
            $input['menu_tag'] = 0;
            $input['tag_bg'] = null;
            $input['tag_color'] = null;
            $input['tag_text'] = null;
        }

        if ('cat' == $request->link_by) {
            $input['cat_id'] = $request->cat_id;
            $input['page_id'] = null;
            $input['url'] = null;

            if (isset($request->show_cat_in_dropdown)) {
                $input['cat_id'] = '0';
                $request->validate([
                    'parent_cat' => 'required',
                ], [
                    'parent_cat.required' => __('Atleast one category is required to link !'),
                ]);

                $input['show_cat_in_dropdown'] = 1;
                $input['linked_parent'] = $request->parent_cat;

                if ($request->child_cat) {
                    $input['linked_child'] = $request->child_cat;
                }
            }

            if (isset($request->show_child_in_dropdown)) {
                $request->validate([
                    'sub_id' => 'required',
                ], [
                    'sub_id.required' => __('Atleast one subcategory is required to link !'),
                ]);

                $input['show_child_in_dropdown'] = 1;
                $input['linked_parent'] = $request->sub_id;

                if ($request->r) {
                    $input['linked_child'] = $request->r;
                }
            }

            if (isset($request->show_image)) {
                if ($request->file('image')) {
                    $input['show_image'] = 1;

                    $image = $request->file('image');

                    $input['bannerimage'] = time() . $image->getClientOriginalExtension();

                    $destinationPath = public_path('/images/menu');

                    $img = Image::make($image->path());

                    $img->resize(345, 645, function ($constraint): void {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . '/' . $input['bannerimage']);
                    $input['img_link'] = $request->img_link;
                }
            } else {
                $input['show_image'] = 0;
                $input['bannerimage'] = null;
                $input['img_link'] = null;
            }
        }

        if ('page' == $request->link_by) {
            $input['url'] = null;
            $input['cat_id'] = null;
            $input['show_cat_in_dropdown'] = 0;
            $input['show_child_in_dropdown'] = 0;
            $input['page_id'] = $request->page_id;
            $input['linked_parent'] = null;
            $input['linked_child'] = null;
            $input['bannerimage'] = null;
            $input['img_link'] = null;
        }

        if ('url' == $request->link_by) {
            $input['page_id'] = null;
            $input['cat_id'] = null;
            $input['show_cat_in_dropdown'] = 0;
            $input['show_child_in_dropdown'] = 0;
            $input['url'] = $request->url;
            $input['linked_child'] = null;
            $input['linked_parent'] = null;
            $input['bannerimage'] = null;
            $input['img_link'] = null;
        }

        $input['position'] = Menu::count() + 1;
        $input['icon'] = substr($request->icon, 3);
        $menu->create($input);
        notify()->success('Menu Has Been Added !');

        return redirect()->route('menu.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('menu.edit'), 403, __('User does not have the right permissions.'));

        $menu = Menu::find($id);
        $category = Category::all();
        $pages = Page::all();

        return view('admin.menu.edit', compact('menu', 'category', 'pages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('menu.edit'), 403, __('User does not have the right permissions.'));

        $menu = Menu::find($id);

        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => __('Menu title is required !'),
        ]);

        $input = $request->all();

        if (isset($request->status)) {
            $input['status'] = 1;
        } else {
            $input['status'] = 0;
        }

        if (isset($request->menu_tag)) {
            $input['menu_tag'] = 1;
            $input['tag_bg'] = $request->tag_background;
            $input['tag_color'] = $request->tag_color;
            $input['tag_text'] = $request->tag_text;
        } else {
            $input['menu_tag'] = 0;
            $input['tag_bg'] = null;
            $input['tag_color'] = null;
            $input['tag_text'] = null;
        }

        if ('cat' == $request->link_by) {
            $input['cat_id'] = $request->cat_id;
            $input['page_id'] = null;
            $input['url'] = null;

            if (isset($request->show_cat_in_dropdown)) {
                $input['cat_id'] = '0';
                $request->validate([
                    'parent_cat' => 'required',
                ], [
                    'parent_cat.required' => __('Atleast one category is required to link !'),
                ]);

                $input['show_cat_in_dropdown'] = 1;
                $input['linked_parent'] = $request->parent_cat;

                if ($request->child_cat) {
                    $input['linked_child'] = $request->child_cat;
                }
            } else {
                $input['show_cat_in_dropdown'] = 0;
            }

            if (isset($request->show_child_in_dropdown)) {
                $request->validate([
                    'sub_id' => 'required',
                ], [
                    'sub_id.required' => __('Atleast one subcategory is required to link !'),
                ]);

                $input['show_child_in_dropdown'] = 1;
                $input['linked_parent'] = $request->sub_id;

                if ($request->r) {
                    $input['linked_child'] = $request->r;
                }
            } else {
                $input['show_child_in_dropdown'] = 0;
            }

            if (isset($request->show_image)) {
                if ($request->file('image')) {
                    if ('' != $menu->bannerimage && file_exists(public_path() . '/images/menu/' . $menu->bannerimage)) {
                        unlink(public_path() . '/images/menu/' . $menu->bannerimage);
                    }

                    $input['show_image'] = 1;
                    $image = $request->file('image');
                    $bannerimage = uniqid() . '.jpg';
                    $destinationPath = public_path('/images/menu');
                    $img = Image::make($image->path());

                    $img = $img->encode('jpg', 100);

                    $img->resize(345, 645, function ($constraint): void {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . '/' . $bannerimage);

                    $input['bannerimage'] = $bannerimage;
                    $input['img_link'] = $request->img_link;
                }
            } else {
                if ($image_file = @file_get_contents(public_path() . '/images/menu/' . $menu->bannerimage)) {
                    unlink(public_path() . '/images/menu/' . $menu->bannerimage);
                    $input['show_image'] = 0;
                    $input['bannerimage'] = null;
                    $input['img_link'] = null;
                }
            }
        }

        if ('page' == $request->link_by) {
            $input['url'] = null;
            $input['cat_id'] = null;
            $input['show_cat_in_dropdown'] = 0;
            $input['show_child_in_dropdown'] = 0;
            $input['page_id'] = $request->page_id;
            $input['linked_parent'] = null;
            $input['linked_child'] = null;
            $input['bannerimage'] = null;
            $input['img_link'] = null;

            if ($image_file = @file_get_contents(public_path() . '/images/menu/' . $menu->bannerimage)) {
                unlink(public_path() . '/images/menu/' . $menu->bannerimage);
                $input['show_image'] = 0;
                $input['bannerimage'] = null;
                $input['img_link'] = null;
            }
        }

        if ('url' == $request->link_by) {
            $input['page_id'] = null;
            $input['cat_id'] = null;
            $input['show_cat_in_dropdown'] = 0;
            $input['show_child_in_dropdown'] = 0;
            $input['url'] = $request->url;
            $input['linked_child'] = null;
            $input['linked_parent'] = null;
            $input['bannerimage'] = null;
            $input['img_link'] = null;

            if ($image_file = @file_get_contents(public_path() . '/images/menu/' . $menu->bannerimage)) {
                unlink(public_path() . '/images/menu/' . $menu->bannerimage);
                $input['show_image'] = 0;
                $input['bannerimage'] = null;
                $input['img_link'] = null;
            }
        }

        $input['icon'] = substr($request->icon, 3);

        $menu->update($input);

        notify()->success(__('Menu has been updated !'));

        return redirect()
            ->route('menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('menu.delete'), 403, __('User does not have the right permissions.'));

        $menu = Menu::find($id);

        if (isset($menu)) {
            $menu->delete();

            return back()->with('deleted', __('Menu has been deleted !'));
        }

        return back()->with('warning', __('Menu not found !'));
    }
}
