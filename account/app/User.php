<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    public $settings;

    protected $appends = ['profile'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'avatar',
        'lang',
        'delete_status',
        'plan',
        'plan_expire_date',
        'created_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function authId()
    {
        return $this->id;
    }

    public function creatorId()
    {
        if ('company' == $this->type || 'super admin' == $this->type) {
            return $this->id;
        }

        return $this->created_by;
    }

    public function currentLanguage()
    {
        return $this->lang;
    }

    public function priceFormat($price)
    {
        $settings = Utility::settings();

        return (('pre' == $settings['site_currency_symbol_position']) ? $settings['site_currency_symbol'] : '') . number_format($price, Utility::getValByName('decimal_number')) . (('post' == $settings['site_currency_symbol_position']) ? $settings['site_currency_symbol'] : '');
    }

    public function currencySymbol()
    {
        $settings = Utility::settings();

        return $settings['site_currency_symbol'];
    }

    public function dateFormat($date)
    {
        $settings = Utility::settings();

        return date($settings['site_date_format'], strtotime($date));
    }

    public function timeFormat($time)
    {
        $settings = Utility::settings();

        return date($settings['site_time_format'], strtotime($time));
    }

    public function invoiceNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings['invoice_prefix'] . sprintf('%05d', $number);
    }

    public function proposalNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings['proposal_prefix'] . sprintf('%05d', $number);
    }

    public function billNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings['bill_prefix'] . sprintf('%05d', $number);
    }

    public function journalNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings['journal_prefix'] . sprintf('%05d', $number);
    }

    public function journalWithPrefix($number, $prefix)
    {
        return $prefix . sprintf('%05d', $number);
    }

    public function getPlan()
    {
        return $this->hasOne('App\Plan', 'id', 'plan');
    }

    public function assignPlan($planID)
    {
        $plan = Plan::find($planID);
        if ($plan) {
            $this->plan = $plan->id;
            if ('month' == $plan->duration) {
                $this->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            } elseif ('year' == $plan->duration) {
                $this->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            }
            $this->save();

            $users = self::where('created_by', '=', Auth::user()->creatorId())->where('type', '!=', 'super admin')->where('type', '!=', 'company')->get();
            $customers = Customer::where('created_by', '=', Auth::user()->creatorId())->get();
            $venders = Vender::where('created_by', '=', Auth::user()->creatorId())->get();

            if (-1 == $plan->max_users) {
                foreach ($users as $user) {
                    $user->is_active = 1;
                    $user->save();
                }
            } else {
                $userCount = 0;
                foreach ($users as $user) {
                    ++$userCount;
                    if ($userCount <= $plan->max_users) {
                        $user->is_active = 1;
                        $user->save();
                    } else {
                        $user->is_active = 0;
                        $user->save();
                    }
                }
            }

            if (-1 == $plan->max_customers) {
                foreach ($customers as $customer) {
                    $customer->is_active = 1;
                    $customer->save();
                }
            } else {
                $customerCount = 0;
                foreach ($customers as $customer) {
                    ++$customerCount;
                    if ($customerCount <= $plan->max_customers) {
                        $customer->is_active = 1;
                        $customer->save();
                    } else {
                        $customer->is_active = 0;
                        $customer->save();
                    }
                }
            }

            if (-1 == $plan->max_venders) {
                foreach ($venders as $vender) {
                    $vender->is_active = 1;
                    $vender->save();
                }
            } else {
                $venderCount = 0;
                foreach ($venders as $vender) {
                    ++$venderCount;
                    if ($venderCount <= $plan->max_venders) {
                        $vender->is_active = 1;
                        $vender->save();
                    } else {
                        $vender->is_active = 0;
                        $vender->save();
                    }
                }
            }

            return ['is_success' => true];
        }

        return [
            'is_success' => false,
            'error' => 'Plan is deleted.',
        ];
    }

    public function customerNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings['customer_prefix'] . sprintf('%05d', $number);
    }

    public function venderNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings['vender_prefix'] . sprintf('%05d', $number);
    }

    public function countUsers()
    {
        return self::where('type', '!=', 'super admin')->where('type', '!=', 'company')->where('created_by', '=', $this->creatorId())->count();
    }

    public function countCompany()
    {
        return self::where('type', '=', 'company')->where('created_by', '=', $this->creatorId())->count();
    }

    public function countOrder()
    {
        return Order::count();
    }

    public function countplan()
    {
        return Plan::count();
    }

    public function countPaidCompany()
    {
        return self::where('type', '=', 'company')->whereNotIn(
            'plan',
            [
                0,
                1,
            ]
        )->where('created_by', '=', Auth::user()->id)->count();
    }

    public function countCustomers()
    {
        return Customer::where('created_by', '=', $this->creatorId())->count();
    }

    public function countVenders()
    {
        return Vender::where('created_by', '=', $this->creatorId())->count();
    }

    public function countInvoices()
    {
        return Invoice::where('created_by', '=', $this->creatorId())->count();
    }

    public function countBills()
    {
        return Bill::where('created_by', '=', $this->creatorId())->count();
    }

    public function todayIncome()
    {
        $revenue = Revenue::where('created_by', '=', $this->creatorId())->whereRaw('Date(date) = CURDATE()')->where('created_by', Auth::user()->creatorId())->sum('amount');
        $invoices = Invoice::select('*')->where('created_by', Auth::user()->creatorId())->whereRAW('Date(send_date) = CURDATE()')->get();
        $invoiceArray = [];
        foreach ($invoices as $invoice) {
            $invoiceArray[] = $invoice->getTotal();
        }

        return (!empty($revenue) ? $revenue : 0) + (!empty($invoiceArray) ? array_sum($invoiceArray) : 0);
    }

    public function todayExpense()
    {
        $payment = Payment::where('created_by', '=', $this->creatorId())->where('created_by', Auth::user()->creatorId())->whereRaw('Date(date) = CURDATE()')->sum('amount');

        $bills = Bill::select('*')->where('created_by', Auth::user()->creatorId())->whereRAW('Date(send_date) = CURDATE()')->get();

        $billArray = [];
        foreach ($bills as $bill) {
            $billArray[] = $bill->getTotal();
        }

        return (!empty($payment) ? $payment : 0) + (!empty($billArray) ? array_sum($billArray) : 0);
    }

    public function incomeCurrentMonth()
    {
        $currentMonth = date('m');
        $revenue = Revenue::where('created_by', '=', $this->creatorId())->whereRaw('MONTH(date) = ?', [$currentMonth])->sum('amount');

        $invoices = Invoice::select('*')->where('created_by', Auth::user()->creatorId())->whereRAW('MONTH(send_date) = ?', [$currentMonth])->get();

        $invoiceArray = [];
        foreach ($invoices as $invoice) {
            $invoiceArray[] = $invoice->getTotal();
        }

        return (!empty($revenue) ? $revenue : 0) + (!empty($invoiceArray) ? array_sum($invoiceArray) : 0);
    }

    public function expenseCurrentMonth()
    {
        $currentMonth = date('m');

        $payment = Payment::where('created_by', '=', $this->creatorId())->whereRaw('MONTH(date) = ?', [$currentMonth])->sum('amount');

        $bills = Bill::select('*')->where('created_by', Auth::user()->creatorId())->whereRAW('MONTH(send_date) = ?', [$currentMonth])->get();
        $billArray = [];
        foreach ($bills as $bill) {
            $billArray[] = $bill->getTotal();
        }

        return (!empty($payment) ? $payment : 0) + (!empty($billArray) ? array_sum($billArray) : 0);
    }

    public function getincExpBarChartData()
    {
        $month[] = __('January');
        $month[] = __('February');
        $month[] = __('March');
        $month[] = __('April');
        $month[] = __('May');
        $month[] = __('June');
        $month[] = __('July');
        $month[] = __('August');
        $month[] = __('September');
        $month[] = __('October');
        $month[] = __('November');
        $month[] = __('December');
        $dataArr['month'] = $month;

        for ($i = 1; $i <= 12; ++$i) {
            $monthlyIncome = Revenue::selectRaw('sum(amount) amount')->where('created_by', '=', $this->creatorId())->whereRaw('year(`date`) = ?', [date('Y')])->whereRaw('month(`date`) = ?', $i)->first();
            $invoices = Invoice::select('*')->where('created_by', Auth::user()->creatorId())->whereRaw('year(`send_date`) = ?', [date('Y')])->whereRaw('month(`send_date`) = ?', $i)->get();

            $invoiceArray = [];
            foreach ($invoices as $invoice) {
                $invoiceArray[] = $invoice->getTotal();
            }
            $totalIncome = (!empty($monthlyIncome) ? $monthlyIncome->amount : 0) + (!empty($invoiceArray) ? array_sum($invoiceArray) : 0);

            $incomeArr[] = !empty($totalIncome) ? number_format($totalIncome, 2) : 0;

            $monthlyExpense = Payment::selectRaw('sum(amount) amount')->where('created_by', '=', $this->creatorId())->whereRaw('year(`date`) = ?', [date('Y')])->whereRaw('month(`date`) = ?', $i)->first();
            $bills = Bill::select('*')->where('created_by', Auth::user()->creatorId())->whereRaw('year(`send_date`) = ?', [date('Y')])->whereRaw('month(`send_date`) = ?', $i)->get();
            $billArray = [];
            foreach ($bills as $bill) {
                $billArray[] = $bill->getTotal();
            }

            $totalExpense = (!empty($monthlyExpense) ? $monthlyExpense->amount : 0) + (!empty($billArray) ? array_sum($billArray) : 0);

            $expenseArr[] = !empty($totalExpense) ? number_format($totalExpense, 2) : 0;
        }

        $dataArr['income'] = $incomeArr;
        $dataArr['expense'] = $expenseArr;

        return $dataArr;
    }

    public function getIncExpLineChartDate()
    {
        $usr = Auth::user();
        $m = date('m');
        $de = date('d');
        $y = date('Y');
        $format = 'Y-m-d';
        $arrDate = [];
        $arrDateFormat = [];

        for ($i = 0; $i <= 15 - 1; ++$i) {
            $date = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));

            $arrDay[] = date('D', mktime(0, 0, 0, $m, ($de - $i), $y));
            $arrDate[] = $date;
            $arrDateFormat[] = date('d-M', strtotime($date));
        }
        $dataArr['day'] = $arrDateFormat;
        for ($i = 0; $i < \count($arrDate); ++$i) {
            $dayIncome = Revenue::selectRaw('sum(amount) amount')->where('created_by', Auth::user()->creatorId())->whereRaw('date = ?', $arrDate[$i])->first();

            $invoices = Invoice::select('*')->where('created_by', Auth::user()->creatorId())->whereRAW('send_date = ?', $arrDate[$i])->get();
            $invoiceArray = [];
            foreach ($invoices as $invoice) {
                $invoiceArray[] = $invoice->getTotal();
            }

            $incomeAmount = (!empty($dayIncome->amount) ? $dayIncome->amount : 0) + (!empty($invoiceArray) ? array_sum($invoiceArray) : 0);
            $incomeArr[] = str_replace(',', '', number_format($incomeAmount, 2));

            $dayExpense = Payment::selectRaw('sum(amount) amount')->where('created_by', Auth::user()->creatorId())->whereRaw('date = ?', $arrDate[$i])->first();

            $bills = Bill::select('*')->where('created_by', Auth::user()->creatorId())->whereRAW('send_date = ?', $arrDate[$i])->get();
            $billArray = [];
            foreach ($bills as $bill) {
                $billArray[] = $bill->getTotal();
            }
            $expenseAmount = (!empty($dayExpense->amount) ? $dayExpense->amount : 0) + (!empty($billArray) ? array_sum($billArray) : 0);
            $expenseArr[] = str_replace(',', '', number_format($expenseAmount, 2));
        }

        $dataArr['income'] = $incomeArr;
        $dataArr['expense'] = $expenseArr;

        return $dataArr;
    }

    public function totalCompanyUser($id)
    {
        return self::where('created_by', '=', $id)->count();
    }

    public function totalCompanyCustomer($id)
    {
        return Customer::where('created_by', '=', $id)->count();
    }

    public function totalCompanyVender($id)
    {
        return Vender::where('created_by', '=', $id)->count();
    }

    public function planPrice()
    {
        $user = Auth::user();
        if ('super admin' == $user->type) {
            $userId = $user->id;
        } else {
            $userId = $user->created_by;
        }

        return DB::table('settings')->where('created_by', '=', $userId)->get()->pluck('value', 'name');
    }

    public function currentPlan()
    {
        return $this->hasOne('App\Plan', 'id', 'plan');
    }

    public function weeklyInvoice()
    {
        $staticstart = date('Y-m-d', strtotime('last Week'));
        $currentDate = date('Y-m-d');
        $invoices = Invoice::select('*')->where('created_by', Auth::user()->creatorId())->where('issue_date', '>=', $staticstart)->where('issue_date', '<=', $currentDate)->get();
        $invoiceTotal = 0;
        $invoicePaid = 0;
        $invoiceDue = 0;
        foreach ($invoices as $invoice) {
            $invoiceTotal += $invoice->getTotal();
            $invoicePaid += ($invoice->getTotal() - $invoice->getDue());
            $invoiceDue += $invoice->getDue();
        }

        $invoiceDetail['invoiceTotal'] = $invoiceTotal;
        $invoiceDetail['invoicePaid'] = $invoicePaid;
        $invoiceDetail['invoiceDue'] = $invoiceDue;

        return $invoiceDetail;
    }

    public function monthlyInvoice()
    {
        $staticstart = date('Y-m-d', strtotime('last Month'));
        $currentDate = date('Y-m-d');
        $invoices = Invoice::select('*')->where('created_by', Auth::user()->creatorId())->where('issue_date', '>=', $staticstart)->where('issue_date', '<=', $currentDate)->get();
        $invoiceTotal = 0;
        $invoicePaid = 0;
        $invoiceDue = 0;
        foreach ($invoices as $invoice) {
            $invoiceTotal += $invoice->getTotal();
            $invoicePaid += ($invoice->getTotal() - $invoice->getDue());
            $invoiceDue += $invoice->getDue();
        }

        $invoiceDetail['invoiceTotal'] = $invoiceTotal;
        $invoiceDetail['invoicePaid'] = $invoicePaid;
        $invoiceDetail['invoiceDue'] = $invoiceDue;

        return $invoiceDetail;
    }

    public function weeklyBill()
    {
        $staticstart = date('Y-m-d', strtotime('last Week'));
        $currentDate = date('Y-m-d');
        $bills = Bill::select('*')->where('created_by', Auth::user()->creatorId())->where('bill_date', '>=', $staticstart)->where('bill_date', '<=', $currentDate)->get();
        $billTotal = 0;
        $billPaid = 0;
        $billDue = 0;
        foreach ($bills as $bill) {
            $billTotal += $bill->getTotal();
            $billPaid += ($bill->getTotal() - $bill->getDue());
            $billDue += $bill->getDue();
        }

        $billDetail['billTotal'] = $billTotal;
        $billDetail['billPaid'] = $billPaid;
        $billDetail['billDue'] = $billDue;

        return $billDetail;
    }

    public function monthlyBill()
    {
        $staticstart = date('Y-m-d', strtotime('last Month'));
        $currentDate = date('Y-m-d');
        $bills = Bill::select('*')->where('created_by', Auth::user()->creatorId())->where('bill_date', '>=', $staticstart)->where('bill_date', '<=', $currentDate)->get();
        $billTotal = 0;
        $billPaid = 0;
        $billDue = 0;
        foreach ($bills as $bill) {
            $billTotal += $bill->getTotal();
            $billPaid += ($bill->getTotal() - $bill->getDue());
            $billDue += $bill->getDue();
        }

        $billDetail['billTotal'] = $billTotal;
        $billDetail['billPaid'] = $billPaid;
        $billDetail['billDue'] = $billDue;

        return $billDetail;
    }
}
