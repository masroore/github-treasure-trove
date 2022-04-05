<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Managers\DataEditableManager;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        $this->authorize('form.read');

        $forms = Form::byType($type)->orderBy('created_at', 'desc')->paginate();

        return view()->first(['admin.forms.' . $type, 'admin.forms.index'], compact('forms'));
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

        $form = Form::findOrFail($id);

        $form->terms()->detach();
        $form->media()->each(function ($m): void {
            $m->delete();
        });

        $form->delete();

        $destination = $request->session()->pull('destination', route('admin.forms.index', $form->type));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request, $id)
    {
        $this->authorize('form.update');

        $form = Form::findOrFail($id);
        $form->setAttribute('status', $request->value);
        $form->save();

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

        $form = Form::findOrFail($id);

        $request->validate([
            'name' => 'required|string',    // field name: email, data[answer],...
            'value' => 'nullable|string',   // field value: Hello world!!!
        ]);

        $dataEditableMng->save($form, $request->name, $request->value);

        return response()->json(['message' => trans('notifications.update.success')]);
    }
}
