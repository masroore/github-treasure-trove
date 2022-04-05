<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ProductServiceCategory extends Model
{
    public static $categoryType = [
        'Product & Service',
        'Income',
        'Expense',
    ];

    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];

    public function categories()
    {
        return $this->hasMany('App\Revenue', 'category_id', 'id');
    }

    public function incomeCategoryRevenueAmount()
    {
        $year = date('Y');
        $revenue = $this->hasMany('App\Revenue', 'category_id', 'id')->where('created_by', Auth::user()->creatorId())->whereRAW('YEAR(date) =?', [$year])->sum('amount');

        $invoices = $this->hasMany('App\Invoice', 'category_id', 'id')->where('created_by', Auth::user()->creatorId())->whereRAW('YEAR(send_date) =?', [$year])->get();
        $invoiceArray = [];
        foreach ($invoices as $invoice) {
            $invoiceArray[] = $invoice->getTotal();
        }

        return (!empty($revenue) ? $revenue : 0) + (!empty($invoiceArray) ? array_sum($invoiceArray) : 0);
    }

    public function expenseCategoryAmount()
    {
        $year = date('Y');
        $payment = $this->hasMany('App\Payment', 'category_id', 'id')->where('created_by', Auth::user()->creatorId())->whereRAW('YEAR(date) =?', [$year])->sum('amount');

        $bills = $this->hasMany('App\Bill', 'category_id', 'id')->where('created_by', Auth::user()->creatorId())->whereRAW('YEAR(send_date) =?', [$year])->get();
        $billArray = [];
        foreach ($bills as $bill) {
            $billArray[] = $bill->getTotal();
        }

        return (!empty($payment) ? $payment : 0) + (!empty($billArray) ? array_sum($billArray) : 0);
    }
}
