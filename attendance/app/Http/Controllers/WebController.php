<?php

namespace App\Http\Controllers;

use App\Programme;
use App\User;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->Route('login');

        SEOMeta::setTitle('OguSes IT Solutions | Home');
        SEOMeta::setDescription('We at OguSes IT Solutions strive to provide our clients with the best quality software/website. We code and test every piece of the software/Website to ensure our clients the best quality software/website');
        SEOMeta::setCanonical(route('home'));
        SEOMeta::setKeywords('Oguses IT Solutions, OguSesITSolutions, Ogua, oguses, sesali kaisu, ogua ahmed, ogua, ogua lamere, ogua lamar, ogua software, ogua crm, School management System, Website Design, Mobile phone, web development, software, contactus, Ogua crm, ogua, basic school management system, college school management system, all school management system, IT solutions, Oguses, ogusesitsolutions, ogusesit, oguses solutions, website, records management system, records system, sms alert, sms schedule, sms messages, registry system, registry, mobile applications, SEO, Auditing, stock management system, stock systems, church, church website, church systems, church management system, School system in Ghana, Ghana latest software, Ghana software companies, college management system in Ghana, Ghana software companies, Ghana school software company');

        OpenGraph::setDescription('We at OguSes IT Solutions strive to provide our clients with the best quality software/website. We code and test every piece of the software/Website to ensure our clients the best quality software/website');
        OpenGraph::setTitle('OguSes IT Solutions | Home');
        OpenGraph::setUrl(route('home'));
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addImage(URL::to('images/bg2.jpg'));

        TwitterCard::setTitle('OguSes IT Solutions | Home');
        TwitterCard::setSite('@ogua.ahmed18');
        TwitterCard::setImage(URL::to('images/bg2.jpg'));
        TwitterCard::setDescription('We at OguSes IT Solutions strive to provide our clients with the best quality software/website. We code and test every piece of the software/Website to ensure our clients the best quality software/website');

        JsonLd::setTitle('OguSes IT Solutions | Home');
        JsonLd::setDescription('We at OguSes IT Solutions strive to provide our clients with the best quality software/website.
            We code and test every piece of the software/Website to ensure our clients the best quality software/website');
        JsonLd::addImage(URL::to('images/bg2.jpg'));

        return view('web.index');
    }

    public function about()
    {
        return view('web.about');
    }

    public function menu()
    {
        $pros = Programme::all();

        return view('menu.menu', ['programmes' => $pros]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function student()
    {
        return view('auth.student_login');
    }

    public function student_login(Request $request)
    {
        $index = $request->post('id-number');
        $password = $request->post('password');

        //echo $index;
        $user = User::where('indexnumber', $index)->first();

        if (!$user) {
            return Redirect()->back()->with('error', 'Oppes! You have entered invalid credentials');
        }

        $email = $user->email;

        $credentials = ['email' => $email, 'password' => $password];

        if (Auth::attempt($credentials)) {
            $user->is_active = '1';
            $user->save();

            return redirect()->route('dashboard');
        }

        return Redirect()->route('student-login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function student_online_login()
    {
        return view('auth.online_payment');
    }

    public function student_onlinepay_login(Request $request)
    {
        $index = $request->post('id-number');
        $password = $request->post('password');

        //echo $index;
        $user = User::where('indexnumber', $index)->first();

        if (!$user) {
            return Redirect()->back()->with('error', 'Oppes! You have entered invalid credentials');
        }

        $email = $user->email;

        $credentials = ['email' => $email, 'password' => $password];

        if (Auth::attempt($credentials)) {
            $user->is_active = '1';
            $user->save();

            return redirect()->route('pay_mandatory_fees');
        }

        return Redirect()->route('student-onlinepay-login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function lecturer()
    {
        return view('auth.lecture_login');
    }

    public function lecturer_login(Request $request)
    {
        $index = $request->post('id-number');
        $password = $request->post('password');

        //echo $index;
        $user = User::where('indexnumber', $index)->first();

        if (!$user) {
            return Redirect()->back()->with('error', 'Oppes! You have entered invalid credentials');
        }

        $email = $user->email;

        $credentials = ['email' => $email, 'password' => $password];

        if (Auth::attempt($credentials)) {
            $user->is_active = '1';
            $user->save();

            return redirect()->route('dashboard');
        }

        return Redirect()->route('lecturer-login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function sitemapview()
    {
        // return response($xml, 200)->header('Content-Type', 'application/xml');
        return response()->view('sitemap')
            ->header('Content-Type', 'text/xml');
    }
}
