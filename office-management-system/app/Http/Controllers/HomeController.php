<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Traits\Dashboard;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use LogActivity;
use Modules\Account\Repositories\ChartAccountRepositoryInterface;
use Modules\Account\Repositories\VoucherRepositoryInterface;
use Modules\Attendance\Entities\ToDo;
use Modules\Attendance\Repositories\EventRepositoryInterface;
use Modules\Inventory\Repositories\ShowRoomRepositoryInterface;
use Modules\Inventory\Repositories\StockTransferRepositoryInterface;
use Modules\Leave\Repositories\HolidayRepository;
use Modules\Product\Repositories\ProductRepositoryInterface;
use Modules\Purchase\Repositories\PurchaseOrderRepositoryInterface;
use Modules\RolePermission\Entities\Permission;
use Modules\Sale\Repositories\SaleRepositoryInterface;
use Modules\Setting\Model\BusinessSetting;
use Modules\Setting\Model\EmailTemplate;
use Modules\Setting\Model\GeneralSetting;

class HomeController extends Controller
{
    use Dashboard;

    protected $purchaseOrderRepository;

    protected $saleRepository;

    protected $voucherRepository;

    protected $productRepository;

    protected $stockTransferRepository;

    protected $eventRepository;

    protected $showRoomRepository;

    protected $holidayRepository;

    protected $chartAccountRepository;

    public function __construct(
        PurchaseOrderRepositoryInterface $purchaseOrderRepository,
        SaleRepositoryInterface $saleRepository,
        VoucherRepositoryInterface $voucherRepository,
        ProductRepositoryInterface $productRepository,
        EventRepositoryInterface $eventRepository,
        ShowRoomRepositoryInterface $showRoomRepository,
        HolidayRepository $holidayRepository,
        StockTransferRepositoryInterface $stockTransferRepository,
        ChartAccountRepositoryInterface $chartAccountRepository
    ) {
        $this->middleware(['auth']);
        $this->middleware('prohibited.demo.mode')->only('post_change_password');
        $this->purchaseOrderRepository = $purchaseOrderRepository;
        $this->saleRepository = $saleRepository;
        $this->voucherRepository = $voucherRepository;
        $this->productRepository = $productRepository;
        $this->stockTransferRepository = $stockTransferRepository;
        $this->eventRepository = $eventRepository;
        $this->showRoomRepository = $showRoomRepository;
        $this->holidayRepository = $holidayRepository;
        $this->chartAccountRepository = $chartAccountRepository;
    }

    public function index()
    {
        try {
            if (auth()->user()->role->type == 'normal_user') {
                return redirect()->route('contact.my_details');
            }
            $data = [
                'purchases' => $this->purchaseOrderRepository->approvePurchase(),
                'sales' => $this->saleRepository->approvedSales(),
                'purchase_payments' => $this->purchaseOrderRepository->purchasePayments('all'),
                'sale_payments' => $this->saleRepository->salePayments('all'),
                'salesTotalAmount' => $this->saleRepository->saleTotalPayments('all'),
                'sale_due' => $this->saleRepository->saleDue('all'),
                'purchase_due' => $this->purchaseOrderRepository->purchaseDue('all'),
                'expenses' => $this->voucherRepository->expenses('all'),
                'monthly_sales' => $this->monthlySales(),
                'yearly_sales' => $this->yearlySales(),
                'dues' => $this->saleRepository->dueList('latest'),
                'stock_alerts' => $this->stockTransferRepository->suggestList()->take(10),
                'calendar_events' => $this->calendarEvents(),
                'toDos' => ToDo::all(),
                'daily_profit' => $this->dailyProfit(),
                'weekly_profit' => $this->weeklyProfit(),
                'monthly_profit' => $this->monthlyProfit(),
                'yearly_profit' => $this->yearlyProfit(),
                'product_quantity' => $this->productQuantity(),
                'bank' => $this->totalBank('all'),
                'cash' => $this->totalCash('all'),
                'income' => $this->totalIncome(),
            ];

            return view('home')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function dashboardCards($type)
    {
        $purchase_payments = $this->purchaseOrderRepository->purchasePayments($type);
        $purchase = $purchase_payments->sum('amount') - $purchase_payments->sum('return_amount');
        $sale_payments = $this->saleRepository->salePayments($type);
        $sale = $sale_payments->sum('amount') - $sale_payments->sum('return_amount');
        $expenses = $this->voucherRepository->expenses($type);
        $sale_due = $this->saleRepository->saleDue($type);
        $purchase_due = $this->purchaseOrderRepository->purchaseDue($type);

        return [
            'purchase_amount' => single_price($purchase),
            'sale_amount' => single_price($sale),
            'expense' => single_price($expenses),
            'bank' => single_price($this->totalBank($type)),
            'cash' => single_price($this->totalCash($type)),
            'income' => single_price($this->totalIncome()),
            'purchase_due' => single_price($purchase_due->sum('amount') - $purchase_due->sum('return_amount')),
            'sale_due' => single_price($sale_due->sum('amount') - $sale_due->sum('return_amount')),
        ];
    }

    public function fileDownload($document)
    {
        try {
            $file = explode(',', $document);
            $fileName = implode('/', $file);

            return response()->download(public_path($fileName));
        } catch (Exception $e) {
            Toastr::error("File Couldn't Find", 'Error!');

            return back();
        }
    }

    public function company()
    {
        $data = [
            'company' => 'company',
            'business_settings' => BusinessSetting::all(),
            'setting' => GeneralSetting::first(),
            'email_templates' => EmailTemplate::all(),

        ];

        return view('setting::index')->with($data);
    }

    public function menuSearch(Request $request)
    {
        $permissions = Permission::where(function ($query): void {
            $query->where('route', 'LIKE', '%index%')->orWhere('route', 'LIKE', '%store%')->orWhere('route', 'LIKE', '%create%');
        })->where('name', 'like', '%' . $request->value . '%')->where('status', 1)->get();

        $output = '';
        if (count($permissions) > 0) {
            foreach ($permissions as $permission) {
                $output .= '<a href="' . route($permission->route) . '"> ' . $permission->name . ' </a>';
            }
        } else {
            $no_result = trans('dashboard.No Results Found');
            $output = "<a href='#'>$no_result</a>";
        }

        return $output;
    }

    public function notificationUpdate(Request $request)
    {
        $notification = Notification::find($request->id);
        $notification->read_at = Carbon::now();
        $notification->save();

        return response()->json(['success' => 'success'], 200);
    }

    public function notification_list()
    {
        $notifications = Notification::latest()->get();

        return view('backEnd.notifications.index', compact('notifications'));
    }

    public function notification_read_all()
    {
        Notification::whereNull('read_at')->update(['read_at' => Carbon::now()]);
        if (!request()->ajax()) {
            return back();
        }
    }

    public function change_password()
    {
        return view('backEnd.profiles.password');
    }

    public function post_change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::where(['email' => auth()->user()->email])->first();

        $validator->after(function ($validator) use ($user, $request) {
            if ($user && Hash::check($request->current_password, $user->password)) {
                return true;
            }
            $validator->errors()->add(
                'current_password',
                __('auth.failed')
            );
        });

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user->password = bcrypt($request->password);
        $user->save();
        Toastr::success(__('common.Password change successful'), __('common.success'));

        return redirect()->route('home');
    }

    public function post_notification_read_all(Request $request)
    {
        $notifications = $request->notifications;

        if (!$notifications) {
            return back();
        }

        Notification::whereNull('read_at')->whereIn('id', $notifications)->update(['read_at' => Carbon::now()]);
        Toastr::success(__('common.Selected notification marked as seen'), __('common.success'));

        return back();
    }
}
