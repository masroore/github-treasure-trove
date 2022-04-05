<?php

namespace App\Http\Controllers;

class ServiceController extends Controller
{
    /**
     * cookie policy page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cookiesPolicy()
    {
        return view('cookiespolicy');
    }

    /**
     * term of service page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function termOfService()
    {
        return view('termofservice');
    }

    /**
     * privacy notice.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function privacyNotice()
    {
        return view('privacynotice');
    }

    /**
     * disclosure.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function disclosures()
    {
        return view('disclosures');
    }
}
