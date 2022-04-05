<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Managers\DataEditableManager;
use App\Models\Shop\Attribute;
use App\Models\Shop\Value;
use Fomvasss\LaravelEUS\Facades\EUS;
use Illuminate\Http\Request;

class ValueController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('value.read');

        $values = Value::where('attribute_id', $request->attribute)->get();
        $attribute = Attribute::findOrFail($request->attribute);

        return view('admin.shop.attributes-values.values', compact('values', 'attribute'));
    }

    public function store(Request $request)
    {
        $this->authorize('value.create');

        $slug = EUS::setEntity(new Value())
            ->setRawStr($request->value)
            ->setFieldName('slug')
            ->setSlugSeparator('-')
            ->get();

        $value = Value::create([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
            'suffix' => $request->suffix,
            'slug' => $slug,
        ]);

        $destination = $request->session()->pull('destination', route('admin.values.index', ['attribute' => $value->attribute->id]));

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('value.update');

        $value = Value::findOrFail($id);
        $value->update([
            'value' => $request->value,
            'suffix' => $request->suffix,
        ]);

        $destination = $request->session()->pull('destination', route('admin.values.index', ['attribute' => $value->attribute->id]));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('value.delete');

        $value = Value::findOrFail($id);

        $value->delete();

        $destination = $request->session()->pull('destination', route('admin.values.index', ['attribute' => $value->attribute_id]));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    public function editable(DataEditableManager $dataEditableMng, Request $request, $id)
    {
        $this->authorize('value.update');

        $value = Value::findOrFail($id);

        $request->validate([
            'name' => 'required|string',    // field name: email, data[answer],...
            'value' => 'nullable|string',   // field value: Hello world!!!
        ]);

        $dataEditableMng->save($value, $request->name, $request->value);

        return response()->json(['message' => trans('notifications.update.success')]);
    }
}
