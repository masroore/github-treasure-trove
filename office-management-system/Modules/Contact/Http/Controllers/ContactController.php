<?php

namespace Modules\Contact\Http\Controllers;

use App\Traits\Notification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Account\Repositories\JournalRepositoryInterface;
use Modules\Account\Repositories\VoucherRepository;
use Modules\Contact\Http\Requests\ContactFormRequest;
use Modules\Contact\Http\Requests\ContactProfileFormRequest;
use Modules\Contact\Repositories\ContactRepositoriesInterface;
use Modules\Sale\Repositories\SaleRepositoryInterface;
use Modules\Setting\Model\GeneralSetting;

class ContactController extends Controller
{
    use Notification;

    protected $contactRepository;

    protected $voucherRepository;

    protected $journalRepository;

    public function __construct(ContactRepositoriesInterface $contactRepository, VoucherRepository $voucherRepository, JournalRepositoryInterface $journalRepository)
    {
        $this->middleware(['auth']);
        $this->contactRepository = $contactRepository;
        $this->voucherRepository = $voucherRepository;
        $this->journalRepository = $journalRepository;
    }

    public function index()
    {
        return view('contact::contact.add_contact');
    }

    public function supplier(Request $request)
    {
        try {
            $search_keyword = null;
            if ($request->input('search_keyword') != null) {
                $search_keyword = $request->input('search_keyword');
                $suppliers = $this->contactRepository->serachBasedSupplier($search_keyword);
            } else {
                $suppliers = $this->contactRepository->supplier();
            }

            return view('contact::contact.supplier', [
                'suppliers' => $suppliers,
                'search_keyword' => $search_keyword,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function customer(Request $request)
    {
        try {
            $search_keyword = null;
            if ($request->input('search_keyword') != null) {
                $search_keyword = $request->input('search_keyword');
                $customers = $this->contactRepository->serachBasedCustomer($search_keyword);
            } else {
                $customers = $this->contactRepository->customer();
            }

            return view('contact::contact.customer', [
                'customers' => $customers,
                'search_keyword' => $search_keyword,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function create()
    {
        return view('contact::create');
    }

    public function store(ContactFormRequest $request)
    {
        DB::beginTransaction();

        try {
            $contact = $this->contactRepository->create($request->except('_token'));

            $created_by = Auth::user()->name;
            $company = app('general_setting')->company_name;
            $content = 'You Have Been added as  ' . $contact->contact_type . ' by ' . $created_by . ' for ' . $company . ' ';
            $number = $contact->mobile;
            $message = 'Congrats ! You Have Been added as  ' . $contact->contact_type . ' by ' . $created_by . ' for ' . $company . ' ';
            $this->sendNotification($contact, $contact->email, $contact->contact_type . 'Added', $content, $number, $message, $contact->contact_type);

            DB::commit();

            LogActivity::successLog('Contact Added Successfully');
            Toastr::success(__('contact.Contact Added Successfully'));

            return back();
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());

            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function show($id)
    {
        try {
            $account_categories = $this->voucherRepository->category();
            $accounts = $this->journalRepository->transactionalAccounts();
            $supplier = $this->contactRepository->find($id);

            return view('contact::contact.supplier_view', [
                'supplier' => $supplier,
                'account_categories' => $account_categories,
                'accounts' => $accounts,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function customer_details($id)
    {
        try {
            $recieve_from_accounts = $this->voucherRepository->recieveCategoryAccounts();
            $recieve_by_accounts = $this->voucherRepository->get_recieveByAccount_account();
            $accounts = $this->journalRepository->expenseAccounts();
            $customer = $this->contactRepository->find($id);

            return view('contact::contact.customer_view', [
                'customer' => $customer,
                'recieve_from_accounts' => $recieve_from_accounts,
                'recieve_by_accounts' => $recieve_by_accounts,
                'accounts' => $accounts,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function edit($id)
    {
        try {
            $contact = $this->contactRepository->find($id);

            return view('contact::contact.edit_contact', [
                'contact' => $contact,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function update(ContactFormRequest $request, $id)
    {
        try {
            $contact = $this->contactRepository->update($request->except('_token'), $id);

            $created_by = Auth::user()->name;
            $company = app('general_setting')->company_name;
            $content = 'Your info has Been updated as  ' . $contact->contact_type . ' by ' . $created_by . ' for ' . $company . ' ';
            $number = $contact->mobile;
            $message = 'Your info Have Been updated as  ' . $contact->contact_type . ' by ' . $created_by . ' for ' . $company . ' ';
            $this->sendNotification($contact, $contact->email, $contact->contact_type . 'Added', $content, $number, $message);

            LogActivity::successLog('Contact Updated Successfully');
            Toastr::success(__('contact.Contact Updated Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $this->contactRepository->delete($id);
            LogActivity::successLog('Contact Deleted Successfully');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function statusChange(Request $request)
    {
        try {
            $this->contactRepository->statusChange($request->except('_token'));
            Toastr::success(__('contact.Status has been changed Successfully'));

            return 1;
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return 0;
        }
    }

    public function customerSaleProductList($id)
    {
        $saleHistory = $this->contactRepository->customerSaleHistory($id);

        return view('contact::contact.customer_product_list', compact('saleHistory'));
    }

    public function supplierPurchaseProductList($id)
    {
        $purchaseHistory = $this->contactRepository->supplierPurchaseHistory($id);

        return view('contact::contact.supplier_product_list', compact('purchaseHistory'));
    }

    public function addBalanceCustomer(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'voucher_type' => 'required',
            'narration' => 'nullable',
            'cheque_no' => 'nullable',
            'cheque_date' => 'nullable',
            'bank_name' => 'nullable',
            'bank_branch' => 'nullable',
            'debit_account_id' => 'required',
            'debit_account_amount.*' => 'required',
            'debit_account_narration' => 'nullable',

        ]);
        DB::beginTransaction();

        try {
            $debit_account_amount = 0;
            foreach ($request->debit_account_amount as $key => $amount) {
                $debit_account_amount += $amount;
            }
            $this->voucherRepository->create([
                'voucher_type' => $request->voucher_type == 1 ? 'CV' : 'BV',
                'amount' => $debit_account_amount,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'payment_type' => 'voucher_recieve',
                'credit_account_id' => $request->credit_account_id,
                'credit_account_amount' => $debit_account_amount,
                'credit_account_narration' => $request->debit_account_narration[0],
                'debit_account_id' => $request->debit_account_id,
                'debit_account_amount' => $request->debit_account_amount,
                'debit_account_narration' => $request->debit_account_narration,

                'narration' => $request->debit_account_narration[0],
                'cheque_no' => $request->cheque_no,
                'cheque_date' => Carbon::parse($request->cheque_date)->format('Y-m-d'),
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
                'invoice_id' => ($request->invoice_id) ? $request->invoice_id : null,
                'is_approve' => (app('business_settings')->where('type', 'add_balance_voucher_approval')->first()->status == 1) ? 1 : 0,
            ]);
            DB::commit();
            LogActivity::successLog('Balance has been added Successfully !!!.');
            Toastr::success(__('Balance has been added Successfully !!!'));

            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Voucher Recieve creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function minusBalance(Request $request)
    {
        DB::beginTransaction();

        try {
            $this->journalRepository->create([
                'voucher_type' => 'JV',
                'amount' => $request->sub_amount[0],
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'account_type' => $request->account_type,
                'payment_type' => 'journal_voucher',
                'account_id' => $request->account_id,
                'main_amount' => $request->sub_amount[0],
                'narration' => $request->narration,

                'sub_account_id' => $request->sub_account_id,
                'sub_amount' => $request->sub_amount,
                'sub_narration' => $request->narration,
                'is_approve' => (app('business_settings')->where('type', 'substraction_balance_voucher_approval')->first()->status == 1) ? 1 : 0,
            ]);
            DB::commit();
            LogActivity::successLog('Journal has been Added.');
            Toastr::success(__('account.Journal has been added Successfully'));

            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Journal creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function addBalanceSupplier(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'voucher_type' => 'required',
            'narration' => 'nullable',
            'cheque_no' => 'nullable',
            'cheque_date' => 'nullable',
            'bank_name' => 'nullable',
            'bank_branch' => 'nullable',
            'debit_account_id' => 'required',
            'debit_account_amount.*' => 'required',
            'debit_account_narration' => 'nullable',

        ]);
        DB::beginTransaction();

        try {
            $debit_account_amount = 0;
            foreach ($request->debit_account_amount as $key => $amount) {
                $debit_account_amount += $amount;
            }
            $this->voucherRepository->create([
                'voucher_type' => $request->voucher_type == 1 ? 'CV' : 'BV',
                'amount' => $debit_account_amount,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'payment_type' => 'voucher_payment',
                'credit_account_id' => $request->credit_account_id,
                'credit_account_amount' => $debit_account_amount,
                'credit_account_narration' => $request->debit_account_narration[0],
                'debit_account_id' => $request->debit_account_id,
                'debit_account_amount' => $request->debit_account_amount,
                'debit_account_narration' => $request->debit_account_narration,

                'narration' => $request->narration,
                'cheque_no' => $request->cheque_no,
                'cheque_date' => Carbon::parse($request->cheque_date)->format('Y-m-d'),
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
                'invoice_id' => ($request->invoice_id) ? $request->invoice_id : null,
                'is_approve' => (app('business_settings')->where('type', 'add_balance_voucher_approval')->first()->status == 1) ? 1 : 0,
            ]);
            DB::commit();
            LogActivity::successLog('Balance has been added Successfully !!!.');
            Toastr::success(__('Balance has been added Successfully !!!'));

            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();

            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Voucher Recieve creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function settings()
    {
        return view('contact::contact.settings');
    }

    public function post_settings(Request $request)
    {
        try {
            $contact_login = $request->contact_login ? 1 : 0;

            $settings = GeneralSetting::find(1);
            $settings->contact_login = $contact_login;
            $settings->save();
            LogActivity::successLog('Contact Settings updated Successfully !!!.');
            Toastr::success(__('Contact Settings updated Successfully !!!.'));

            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();

            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Contact Settings update');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function my_details()
    {
        $id = auth()->user()->contact_id;
        $contact = $this->contactRepository->find($id);

        if ($contact->contact_type == 'Customer') {
            try {
                $recieve_from_accounts = $this->voucherRepository->recieveCategoryAccounts();
                $recieve_by_accounts = $this->voucherRepository->get_recieveByAccount_account();
                $accounts = $this->journalRepository->expenseAccounts();
                $customer = $this->contactRepository->find($id);

                return view('contact::contact.my_details.customer', [
                    'customer' => $customer,
                    'recieve_from_accounts' => $recieve_from_accounts,
                    'recieve_by_accounts' => $recieve_by_accounts,
                    'accounts' => $accounts,
                ]);
            } catch (Exception $e) {
                LogActivity::errorLog($e->getMessage());
                Toastr::error('Operation failed');

                return back();
            }
        } else {
            try {
                $account_categories = $this->voucherRepository->category();
                $accounts = $this->journalRepository->transactionalAccounts();
                $supplier = $this->contactRepository->find($id);

                return view('contact::contact.my_details.supplier', [
                    'supplier' => $supplier,
                    'account_categories' => $account_categories,
                    'accounts' => $accounts,
                ]);
            } catch (Exception $e) {
                LogActivity::errorLog($e->getMessage());
                Toastr::error('Operation failed');

                return back();
            }
        }
    }

    public function my_products()
    {
        $id = auth()->user()->contact_id;
        $contact = $this->contactRepository->find($id);
        if ($contact->contact_type == 'Customer') {
            $saleHistory = $this->contactRepository->customerSaleHistory($id);

            return view('contact::contact.my_details.customer_product', compact('saleHistory'));
        }
        $purchaseHistory = $this->contactRepository->supplierPurchaseHistory($id);

        return view('contact::contact.supplier_product_list', compact('purchaseHistory'));
    }

    public function my_payment(SaleRepositoryInterface $saleRepo, $id)
    {
        try {
            $sale = $saleRepo->find($id);

            $data = [
                'sale' => $sale,
            ];

            return view('contact::contact.my_details.sale_payment')->with($data);
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function post_my_payment(SaleRepositoryInterface $saleRepo, $id)
    {
        try {
            $sale = $saleRepo->find($id);
            $data = [
                'sale' => $sale,
            ];

            return view('contact::contact.my_details.sale_payment')->with($data);
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function invoice()
    {
        $id = auth()->user()->contact_id;
        $contact = $this->contactRepository->find($id);
        if ($contact->contact_type == 'Customer') {
            try {
                $customer = $this->contactRepository->find($id);

                return view('contact::contact.my_details.customer_invoice', [
                    'customer' => $customer,
                ]);
            } catch (Exception $e) {
                LogActivity::errorLog($e->getMessage());
                Toastr::error('Operation failed');

                return back();
            }
        } else {
            try {
                $supplier = $this->contactRepository->find($id);

                return view('contact::contact.my_details.supplier_invoice', [
                    'supplier' => $supplier,
                ]);
            } catch (Exception $e) {
                LogActivity::errorLog($e->getMessage());
                Toastr::error('Operation failed');

                return back();
            }
        }
    }

    public function return()
    {
        $id = auth()->user()->contact_id;
        $contact = $this->contactRepository->find($id);
        if ($contact->contact_type == 'Customer') {
            try {
                $customer = $this->contactRepository->find($id);

                return view('contact::contact.my_details.customer_return', [
                    'customer' => $customer,
                ]);
            } catch (Exception $e) {
                LogActivity::errorLog($e->getMessage());
                Toastr::error('Operation failed');

                return back();
            }
        } else {
            try {
                $supplier = $this->contactRepository->find($id);

                return view('contact::contact.my_details.supplier_return', [
                    'supplier' => $supplier,
                ]);
            } catch (Exception $e) {
                LogActivity::errorLog($e->getMessage());
                Toastr::error('Operation failed');

                return back();
            }
        }
    }

    public function transaction()
    {
        $id = auth()->user()->contact_id;
        $contact = $this->contactRepository->find($id);
        if ($contact->contact_type == 'Customer') {
            try {
                $customer = $this->contactRepository->find($id);

                return view('contact::contact.my_details.customer_transaction', [
                    'customer' => $customer,
                ]);
            } catch (Exception $e) {
                LogActivity::errorLog($e->getMessage());
                Toastr::error('Operation failed');

                return back();
            }
        } else {
            try {
                $supplier = $this->contactRepository->find($id);

                return view('contact::contact.my_details.supplier_transaction', [
                    'supplier' => $supplier,
                ]);
            } catch (Exception $e) {
                LogActivity::errorLog($e->getMessage());
                Toastr::error('Operation failed');

                return back();
            }
        }
    }

    public function print_transaction_customer($id)
    {
        try {
            $user = $this->contactRepository->find($id);

            return view('contact::contact.print_view', [
                'user' => $user,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function profile()
    {
        $user = $this->contactRepository->find(auth()->id());

        return view('contact::contact.my_details.profile', compact('user'));
    }

    public function post_profile(ContactProfileFormRequest $request)
    {
        try {
            $contact = $this->contactRepository->updateProfile($request->except('_token'), auth()->user()->contact_id);

            LogActivity::successLog('Contact profile Updated Successfully');
            Toastr::success(__('contact.Contact Updated Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function contact_csv_upload()
    {
        return view('contact::upload_via_csv.create');
    }

    public function contact_csv_upload_store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048',
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();

        try {
            $this->contactRepository->csv_contact_upload($request->except('_token'));
            DB::commit();
            Toastr::success('Successfully Uploaded !!!');

            return back();
        } catch (Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 23000) {
                Toastr::error('Duplicate entry is exist in your file !!!');
            } else {
                Toastr::error('Something went wrong. Upload again !!!');
            }

            return back();
        }
    }
}
