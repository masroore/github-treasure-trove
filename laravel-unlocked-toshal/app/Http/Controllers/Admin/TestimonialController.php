<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Testimonial;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Image;

class TestimonialController extends Controller
{
    public function __construct()
    {

    }

    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        To get list of all testimonials
    Params:
    */
    public function getList(Request $request)
    {
        $data = Testimonial::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('name', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('user_post', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('location', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('message', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword);
        })
            ->sortable(['id' => 'desc'])
            ->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.testimonial.list', compact('data'));
    }
    // End Method getList

    /*
    Method Name:    add_form
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        Form to add new testimonial
    Params:
    */
    public function add_form()
    {
        return view('admin.testimonial.add');
    }
    // End Method add_form

    /*
    Method Name:    create_record
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        Save data into database to add new testimonial
    Params:         [name, user_post, message, image, status]
    */
    public function create_record(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'user_post' => 'required|max:200',
            'location' => '',
            'message' => 'required|max:2500',
            'image' => 'image|mimes:jpeg,png,jpg',
            'status' => 'required',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'user_post' => $request->user_post,
                'location' => $request->location,
                'message' => $request->message,
                'status' => $request->status,
            ];
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $uploadpath = public_path() . '/assets/testimonial/images/';
                $image_path = $uploadpath . $request->oldimage;  // Value is not URL but directory file path
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $slug = Str::slug($request->name);
                $documentname = $slug . '-' . time() . '.' . $extension;
                $data['image'] = $documentname;
                $file->move($uploadpath, $documentname);
            }
            $record = Testimonial::create($data);
            if ($record) {
                $routes = ($request->action == 'saveadd') ? 'testimonial.add' : 'testimonial.list';

                return redirect()
                    ->route($routes)->with('status', 'success')
                    ->with('message', 'Testimonial ' . Config::get('constants.SUCCESS.CREATE_DONE'));
            }

            return redirect()
                ->back()->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', $e->getMessage());
        }
    }
    // End Method create_record

    /*
    Method Name:    edit_form
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        Edit form to update any question
    Params:         [id]
    */
    public function edit_form(Request $request, $id)
    {
        $record = Testimonial::find($id);
        if (!$record) {
            return redirect()->route('testimonial.list');
        }

        return view('admin.testimonial.edit', compact('record'));
    }

    // End Method edit_form

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        update data into database of previous question
    Params:         [edit_record_id, title, answer, status]
    */
    public function update_record(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'user_post' => 'required|max:200',
            'location' => '',
            'message' => 'required|max:2500',
            'image' => 'image|mimes:jpeg,png,jpg',
            'status' => 'required',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'user_post' => $request->user_post,
                'location' => $request->location,
                'message' => $request->message,
                'status' => $request->status,
            ];
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $uploadpath = public_path() . '/assets/testimonial/images/';
                $image_path = $uploadpath . $request->oldimage;  // Value is not URL but directory file path
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $slug = Str::slug($request->name);
                $documentname = $slug . '-' . time() . '.' . $extension;
                $data['image'] = $documentname;
                $file->move($uploadpath, $documentname);
            }
            $record = Testimonial::where('id', $request->edit_record_id)
                ->update($data);

            return redirect()->route('testimonial.list')
                ->with('status', 'success')
                ->with('message', 'Testimonial ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (\Exception $e) {
            dd($e);

            return redirect()->back()
                ->with('status', 'error')
                ->with('message', $e->getMessage());
        }
    }
    // End Method update_record

    /*
    Method Name:    del_record
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        To delete any testimonial by id
    Params:         [id]
    */
    public function del_record($id)
    {
        try {
            Testimonial::where('id', $id)->delete();

            return redirect()
                ->back()
                ->with('status', 'success')
                ->with('message', 'Testimonial ' . Config::get('constants.SUCCESS.DELETE_DONE'));
        } catch (Exception $ex) {
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', $ex->getMessage());
        }
    }
    // End Method del_record

    /*
    Method Name:    change_status
    Developer:      Shine Dezign
    Created Date:   2021-03-18 (yyyy-mm-dd)
    Purpose:        To change the status of question[active/inactive]
    Params:         [id, status]
    */
    public function change_status(Request $request)
    {
        $getData = $request->all();
        $question = Testimonial::find($getData['id']);
        $question->status = $getData['status'];
        $question->save();

        return redirect()
            ->back()
            ->with('status', 'success')
            ->with('message', 'Testimonial ' . Config::get('constants.SUCCESS.STATUS_UPDATE'));
    }
    // End Method change_status
}
