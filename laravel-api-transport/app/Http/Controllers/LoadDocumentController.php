<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoadDocumentController extends Controller
{
    public function loadDocument(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,jpg,png,gif',
            'user_id' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'image' => $validator->errors()->get('image')[0],
                'newUrl' => '',
            ]);
        }

        $user = User::findOrFail($request->input('user_id'));

        $newFileName = self::getRandomFileName(public_path() . '/images/', $request->file('image')->getClientOriginalExtension());
        $request->file('image')->move(public_path() . '/images/', $newFileName);
        $user->scan = '/images/' . $newFileName;
        $user->save();

        return response()->json([
            'status' => true,
            'image' => '',
            'newUrl' => url($user->scan),
        ]);
    }

    public static function getRandomFileName($path, $extension = ''): string
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';
        do {
            $name = md5(microtime() . mt_rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));

        return $name . $extension;
    }
}
