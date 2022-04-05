<?php

namespace App\Http\Controllers\Back\Settings;

use App\Http\Controllers\Controller;
use App\Models\Back\Photo;
use App\Models\Back\Users\Client;
use App\User;
use Bouncer;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Bouncer::is(auth()->user())->an('admin')) {
            $user = User::where('id', auth()->user()->id)->with('details')->first();

            return view('back.users.user.edit', compact('user'));
        }

        $client = Client::where('user_id', auth()->user()->id)->with('user')->first();

        return view('back.settings.profile.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id == auth()->user()->id) {
            $user = User::find($id);
            $updated = $user->validateRequest($request)->updateData($user->id);

            if ($updated) {
                if ($request->hasFile('user_image')) {
                    $path = Photo::imageUpload($request->file('user_image'), $updated, 'user', 'avatar');

                    $user->updateImagePath($user->id, $path);
                }

                return redirect()->route('profile')->with(['success' => 'Profil je uspješno snimljen!']);
            }
        }

        return redirect()->back()->with(['error' => 'Whoops..! Dogodila se greška prilikom snimanja profila.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateClient(Request $request, Client $client)
    {
        $client_updated = $client->validateRequest($request)->updateData($client->id);

        if ($client_updated) {
            if ($request->hasFile('client_image')) {
                $path = Photo::imageUpload($request->file('client_image'), $client_updated, 'client', 'logo');

                $client->updateImagePath($client->id, $path);
            }

            return redirect()->route('profile')->with(['success' => 'Klijent je uspješno snimljen.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem klijenta...']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeClient(Request $request)
    {
        $client = new Client();

        $request->user_id = auth()->user()->id;
        $request->plan_id = 1;

        $client_stored = $client->validateRequest($request)->storeData();

        if ($client_stored) {
            if ($request->hasFile('client_image')) {
                $path = Photo::imageUpload($request->file('client_image'), $client_stored, 'client', 'logo');

                $client->updateImagePath($client->id, $path);
            }

            return redirect()->route('profile')->with(['success' => 'Klijent je uspješno snimljen.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem klijenta...']);
    }
}
