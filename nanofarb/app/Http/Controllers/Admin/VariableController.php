<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Artisan;
use Cache;
use Fomvasss\Variable\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VariableController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forms(Request $request)
    {
        $this->authorize('variable.read');

        return view()->first(["admin.variables.$request->form", 'admin.variables.forms']);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $this->authorize('variable.update');

        $this->validate($request, [
            'vars' => 'array',
            'vars.*' => 'nullable|string',
            'vars_file.*' => 'file',
            'vars_json' => 'array',
        ]);

        foreach ($request->get('vars', []) as $key => $value) {
            if ($request->group == 'prices' || in_array($key, ['delivery_courier_price'])) {
                $this->updateOrCreate($key, $value * 100, $request->get('locale'));
            } else {
                $this->updateOrCreate($key, $value, $request->get('locale'));
            }
        }

        foreach ($request->get('vars_json', []) as $key => $value) {
            $this->updateOrCreate($key, json_encode($value), $request->get('locale'));
        }

        foreach ($request->get('vars_deleted', []) as $key => $value) {
            if ($value) {
                if (variable($key) && (Storage::disk('public')->exists(variable($key)))) {
                    Storage::disk('public')->delete(variable($key));
                }
                $this->updateOrCreate($key, null);
            }
        }

        foreach ($request->file('vars_file', []) as $key => $value) {
            if (variable($key) && (Storage::disk('public')->exists(variable($key)))) {
                Storage::disk('public')->delete(variable($key));
            }
            if ($request->no_rename_all_files || in_array($key, $request->get('no_rename_files', []))) {
                $fileName = Storage::disk('public')->putFileAs('variables', $value, $value->getClientOriginalName());
            } else {
                $fileName = Storage::disk('public')->putFile('variables', $value);
            }

            $this->updateOrCreate($key, $fileName);
        }

        Cache::forget('laravel.variables.cache');
        Artisan::call('config:clear');

        $destination = $request->session()->pull('destination', route('admin.variable.forms'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    protected function updateOrCreate($key, $value, $locale = null): void
    {
        $localable = config('variables.localable', []);
        $setLocale = in_array($key, $localable) ? $locale : null;

        Variable::updateOrCreate(['key' => $key, 'locale' => $setLocale], ['value' => $value]);
    }
}
