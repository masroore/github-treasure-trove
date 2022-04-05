<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Str;

class BlogController extends Controller
{
    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        To get list of all Blogs
    Params:
    */
    public function getList(Request $request)
    {
        if ($request->has('search_keyword') && $request->search_keyword != '') {
            $keyword = $request->search_keyword;
        } else {
            $keyword = '';
        }
        $data = Blog::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('title', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword)
                ->orWhere('content', 'like', '%' . $request->search_keyword . '%');
        })->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.blogs.list', compact('data', 'keyword'));
    }
    // End Method getList

    /*
    Method Name:    add_form
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        Form to add blog details
    Params:         []
    */
    public function add_form()
    {
        return view('admin.blogs.add');
    }
    // End Method add_form

    /*
    Method Name:    add_record
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        To add blog
    Params:         [title, content, cover_photo, status]
    */
    public function add_record(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'cover_photo' => 'image|mimes:jpeg,png,jpg',
            'status' => 'required',
        ]);

        try {
            $coverPhoto = '';
            if ($request->hasFile('cover_photo')) {
                $blogPhoto = $request->file('cover_photo');

                $uploadpath = public_path() . '/assets/blog/images/';

                $file = $blogPhoto;
                $orignlname = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $slug = Str::slug($request->title);
                $coverPhoto = $slug . '-' . $orignlname;
                $image_path = $uploadpath . '/' . $coverPhoto; // Value is not URL but directory file path
                $file->move($uploadpath, $coverPhoto);
            }
            $publishDate = date('Y-m-d H:i:s');
            if ($request->scheduleOn == 1) {
                $publishDate = $request->publish_date !== null ? date('Y-m-d H:i:s', strtotime($request->publish_date)) : date('Y-m-d H:i:s');
            } else {
                $publishDate = $request->publish_date !== null ? date('Y-m-d H:i:s', strtotime($request->publish_date)) : date('Y-m-d H:i:s');
            }

            $data = [
                'title' => $request->title,
                'content' => $request->content,
                'cover_photo' => $coverPhoto,
                'publish_date' => $publishDate,
                'status' => $request->status,
            ];
            $record = Blog::create($data);
            if ($record) {
                $routes = ($request->action == 'saveadd') ? 'blog.add' : 'blogs.list';

                return redirect()->route($routes)->with('status', 'success')->with('message', 'Blog ' . Config::get('constants.SUCCESS.CREATE_DONE'));
            }

            return redirect()
                ->back()->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method add_record

    /*
    Method Name:    edit_form
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        Form to update blog details
    Params:         [id]
    */
    public function edit_form($id)
    {
        $blogDetail = Blog::find($id);

        if (!$blogDetail) {
            return redirect()->route('blogs.list');
        }

        return view('admin.blogs.edit', compact('blogDetail'));
    }
    // End Method edit_form

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-17 (yyyy-mm-dd)
    Purpose:        To update category details
    Params:         [title, content, cover_photo, status]
    */
    public function update_record(Request $request)
    {
        $postData = $request->all();
        $id = $postData['edit_record_id'];

        $request->validate([
            'title' => '',
            'content' => 'required',
            'cover_photo' => 'image|mimes:jpeg,png,jpg',
            'status' => 'required',
        ], [
            'cover_photo.mimes' => 'Choose the image jpg,jpeg or png format Only',
        ]);

        try {
            $blogPhoto = $request->cover_photo_old;
            if ($request->hasFile('cover_photo')) {
                $uploadpath = public_path() . '/assets/blog/images/';
                $file = $request->file('cover_photo');
                $orignlname = $file->getClientOriginalName();
                $image_path = $uploadpath . '/' . $request->cover_photo_old; // Value is not URL but directory file path
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $extension = $file->getClientOriginalExtension();
                $slug = Str::slug($request->title);
                $blogPhoto = $slug . '-' . $orignlname;
                $file->move($uploadpath, $blogPhoto);
            }
            $publishDate = date('Y-m-d H:i:s');

            if ($postData['scheduleOn'] == 1) {
                $publishDate = date('Y-m-d H:i:s');
            } else {
                $publishDate = $request->publish_date !== null ? date('Y-m-d H:i:s', strtotime($request->publish_date)) : date('Y-m-d H:i:s');
            }

            $blogs = Blog::findOrFail($id);
            $blogs->title = $postData['title'];
            $blogs->content = $postData['content'];
            $blogs->cover_photo = $blogPhoto;
            $blogs->publish_date = $publishDate;
            $blogs->status = $postData['status'];
            $blogs->push();

            return redirect()->route('blogs.list')->with('status', 'success')->with('message', 'Blog ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method update_record

    /*
    Method Name:    del_record
    Developer:      Shine Dezign
    Created Date:   2021-03-23 (yyyy-mm-dd)
    Purpose:        To delete any blog by id
    Params:         [id]
    */
    public function del_record($id)
    {
        try {
            Blog::where('id', $id)->delete();

            return redirect()->back()->with('status', 'success')->with('message', 'Blog details ' . Config::get('constants.SUCCESS.DELETE_DONE'));
        } catch (Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }
    // End Method del_record

    public function change_status(Request $request)
    {
        $getData = $request->all();
        $blog = Blog::find($getData['id']);
        $blog->status = $getData['status'];
        $blog->save();

        return redirect()->back()->with('status', 'success')->with('message', 'Status ' . Config::get('constants.SUCCESS.STATUS_UPDATE'));
    }
}
