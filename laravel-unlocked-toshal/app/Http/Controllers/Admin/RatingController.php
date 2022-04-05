<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RatingReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RatingController extends Controller
{
    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To get list of all users
    Params:
    */
    public function getList(Request $request)
    {
        if ($request->has('search_keyword') && $request->search_keyword != '') {
            $keyword = $request->search_keyword;
        } else {
            $keyword = '';
        }
        $data = RatingReview::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('rating', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('review', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('status', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword)
                ->orWhereHas('venue', function ($query) use ($request): void {
                 $query->where('name', 'like', '%' . $request->search_keyword . '%');
             })
                ->orWhereHas('user', function ($qu) use ($request): void {
                $qu->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", '%' . $request->search_keyword . '%');
            });
        })->with(['venue', 'user'])->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.ratings.list', compact('data', 'keyword'));
    }

    // End Method getList

    /*
    Method Name:    change_status
    Developer:      Shine Dezign
    Created Date:   2021-03-24 (yyyy-mm-dd)
    Purpose:        To change the status of rating[active/inactive]
    Params:         [id, status]
    */
    public function change_status(Request $request)
    {
        $getData = $request->all();
        $rating = RatingReview::find($getData['id']);
        $rating->status = $getData['status'];
        $rating->save();

        return redirect()->back()->with('status', 'success')->with('message', 'Rating ' . Config::get('constants.SUCCESS.STATUS_UPDATE'));
    }
    // End Method change_status
}
