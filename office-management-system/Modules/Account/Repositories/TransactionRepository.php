<?php

namespace Modules\Account\Repositories;

use Modules\Account\Entities\Voucher;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function all()
    {
        return Voucher::where('payment_type', '!=', 'journal_voucher')->latest()->get();
    }

    public function search($dateFrom, $dateTo, $voucher_type, $payment_type, $is_approve, $account_type)
    {
        if ($dateFrom != null && $dateTo != null && $voucher_type != null && $payment_type != null && $is_approve != null) {
            return Voucher::whereBetween('date', [$dateFrom, $dateTo])->where('voucher_type', $voucher_type)->where('payment_type', $payment_type)->where('is_approve', $is_approve)->get();
        } elseif ($dateFrom != null && $dateTo != null && $is_approve != null) {
            return Voucher::whereBetween('date', [$dateFrom, $dateTo])->where('is_approve', $is_approve)->get();
        } elseif ($dateFrom != null && $dateTo != null && $account_type != null) {
            return Voucher::whereBetween('date', [$dateFrom, $dateTo])->where('account_type', $account_type)->get();
        } elseif ($dateFrom != null && $dateTo != null) {
            return Voucher::whereBetween('date', [$dateFrom, $dateTo])->get();
        } elseif ($voucher_type != null && $payment_type != null) {
            return Voucher::where('voucher_type', $voucher_type)->where('payment_type', $payment_type)->get();
        } elseif ($voucher_type != null) {
            return Voucher::where('voucher_type', $voucher_type)->get();
        } elseif ($payment_type != null) {
            return Voucher::where('payment_type', $payment_type)->get();
        } elseif ($is_approve != null) {
            return Voucher::where('is_approve', $is_approve)->get();
        } elseif ($dateFrom != null) {
            return Voucher::where('date', $dateFrom)->get();
        }

        return Voucher::all();
    }

    public function delete($id)
    {
        $voucher = Voucher::where('id', $id)->first();

        return $voucher->delete();
    }
}
