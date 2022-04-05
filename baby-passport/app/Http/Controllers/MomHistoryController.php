<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\LogTrait;
use Illuminate\Http\Request;

class MomHistoryController extends Controller
{
    use LogTrait;

    public function postSavePreregister(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->all();
        unset($data['_token']);

        if (empty($user)) {
            $request->session()->flash('error', 'Usuario no encontrado');

            return back();
        }

        try {
            if ($user->momHistory == null) {
                $user->momHistory()->create($data);
            }

            $user->momHistory()->update($data);

            $request->session()->put('process-step-number', 4);
            $request->session()->flash('success', 'Tu preregistro ha sido actualizado correctamente');

            return back()->withInput();
        } catch (QueryException $e) {
            $log = $this->saveLog($e->getMessage(), $e->getCode(), 'database');

            $request->session()->flash('error', 'Hubo un error al actualizar tu preregistro, intenta más tarde');

            return back()
                ->withInput();
        }
    }
}
