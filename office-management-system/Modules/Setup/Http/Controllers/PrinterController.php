<?php

namespace Modules\Setup\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Setup\Entities\Printer;
use Modules\Setup\Http\Requests\PrinterRequest;

class PrinterController extends Controller
{
    public function index(Request $request)
    {
        return view('setup::printer.index');
    }

    public function getData()
    {
        try {
            $printers = Printer::latest()->get();

            return view('setup::printer.printer_list', [
                'printers' => $printers,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for District creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function create()
    {
        return view('setup::create');
    }

    public function store(PrinterRequest $request)
    {
        try {
            $printer = new Printer();
            $printer->fill($request->all())->save();
            if ($printer) {
                return response()->json(['message' => 'Model Added Successfully'], 200);
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['message' => $e], 503);
        }
    }

    public function show($id)
    {
        return view('setup::show');
    }

    public function edit($id)
    {
        return Printer::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        try {
            $printer = Printer::findOrFail($id);
            $printer->update($request->all());

            return response()->json([
                'message' => 'Update Successfully',
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function delete($id)
    {
        try {
            Printer::findOrFail($id)->delete();

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }
}
