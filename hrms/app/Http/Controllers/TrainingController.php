<?php

namespace App\Http\Controllers;

use App\Exports\TrainingExport;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Trainer;
use App\Models\Training;
use App\Models\TrainingType;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class TrainingController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Training')) {
            $trainings = Training::where('created_by', '=', Auth::user()->creatorId())->get();
            $status = Training::$Status;
            // dd($status);

            return view('training.index', compact('trainings', 'status'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function create()
    {
        if (Auth::user()->can('Create Training')) {
            $branches = Branch::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $trainingTypes = TrainingType::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $trainers = Trainer::where('created_by', Auth::user()->creatorId())->get()->pluck('firstname', 'id');
            $employees = Employee::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $options = Training::$options;

            return view('training.create', compact('branches', 'trainingTypes', 'trainers', 'employees', 'options'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Training')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'branch' => 'required',
                    'training_type' => 'required',
                    'training_cost' => 'required',
                    'employee' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $training = new Training();
            $training->branch = $request->branch;
            $training->trainer_option = $request->trainer_option;
            $training->training_type = $request->training_type;
            $training->trainer = $request->trainer;
            $training->training_cost = $request->training_cost;
            $training->employee = $request->employee;
            $training->start_date = $request->start_date;
            $training->end_date = $request->end_date;
            $training->description = $request->description;
            $training->created_by = Auth::user()->creatorId();
            $training->save();

            return redirect()->route('training.index')->with('success', __('Training successfully created.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function show($id)
    {
        $traId = Crypt::decrypt($id);
        $training = Training::find($traId);
        $performance = Training::$performance;
        $status = Training::$Status;

        return view('training.show', compact('training', 'performance', 'status'));
    }

    public function edit(Training $training)
    {
        if (Auth::user()->can('Create Training')) {
            $branches = Branch::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $trainingTypes = TrainingType::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $trainers = Trainer::where('created_by', Auth::user()->creatorId())->get()->pluck('firstname', 'id');
            $employees = Employee::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $options = Training::$options;

            return view('training.edit', compact('branches', 'trainingTypes', 'trainers', 'employees', 'options', 'training'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function update(Request $request, Training $training)
    {
        if (Auth::user()->can('Edit Training')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'branch' => 'required',
                    'training_type' => 'required',
                    'training_cost' => 'required',
                    'employee' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $training->branch = $request->branch;
            $training->trainer_option = $request->trainer_option;
            $training->training_type = $request->training_type;
            $training->trainer = $request->trainer;
            $training->training_cost = $request->training_cost;
            $training->employee = $request->employee;
            $training->start_date = $request->start_date;
            $training->end_date = $request->end_date;
            $training->description = $request->description;
            $training->save();

            return redirect()->route('training.index')->with('success', __('Training successfully updated.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function destroy(Training $training)
    {
        if (Auth::user()->can('Delete Training')) {
            if ($training->created_by == Auth::user()->creatorId()) {
                $training->delete();

                return redirect()->route('training.index')->with('success', __('Training successfully deleted.'));
            }

            return redirect()->back()->with('error', __('Permission denied.'));
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function updateStatus(Request $request)
    {
        $training = Training::find($request->id);
        $training->performance = $request->performance;
        $training->status = $request->status;
        $training->remarks = $request->remarks;
        $training->save();

        return redirect()->route('training.index')->with('success', __('Training status successfully updated.'));
    }

    public function export()
    {
        $name = 'training_' . date('Y-m-d i:h:s');
        $data = Excel::download(new TrainingExport(), $name . '.xlsx');
        ob_end_clean();

        return $data;
    }
}
