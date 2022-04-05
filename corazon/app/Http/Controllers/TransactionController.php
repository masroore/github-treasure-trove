<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Transaction::all();

        return view('transaction.index', compact('transactions'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('transaction.create');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionStoreRequest $request)
    {
        $transaction = Transaction::create($request->validated());

        $request->session()->flash('transaction.id', $transaction->id);

        return redirect()->route('transaction.index');
    }

    /**
     * @param \App\Transaction $transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Transaction $transaction)
    {
        return view('transaction.show', compact('transaction'));
    }

    /**
     * @param \App\Transaction $transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Transaction $transaction)
    {
        return view('transaction.edit', compact('transaction'));
    }

    /**
     * @param \App\Transaction $transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionUpdateRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());

        $request->session()->flash('transaction.id', $transaction->id);

        return redirect()->route('transaction.index');
    }

    /**
     * @param \App\Transaction $transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transaction.index');
    }
}
