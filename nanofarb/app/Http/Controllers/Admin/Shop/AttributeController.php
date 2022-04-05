<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Shop\AttributeRequest;
use App\Managers\DataEditableManager;
use App\Models\Shop\Attribute;
use Fomvasss\LaravelEUS\Facades\EUS;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('attribute.read');

        $attributes = Attribute::withCount('values')->byLocales()->get();

        return view('admin.shop.attributes-values.attributes', compact('attributes'));
    }

    public function store(AttributeRequest $request)
    {
        $this->authorize('attribute.create');

        $slug = EUS::setEntity(new Attribute())
            ->setRawStr($request->title)
            ->setFieldName('slug')
            ->setSlugSeparator('-')
            ->get();

        Attribute::create([
            'title' => $request->title,
            'purpose' => $request->purpose,
            'slug' => $slug,
            'suffix' => $request->suffix,
            'data' => $request->data,
            'locale' => $request->get('locale'),
        ]);

        $destination = $request->session()->pull('destination', route('admin.attributes.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('attribute.update');

        Attribute::findOrFail($id)->update([
            'title' => $request->title,
            'suffix' => $request->suffix,
            'data' => $request->data,
        ]);

        $destination = $request->session()->pull('destination', route('admin.attributes.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('attribute.delete');

        $attribute = Attribute::findOrFail($id);

        $attribute->terms()->detach();
        $attribute->delete();

        $destination = $request->session()->pull('destination', route('admin.attributes.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    public function editable(DataEditableManager $dataEditableMng, Request $request, $id)
    {
        $this->authorize('attribute.update');

        $attribute = Attribute::findOrFail($id);

        $request->validate([
            'name' => 'required|string',    // field name: email, data[answer],...
            'value' => 'nullable|string',   // field value: Hello world!!!
        ]);

        $dataEditableMng->save($attribute, $request->name, $request->value);

        return response()->json(['message' => trans('notifications.update.success')]);
    }
}
