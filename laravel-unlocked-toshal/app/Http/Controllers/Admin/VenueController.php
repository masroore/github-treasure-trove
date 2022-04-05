<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use App\Venue;
use App\VenueImage;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Str;

class VenueController extends Controller
{
    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-03-11 (yyyy-mm-dd)
    Purpose:        To get list of all Venues
    Params:
    */
    public function getList(Request $request)
    {
        if ($request->has('search_keyword') && $request->search_keyword != '') {
            $keyword = $request->search_keyword;
        } else {
            $keyword = '';
        }
        $data = Venue::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('name', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('location', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('contact', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('building_type', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('total_room', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('booking_price', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('status', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword)
                ->orWhereHas('user', function ($query) use ($request): void {
                    $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", '%' . $request->search_keyword . '%');
                });
        })->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        $totalVenues = Venue::where('is_deleted', 0)->count();
        $totalbookings = Booking::where('is_deleted', 0)->count();

        return view('admin.venues.list', compact('data', 'totalVenues', 'totalbookings', 'keyword'));
    }

    // End Method getList

    /*
    Method Name:    add_form
    Developer:      Shine Dezign
    Created Date:   2021-03-22 (yyyy-mm-dd)
    Purpose:        Form to add venue details
    Params:         []
    */
    public function add_form()
    {
        $owners = User::Role('Owner')->where('is_deleted', 0)->get();
        $categories = Category::where('status', 1)->get();

        return view('admin.venues.add', compact('owners', 'categories'));
    }
    // End Method add_form

    /*
    Method Name:    add_record
    Developer:      Shine Dezign
    Created Date:   2021-03-22 (yyyy-mm-dd)
    Purpose:        To add venue
    Params:         [name, location, building_type, total_room,booking_price,contact,venue_image_name[], status]
    */
    public function add_record(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'user_id' => 'required',
            'building_type' => 'required',
            'total_room' => 'required|numeric',
            'booking_price' => 'required|numeric',
            'contact' => 'required|numeric',
            'status' => 'required',
            'venue_image_name[]' => 'image|mimes:jpeg,png,jpg',
            'category_id' => 'required',
        ], [
            'venue_image_name.mimes' => 'Choose the image jpg,jpeg or png format Only',
            'venue_image_name.image' => 'Choose the image Only',
            'user_id.required' => 'Owner name is required',
        ]);

        try {
            $imgArr = [];

            $data = [
                'name' => $request->name,
                'user_id' => $request->user_id,
                'location' => $request->location,
                'building_type' => $request->building_type,
                'total_room' => $request->total_room,
                'booking_price' => $request->booking_price,
                'contact' => $request->contact,
                'amenities_detail' => $request->amenities_detail,
                'other_information' => $request->other_information,
                'status' => $request->status,
                'category_id' => $request->category_id,
            ];
            $record = Venue::create($data);

            $venueId = $record->id;
            if ($venueId) {
                if ($request->file('venue_image_name')) {
                    $venuImg = $request->file('venue_image_name');
                    $uploadpath = public_path() . '/assets/venue/images/';
                    foreach ($venuImg as $key => $img) {
                        $file = $img;
                        $orignlname = $img->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $slug = Str::slug($request->name);
                        $documentname = $slug . '-' . $orignlname;

                        $image_path = $uploadpath . '/' . $documentname; // Value is not URL but directory file path

                        $imgArr[] = ['venue_id' => $venueId, 'name' => $documentname, 'status' => 1];
                        $file->move($uploadpath, $documentname);
                    }
                    if (count($imgArr)) {
                        VenueImage::insert($imgArr);
                    }
                }

                $routes = ($request->action == 'saveadd') ? 'venues.add' : 'venues.list';

                return redirect()->route($routes)->with('status', 'success')->with('message', 'Venue ' . Config::get('constants.SUCCESS.CREATE_DONE'));
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
    Created Date:   2021-03-11 (yyyy-mm-dd)
    Purpose:        Form to update venue details
    Params:         [id]
    */
    public function edit_form($id)
    {
        $venueDetail = Venue::find($id);

        if (!$venueDetail) {
            return redirect()->route('venues.list');
        }

        $venueImages = VenueImage::where('venue_id', $id)->get();

        return view('admin.venues.edit', compact('venueDetail', 'venueImages'));
    }
    // End Method edit_record

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To update venue details
    Params:         [edit_record_id, name, location, building_type, total_room,booking_price,contact,venue_image_name[], status]
    */
    public function update_record(Request $request)
    {
        $postData = $request->all();

        $id = $postData['edit_record_id'];
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'building_type' => 'required',
            'total_room' => 'required|numeric',
            'booking_price' => 'required|numeric',
            'contact' => 'required|numeric',
            'status' => 'required',
            'venue_image_name[]' => 'image|mimes:jpeg,png,jpg',
        ], [
            'venue_image_name.mimes' => 'Choose the image jpg,jpeg or png format Only',
            'venue_image_name.image' => 'Choose the image Only',
        ]);

        try {
            $imgArr = [];
            if ($request->hasFile('venue_image_name')) {
                $venuImg = $request->file('venue_image_name');

                $uploadpath = public_path() . '/assets/venue/images/';
                foreach ($venuImg as $key => $img) {
                    $file = $img;
                    $orignlname = $img->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $slug = Str::slug($request->name);
                    $documentname = $slug . '-' . $orignlname;

                    $image_path = $uploadpath . '/' . $documentname; // Value is not URL but directory file path
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                    $checkExistImg = VenueImage::where('venue_id', $request->edit_record_id)->where('name', $documentname)->first();

                    if (!$checkExistImg) {
                        $imgArr[] = ['venue_id' => $request->edit_record_id, 'name' => $documentname, 'status' => 1];
                    }

                    $file->move($uploadpath, $documentname);
                }
            }

            $venues = Venue::findOrFail($id);

            $venues->name = $postData['name'];
            $venues->location = $postData['location'];
            $venues->building_type = $postData['building_type'];
            $venues->total_room = $postData['total_room'];
            $venues->booking_price = $postData['booking_price'];
            $venues->contact = $postData['contact'];
            $venues->amenities_detail = $postData['amenities_detail'];
            $venues->other_information = $postData['other_information'];
            $venues->status = $postData['status'];
            $venues->push();

            if (count($imgArr)) {
                VenueImage::insert($imgArr);
            }

            return redirect()->route('venues.list')->with('status', 'success')->with('message', 'Venue details ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method update_record

    /*
    Method Name:    change_status
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To change the status of user[active/inactive],is_featured venue[yes/no]
    Params:         [id, status,is_featured]
    */
    public function change_status(Request $request)
    {
        $getData = $request->all();

        $user = Venue::find($getData['id']);
        if (isset($getData['status'])) {
            $user->status = $getData['status'];
            $status = 'Venue';
        }
        if (isset($getData['is_featured'])) {
            $user->is_featured = $getData['is_featured'];
            $status = 'Featured';
        }
        $user->save();

        return redirect()->back()->with('status', 'success')->with('message', $status . ' ' . Config::get('constants.SUCCESS.STATUS_UPDATE'));
    }
    // End Method change_status

    /*
    Method Name:    deleteRecord
    Developer:      Shine Dezign
    Created Date:   2021-03-15 (yyyy-mm-dd)
    Purpose:        To delete any venue images by id and venues
    Params:         [id , venue_id]
    */
    public function deleteRecord(Request $request)
    {
        try {
            $getData = $request->all();

            //delete venue
            if ($getData['id'] != '' && isset($getData['is_deleted'])) {
                $bookings = Booking::where('venue_id', $getData['id'])->count();
                if ($bookings) {
                    $venue = Venue::find($getData['id']);
                    $venue->is_deleted = $getData['is_deleted'];
                    if ($getData['is_deleted'] == 0) {
                        $status = 'RECOVER_DONE';
                    } else {
                        $status = 'DELETE_DONE';
                    }
                    $venue->save();
                } else {
                    Venue::where('id', $getData['id'])->delete();
                    $status = 'DELETE_DONE';
                }

                return redirect()->back()->with('status', 'success')->with('message', 'Venue details ' . Config::get('constants.SUCCESS.' . $status));
            }
            //delete venue images from DB and directory folder
            if (isset($getData['id'], $getData['name'])) {
                $venueImg = VenueImage::where('id', $getData['id'])->where('venue_id', $getData['venue_id'])->delete();
                $uploadpath = public_path() . '/assets/venue/images/';
                $image_path = $uploadpath . '/' . $getData['name']; // Value is not URL but directory file path
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }

                return redirect()->back();
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }
    // End Method deleteRecord

    /*
    Method Name:    view_detail
    Developer:      Shine Dezign
    Created Date:   2021-03-19 (yyyy-mm-dd)
    Purpose:        To get detail of venue
    Params:         [id]
    */
    public function view_detail($id, Request $request)
    {
        $venueDetail = Venue::find($id);

        if (!$venueDetail) {
            return redirect()->route('venues.list');
        }

        $venueImages = VenueImage::where('venue_id', $id)->get();

        $bookings = Booking::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('booking_name', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('date', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('booking_email', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('status', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword)
                ->orWhereHas('user', function ($query) use ($request): void {
                    $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", '%' . $request->search_keyword . '%');
                });
        })
            ->where('bookings.venue_id', $id)->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.venues.view_detail', compact('venueDetail', 'venueImages', 'bookings'));
    }
}
