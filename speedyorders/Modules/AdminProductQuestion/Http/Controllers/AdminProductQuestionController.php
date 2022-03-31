<?php

namespace Modules\AdminProductQuestion\Http\Controllers;

use App\Models\Product;
use App\Models\ProductQuestion;
use App\Models\ProductQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminProductQuestion\Http\Requests\CreateAdminProductQuestionRequest;
use Modules\AdminProductQuestion\Http\Requests\UpdateAdminProductQuestionRequest;
use Modules\AdminProductQuestion\Services\CreateProductQuestionService;
use Modules\AdminProductQuestion\Services\UpdateProductQuestionService;

class AdminProductQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'product-questions',
        ];

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $productquestion = ProductQuestion::where('product_id', 'LIKE', "%$keyword%")
                ->orWhere('customer_id', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()
                ->orderByDesc('id')
                ->paginate($perPage);
        } else {
            $productquestion = ProductQuestion::latest()->orderByDesc('id')->paginate($perPage);
        }

        return view('adminproductquestion::index', compact('productquestion'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [
            'menu' => 'product-questions',
        ];
        $products = Product::get();

        return view('adminproductquestion::create', compact('products'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateAdminProductQuestionRequest $request, CreateProductQuestionService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Product question stored successfully.');
        } else {
            session()->flash('error_message', 'Product question could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.product.questions.index');
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
            'menu' => 'product-questions',
        ];
        $productquestion = ProductQuestion::findOrFail($id);

        return view('adminproductquestion::show', compact('productquestion'), $data);
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
            'menu' => 'product-questions',
        ];
        $productquestion = ProductQuestion::findOrFail($id);
        $products = Product::select('id', 'name')->get();
        $productQuestionanswers = ProductQuestionAnswer::where('product_question_id', $id)->orderBy('created_at')->get();

        return view('adminproductquestion::edit', compact('productquestion', 'products', 'productQuestionanswers'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateAdminProductQuestionRequest $request, $id, UpdateProductQuestionService $service)
    {
        $validatedData = $request->validated();

        $productquestion = ProductQuestion::findOrFail($id);

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Product question stored successfully.');
        } else {
            session()->flash('error_message', 'Product question could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.product.questions.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function answer(Request $request, $id)
    {
        $request->validate([
            'answer'=>'nullable|string',
        ]);

        ProductQuestionAnswer::create([
            'product_question_id'=>$id,
            'answer'=>$request->answer,
            'status'=>1,
        ]);

        ProductQuestion::where('id', $id)->first()->update(['status'=>0]);

        return redirect('admin/product-question')->with('flash_message', 'ProductQuestion updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroyAnswer($id)
    {
        ProductQuestionAnswer::destroy($id);

        return redirect('admin/product-question')->with('flash_message', 'Product Question Answer deleted!');
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
        ProductQuestion::destroy($id);

        return redirect('admin/product-question')->with('flash_message', 'ProductQuestion deleted!');
    }
}
