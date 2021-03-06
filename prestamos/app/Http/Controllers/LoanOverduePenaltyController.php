<?php

namespace App\Http\Controllers;

use App\Models\LoanOverduePenalty;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class LoanOverduePenaltyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['sentinel', 'branch']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = LoanOverduePenalty::all();

        return view('loan_overdue_penalty.data', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('loan_overdue_penalty.create', compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loan_overdue_penalty = new LoanOverduePenalty();
        $loan_overdue_penalty->name = $request->name;
        $loan_overdue_penalty->type = $request->type;
        $loan_overdue_penalty->amount = $request->amount;
        $loan_overdue_penalty->days = $request->days;
        $loan_overdue_penalty->notes = $request->notes;
        $loan_overdue_penalty->save();
        Flash::success(trans('general.successfully_saved'));

        return redirect('loan/loan_overdue_penalty/data');
    }

    public function show($loan_overdue_penalty): void
    {
    }

    public function edit($loan_overdue_penalty)
    {
        return view('loan_overdue_penalty.edit', compact('loan_overdue_penalty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $loan_overdue_penalty = LoanOverduePenalty::find($id);
        $loan_overdue_penalty->name = $request->name;
        $loan_overdue_penalty->type = $request->type;
        $loan_overdue_penalty->amount = $request->amount;
        $loan_overdue_penalty->days = $request->days;
        $loan_overdue_penalty->notes = $request->notes;
        $loan_overdue_penalty->save();
        Flash::success(trans('general.successfully_saved'));

        return redirect('loan/loan_overdue_penalty/data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        LoanOverduePenalty::destroy($id);
        Flash::success(trans('general.successfully_deleted'));

        return redirect('loan/loan_overdue_penalty/data');
    }
}
