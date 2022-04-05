<?php

namespace App\Http\Controllers;

use App\Models\Franchise;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FranchiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $franchise = Franchise::all()->toArray();

        return view('franchises.franchise', compact('franchise'));
    }

    public function create()
    {
        if (\Request::ajax()) {
            return view('franchises.franchise_create');
        }

        return Redirect::to('home');
    }

    public function store(Request $request)
    {
        $messages = [
            'name_franchise.required' => __('Name Franchise: Required'),

        ];
        $validator = Validator::make($request->all(), [

            'name_franchise' => 'required',

        ], $messages);
        if ($validator->fails()) {
            $result['status'] = 0;
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';
            $result['redirect'] = route('franchise');

            return $result;
        }

        try {
            $item = new Franchise();
            $item->name_franchise = $request->name_franchise;
            $item->user_id = Auth::user()->id;
            $item->date_register = date('Y-m-d H-i-s');
            $item->ip = $request->ip();
            $item->save();

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Stored');
            $result['data'] = null;
            $result['type_message'] = 'success';
            $result['redirect'] = route('franchise');
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['title'] = __('Franchise');
            $result['message'] = $e->getMessage();
            $result['type_message'] = 'error';
            $result['redirect'] = route('franchise');
        }

        return $result;
    }

    public function edit($id)
    {
        if (\Request::ajax()) {
            $item = Franchise::where('id', $id)->get()->toArray();

            return view('franchises.franchise_edit', compact('item'));
        }

        return Redirect::to('home');
    }

    public function update(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_franchise.required' => __('Name Franchise: Required'),
            ];

            $validator = Validator::make($request->all(), [
                'name_franchise' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Franchise');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('franchise');

                return $result;
            }

            try {
                $item = Franchise::find($request->id);
                $item->name_franchise = $request->name_franchise;
                $item->user_id = Auth::user()->id;
                $item->date_register = date('Y-m-d H-i-s');
                $item->ip = $request->ip();
                $item->save();

                $result['status'] = 1;
                $result['title'] = __('Franchise');
                $result['message'] = __('Updated');
                $result['type_message'] = 'success';
                $result['redirect'] = route('franchise');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Franchise');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('franchise');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function change_status($id, $type)
    {
        if (\Request::ajax()) {
            $item = Franchise::find($id);
            $item->status = $type;
            $item->save();
            $msg = $type == 0 ? 'Deleted' : 'Restored';

            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Franchise ' . $msg);
            $result['type_message'] = 'success';
            $result['redirect'] = route('franchise');

            return $result;
        }

        return Redirect::to('home');
    }
}
