<?php

namespace App\Http\Controllers\Front;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Back\Users\Message;
use App\Models\Front\Page;
use App\Models\Front\Slider;
use App\Models\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $sliders = Cache::rememberForever('sliders', function () {
            return Slider::home()->get();
        });

        return view('front.home', compact('sliders'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function proccessContactMessage(Request $request)
    {
        if ($request->has('user_id') && '0' != $request->input('user_id')) {
            $request['recipient'] = $request->input('user_id');

            $message = new Message();
            $message_stored = $message->validateRequest($request)->storeData();

            event(new MessageSent($message_stored));

            if ($message_stored) {
                return redirect()->back()->with(['success' => 'Poruka je uspješno poslana.!']);
            }
        }

        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'message' => 'required',
        ]);

        $recaptcha = (new Recaptcha())->check($request->toArray());

        if ($recaptcha && !$recaptcha->ok()) {
            return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa slanjem poruke. Molimo pokušajte kasnije!']);
        }

        try {
            Mail::to(config('mail.admin_default'))->send(new \App\Mail\Message($request));

            return redirect()->back()->with(['success' => 'Vaša poruka je uspješno poslana..! Netko će vas ubrzo kontaktirati.']);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa slanjem poruke. Molimo pokušajte kasnije!']);
        }

        return redirect()->back()->with(['success' => 'Poruka je uspješno poslana.!']);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(Request $request)
    {
        $role_id = DB::table('roles')->where('name', $request->role)->pluck('id');

        if ('admin' == $request->role) {
            $user_id = 3;
        } else {
            $user_id = DB::table('assigned_roles')->where('role_id', $role_id)->pluck('entity_id');
        }

        Auth::loginUsingId($user_id);

        return redirect()->route('dashboard');
    }

    public function sitemap(Request $request)
    {
        Log::debug($request);

        $pages = Page::published()->get();

        /*foreach ($pages as $page) {
            if ( ! isset($page->cat)) {
                Log::debug($page->subcat()->first()->parent->slug);
            } else {
                if (isset($page->subcat)) {
                    Log::debug($page->subcat->slug);
                } else {
                    Log::debug($page->cat->slug);
                }
            }
        }*/

        $content = View::make('front.sitemap', ['pages' => $pages]);

        return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');

        //return view('front.sitemap', compact('pages'));
    }
}
