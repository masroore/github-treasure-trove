<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Managers\DataEditableManager;
use App\Models\Shop\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('form.read'); //TODO

        $reviews = ProductReview::with('product')->orderByDesc('created_at')->paginate();

        return view('admin.shop.product-reviews.index', compact('reviews'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request, $id)
    {
        $this->authorize('form.update');

        $review = ProductReview::findOrFail($id);
        $review->setAttribute('status', $request->value);
        $review->save();

        return response()->json(['message' => trans('notifications.update.success')]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editable(DataEditableManager $dataEditableMng, Request $request, $id)
    {
        $this->authorize('form.update');

        $review = ProductReview::findOrFail($id);

        $request->validate([
            'name' => 'required|string',    // field name: email, data[answer],...
            'value' => 'nullable|string',   // field value: Hello world!!!
        ]);

        $dataEditableMng->save($review, $request->name, $request->value);

        return response()->json(['message' => trans('notifications.update.success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('form.delete');

        $review = ProductReview::findOrFail($id);

        $review->delete();

        $destination = $request->session()->pull('destination', route('admin.product-reviews.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }
}
