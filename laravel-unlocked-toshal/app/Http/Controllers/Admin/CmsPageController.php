<?php

namespace App\Http\Controllers\Admin;

use App\CmsPage;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    public function __construct()
    {
    }

    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-03-24 (yyyy-mm-dd)
    Purpose:        To fetch list of cms pages
    Params:
    */
    public function getList(Request $request)
    {
        if ($request->has('search_keyword') && $request->search_keyword != '') {
            $keyword = $request->search_keyword;
        } else {
            $keyword = '';
        }
        $data = CmsPage::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('name', 'like', '%' . $request->search_keyword . '%');
        })->orderBy('id', 'desc')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.cms-pages.list', compact('data', 'keyword'));
    }
    // End Method getList

    /*
    Method Name:    add_form
    Developer:      Shine Dezign
    Created Date:   2021-03-24 (yyyy-mm-dd)
    Purpose:        Form to add new cms page
    Params:
    */
    public function add_form()
    {
        return redirect()->route('cms-pages.list')->with('status', 'error')->with('message', Config::get('constants.ERROR.OOPS_ERROR'));

        return view('admin.cms-pages.add');
    }
    // End Method add_form

    /*
    Method Name:    create_record
    Developer:      Shine Dezign
    Created Date:   2021-03-24 (yyyy-mm-dd)
    Purpose:        Save data into database to add new cms page
    Params:         [name, status]
    */
    public function create_record(Request $request)
    {
        return redirect()->route('cms-pages.list');
        $request->validate(
            [
                'name' => 'required|regex:/^[A-Za-z0-9-_ ]+$/|unique:cms_pages',
                'short_description' => 'required',
                'description' => 'required',
                'slug' => 'required|regex:/^[A-Za-z0-9-_]+$/|unique:cms_pages',
                'meta_title' => 'required',
                'meta_keyword' => 'required',
                'meta_content' => 'required',
            ],
            [
                'name.regex' => 'Please enter valid page name.',
                'slug.regex' => 'Please enter valid slug name.',
            ]
        );

        try {
            $record = CmsPage::create($request->all());
            if ($record) {
                $routes = ($request->action == 'saveandadd') ? 'cms-pages.add' : 'cms-pages.list';

                return redirect()->route($routes)->with('status', 'success')->with('message', 'CMS Page ' . Config::get('constants.SUCCESS.CREATE_DONE'));
            }

            return redirect()
                ->back()->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method create_record

    /*
    Method Name:    edit_form
    Developer:      Shine Dezign
    Created Date:   2021-03-24 (yyyy-mm-dd)
    Purpose:        Edit form to update any cms page
    Params:         [id]
    */
    public function edit_form($id)
    {
        $record = CmsPage::find($id);
        if (!$record) {
            return redirect()->route('cms-pages.list');
        }

        return view('admin.cms-pages.edit', compact('record'));
    }
    // End Method edit_form

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-24 (yyyy-mm-dd)
    Purpose:        update data into database of previous cms page
    Params:         [edit_record_id, name, status]
    */
    public function update_record(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:200|regex:/^[A-Za-z0-9-_ ]+$/|unique:cms_pages,name,' . $request->edit_record_id,
                'short_description' => 'required|max:200',
                'description' => 'required',
                'meta_title' => 'required|max:200',
                'meta_keyword' => 'required|max:200',
                'meta_content' => 'required|max:200',
                // 'document' => 'image|mimes:jpeg,png,jpg',

            ],
            [
                'name.regex' => 'Please enter valid page name.',
                // 'slug.regex' => 'Please enter valid slug name.'
            ]
        );

        try {
            $data = [
                'name' => $request->name,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'slug' => Str::slug($request->name),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_content' => $request->meta_content,
            ];

            // if($request->hasFile('document'))
            // {
            //     $uploadpath = public_path().'/assets/documents/pages/'.$request->name.'/';
            //     $image_path = $uploadpath.'/'.$request->olddocument; // Value is not URL but directory file path
            //     if(File::exists($image_path))
            //     {
            //         File::delete($image_path);
            //     }
            //     $file = $request->file('document');
            //     $extension = $file->getClientOriginalExtension();
            //     $slug = Str::slug($request->name);
            //     $documentname = $slug.time().'.'.$extension;
            //     $file->move($uploadpath, $documentname);
            //     $data['image'] = $documentname;
            // }
            // else
            // {
            //     $data['image'] = $request->olddocument;
            // }

            $record = CmsPage::where('id', $request->edit_record_id)->update($data);

            return redirect()->route('cms-pages.list')->with('status', 'success')->with('message', 'CMS Page ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method update_record

    /*
    Method Name:    del_record
    Developer:      Shine Dezign
    Created Date:   2021-03-24 (yyyy-mm-dd)
    Purpose:        To delete any cms page by id
    Params:         [id]
    */
    public function del_record($id)
    {
        return redirect()->route('cms-pages.list')->with('status', 'error')->with('message', Config::get('constants.ERROR.OOPS_ERROR'));

        try {
            CmsPage::where('id', $id)->delete();

            return redirect()->back()->with('status', 'success')->with('message', 'CMS Page ' . Config::get('constants.SUCCESS.DELETE_DONE'));
        } catch (Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }
    // End Method del_record

    /*
    Method Name:    change_status
    Developer:      Shine Dezign
    Created Date:   2021-03-24 (yyyy-mm-dd)
    Purpose:        To change the status of cms page[active/inactive]
    Params:         [id, status]
    */
    public function change_status(Request $request)
    {
        $getData = $request->all();
        $cms_page = CmsPage::find($getData['id']);
        $cms_page->status = $getData['status'];
        $cms_page->save();

        return redirect()->back()->with('status', 'success')->with('message', 'CMS Page ' . Config::get('constants.SUCCESS.STATUS_UPDATE'));
    }
    // End Method change_status

    /*
    Method Name:    show
    Developer:      Shine Dezign
    Created Date:   2021-03-24 (yyyy-mm-dd)
    Purpose:        To view cms page details
    Params:         [id]
     */
    public function show($id)
    {
        $record = CmsPage::find($id);

        return view('admin.cms-pages.show', compact('record'));
    }
    // End Method show
}
