<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator;

class ProfileController extends Controller
{
    public function index()
    {
        if (\Request::ajax()) {
            $profile = Profile::all();

            return view('profiles.profiles_index', compact('profile'));
        }

        return Redirect::to('home');
    }

    public function create(Request $request)
    {
        if (\Request::ajax()) {
            $Cod = Profile::orderBy('id', 'desc')->first();
            $Cde = $Cod['id'] + 1;
            $Code = FullSerial($Cde, 4);

            return view('profiles.profiles_create', compact('Code'));
        }

        return Redirect::to('home');
    }

    public function store(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_profile.required' => __('Name Profile Required'),
                'name_profile.unique' => __('Name Profile already exists'),
                'name_profile.max' => __('Name Profile: Longitud de valores no admitida'),
                'description.required' => __('Description Required'),
                'description.max' => __('Description: Longitud de valores no admitida'),
                'code.numeric' => __('The Code must be Numeric'),
            ];

            $validator = Validator::make($request->all(), [
                'name_profile' => 'required|max:50|unique:profiles,name_profile,' . $request->id,
                'description' => 'required|max:50',
                'code' => 'numeric',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Profile');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';

                return $result;
            }

            try {
                $item = new Profile();
                $item->name_profile = $request->name_profile;
                $item->description = $request->description;
                $item->code = $request->code;
                $item->status = 1;
                $item->save();

                $item->code = FullSerial($item->id, 4);
                $item->save();

                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Stored');
                $result['type_message'] = 'success';
                $result['redirect'] = route('profiles');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function edit(Request $request)
    {
        if (\Request::ajax()) {
            $item = Profile::find($request->id)->toArray();

            return view('profiles.profiles_edit', compact('item'));
        }

        return Redirect::to('home');
    }

    public function update(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_profile_edit.required' => __('Name Profile Required'),
                'name_profile_edit.unique' => __('Name Profile already exists'),
                'name_profile_edit.max' => __('Name Profile: Longitud de valores no admitida'),
                'description_edit.required' => __('Description Required'),
                'description_edit.max' => __('Description: Longitud de valores no admitida'),
                'status.in' => __('Format Incorrect'),
            ];

            $validator = Validator::make($request->all(), [
                'name_profile_edit' => 'required|max:50|unique:profiles,name_profile,' . $request->id,
                'description_edit' => 'required|max:50',
                'status' => 'required|in:0,1',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Profile');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';

                return $result;
            }

            try {
                $item = Profile::find($request->id);
                $item->name_profile = $request->name_profile_edit;
                $item->description = $request->description_edit;
                $item->status = $request->status;
                $item->save();

                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Updated');
                $result['redirect'] = route('profiles');
                $result['type_message'] = 'success';
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function delete($id)
    {
        if (\Request::ajax()) {
            try {
                $item = Profile::find($id);
                $item->status = 0;
                $item->save();
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Deleted');
                $result['type_message'] = 'success';
                $result['redirect'] = route('profiles');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function reactivate($id)
    {
        if (\Request::ajax()) {
            try {
                $item = Profile::find($id);
                $item->status = 1;
                $item->save();
                $result['status'] = 1;
                $result['title'] = __('');
                $result['message'] = __('Restored');
                $result['type_message'] = 'success';
                $result['redirect'] = route('profiles');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Search error');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }
}
