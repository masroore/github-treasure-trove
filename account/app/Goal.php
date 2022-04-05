<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public static $goalType = [
        'Invoice',
        'Bill',
        'Revenue',
        'Payment',
    ];

    protected $fillable = [
        'name',
        'type',
        'from',
        'to',
        'amount',
        'is_display',
        'created_by',
    ];

    public function target($type, $from, $to, $amount)
    {
        $total = 0;
        $fromDate = $from . '-01';
        $toDate = $to . '-01';
        if ('Invoice' == self::$goalType[$type]) {
            $invoices = Invoice::select('*')->where('created_by', Auth::user()->creatorId())->where('issue_date', '>=', $fromDate)->where('issue_date', '<=', $toDate)->get();
            $total = 0;
            foreach ($invoices as $invoice) {
                $total += $invoice->getTotal();
            }
        } elseif ('Bill' == self::$goalType[$type]) {
            $bills = Bill::select('*')->where('created_by', Auth::user()->creatorId())->where('bill_date', '>=', $fromDate)->where('bill_date', '<=', $toDate)->get();
            $total = 0;
            foreach ($bills as $bill) {
                $total += $bill->getTotal();
            }
        } elseif ('Revenue' == self::$goalType[$type]) {
            $revenues = Revenue::select('*')->where('created_by', Auth::user()->creatorId())->where('date', '>=', $fromDate)->where('date', '<=', $toDate)->get();
            $total = 0;

            foreach ($revenues as $revenue) {
                $total += $revenue->amount;
            }
        } elseif ('Payment' == self::$goalType[$type]) {
            $payments = Payment::select('*')->where('created_by', Auth::user()->creatorId())->where('date', '>=', $fromDate)->where('date', '<=', $toDate)->get();
            $total = 0;

            foreach ($payments as $payment) {
                $total += $payment->amount;
            }
        }

        $data['percentage'] = ($total * 100) / $amount;
        $data['total'] = $total;

        return $data;
    }
}
