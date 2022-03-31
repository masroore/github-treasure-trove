<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyReviewRequest;
use App\Http\Requests\StorePropoertyInquiryRequest;
use App\Models\AboutUs;
use App\Models\Blog;
use App\Models\OurPartner;
use App\Models\Property;
use App\Models\PropertyReview;
use App\Models\PropoertyInquiry;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $properties = Property::with(['type', 'tags', 'amenities', 'created_by', 'media'])->orderBy('id', 'asc')->limit(6)->get();
        $properties_all = Property::with(['type', 'tags', 'amenities', 'created_by', 'media'])->orderBy('id', 'asc')->get();
        $blogs = Blog::with(['created_by', 'media'])->orderBy('id', 'asc')->limit(3)->get();
        $ourPartners = OurPartner::with(['media'])->get();

        return view('welcome', compact('properties', 'properties_all', 'blogs', 'ourPartners'));
    }

    // single property
    public function property($id)
    {
        $property = Property::with(['type', 'tags', 'amenities', 'created_by', 'media'])->find($id);
        $propertyReviews = PropertyReview::where('property_id', '=', $id)->with(['property', 'created_by'])->orderBy('id', 'asc')->get();

        return view('property', compact('property', 'propertyReviews'));
    }

    public function storeInquiry(StorePropoertyInquiryRequest $request)
    {
        $propoertyInquiry = PropoertyInquiry::create($request->all());

        return redirect()->back();
    }

    public function createPropertyReview(StorePropertyReviewRequest $request)
    {
        $propertyReview = PropertyReview::create($request->all());

        return redirect()->back();
    }

    public function allProperties()
    {
        $properties_all = Property::with(['type', 'tags', 'amenities', 'created_by', 'media'])->orderBy('id', 'asc')->get();

        return view('all-properties', compact('properties_all'));
    }

    public function aboutUs()
    {
        $about = AboutUs::orderBy('id', 'desc')->limit(1)->get();

        return view('about', compact('about'));
    }

    public function allBlogs()
    {
        $blogs = Blog::orderBy('id', 'desc')->get();

        return view('blog', compact('blogs'));
    }

    public function contactUs()
    {
        return view('contact-us');
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $properties = Property::where('property_title', 'like', '%' . $search . '%')
            ->orWhere('property_description', 'like', '%' . $search . '%')
            ->orWhere('rooms', 'like', '%' . $search . '%')
            ->orWhere('property_price', 'like', '%' . $search . '%')
            ->orWhere('per', 'like', '%' . $search . '%')
            ->orWhere('year_built', 'like', '%' . $search . '%')
            ->orWhere('area', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
            ->orWhere('available', 'like', '%' . $search . '%')
            ->orWhere('location', 'like', '%' . $search . '%')
            ->get();

        return view('search', compact('properties'));
    }
}
