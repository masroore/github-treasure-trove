<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\RatingReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RatingController extends Controller
{
    /*
    Method Name:    add_form
    Developer:      Shine Dezign
    Created Date:   2021-04-02 (yyyy-mm-dd)
    Purpose:        Form to add rating
    Params:         []
    */
    public function add_form()
    {
        return view('user.ratings.add');
    }
    // End Method add_form

    /*
    Method Name:    add_record
    Developer:      Shine Dezign
    Created Date:   2021-04-02 (yyyy-mm-dd)
    Purpose:        To add ratings
    Params:         [parent_id, name, status]
    */
    public function add_record(Request $request)
    {
        $request->validate([
            'venue_id' => 'required',
            'rating' => 'required|numeric|between:0,5',
            'review' => '',
        ]);

        try {
            $data = [
                'venue_id' => $request->venue_id,
                'user_id' => 2,
                'rating' => $request->rating,
                'review' => $request->review,
                'status' => 1,
            ];
            $rating = RatingReview::where('user_id', 2)->where('venue_id', $request->venue_id)->first();
            if ($rating) {
                $record = RatingReview::where('user_id', 2)
                    ->where('venue_id', $request->venue_id)
                    ->update(
                        ['rating' => $request->rating,
                            'review' => $request->review,
                        ]
                    );
            } else {
                $record = RatingReview::create($data);
            }
            if ($record) {
                return redirect()->back()->with('status', 'success')->with('message', 'Rating ' . Config::get('constants.SUCCESS.CREATE_DONE'));
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
    Method Name:    del_record
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To delete any user by id
    Params:         [id]
    */
    public function del_record(Request $request)
    {
        try {
            $getData = $request->all();
            $ratings = RatingReview::where('venue_id', 3)->where('user_id', 3)->first();
            if ($bookings) {
                $user = User::find($getData['id']);
                $user->is_deleted = $getData['is_deleted'];
                if ($getData['is_deleted'] == 0) {
                    $status = 'RECOVER_DONE';
                } else {
                    $status = 'DELETE_DONE';
                }
                $user->save();
            } else {
                User::find($getData['id'])->delete();
                $status = 'DELETE_DONE';
            }

            return redirect()->back()->with('status', 'success')->with('message', 'Rating ' . Config::get('constants.DELETE_DONE'));
        } catch (Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }
}
