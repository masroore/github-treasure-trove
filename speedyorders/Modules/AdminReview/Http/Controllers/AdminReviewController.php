<?php

namespace Modules\AdminReview\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Modules\AdminReview\Http\Requests\CreateReviewRequest;
use Modules\AdminReview\Http\Requests\UpdateReviewRequest;
use Modules\AdminReview\Services\CreateReviewService;

class AdminReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'reviews',
        ];
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $reviews = Review::where('product_id', 'LIKE', "%$keyword%")
                ->orWhere('customer_id', 'LIKE', "%$keyword%")
                ->orWhere('author', 'LIKE', "%$keyword%")
                ->orWhere('text', 'LIKE', "%$keyword%")
                ->orWhere('product_id', 'LIKE', "%$keyword%")
                ->orWhere('order_item_id', 'LIKE', "%$keyword%")
                ->orWhere('rating', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->with('product', 'customer')
                ->orderByDesc('id')
                ->latest()->paginate($perPage);
        } else {
            $reviews = Review::latest()->orderByDesc('id')->with('product', 'customer')->paginate($perPage);
        }

        return view('adminreview::index', compact('reviews'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [
            'menu' => 'reviews',
        ];
        $products = Product::get();

        return view('adminreview::create', compact('products'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateReviewRequest $request, CreateReviewService $service)
    {
        $validatedData = $request->validated();
        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Review stored successfully.');
        } else {
            session()->flash('error_message', 'Review could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.reviews.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $data = [
            'menu' => 'reviews',
        ];
        $review = Review::findOrFail($id);

        return view('adminreview::show', compact('review'), $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = [
            'menu' => 'reviews',
        ];
        $review = Review::findOrFail($id);
        $products = Product::get();

        return view('adminreview::edit', compact('review', 'products'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateReviewRequest $request, $id, UpdateReviewService $service)
    {
        $review = Review::findOrFail($id);

        $validatedData = $request->validated();
        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Review updated successfully.');
        } else {
            session()->flash('error_message', 'Review could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.reviews.index')->with('flash_message', 'Review updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Review::destroy($id);

        return redirect()->route('admin.reviews.index')->with('flash_message', 'Review deleted!');
    }

    public function updateReviewStatus($id)
    {
        try {
            $review = Review::find($id);
            if ('1' == $review->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            Review::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'Review updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Review could not be updated.');
        }

        return redirect()->route('admin.reviews.index');
    }
}
