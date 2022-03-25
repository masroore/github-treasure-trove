<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/register/{lang?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::get('/login/{lang?}', 'Auth\LoginController@showLoginForm')->name('login');

Route::get('/password/resets/{lang?}', 'Auth\LoginController@showLinkRequestForm')->name('change.langPass');

Route::prefix('customer')->as('customer.')->group(
    function () {
        Route::get('login/{lang}', 'Auth\LoginController@showCustomerLoginLang')->name('login.lang')->middleware(['XSS']);
        Route::get('login', 'Auth\LoginController@showCustomerLoginForm')->name('login')->middleware(['XSS']);
        Route::post('login', 'Auth\LoginController@customerLogin')->name('login')->middleware(['XSS']);

        Route::get('/password/resets/{lang?}', 'Auth\LoginController@showCustomerLinkRequestForm')->name('change.langPass');
        Route::post('/password/email', 'Auth\LoginController@postCustomerEmail')->name('password.email');

        Route::get('reset-password/{token}', 'Auth\LoginController@getCustomerPassword')->name('reset.password');
        Route::post('reset-password', 'Auth\LoginController@updateCustomerPassword')->name('password.update');

        Route::get('dashboard', 'CustomerController@dashboard')->name('dashboard')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );

        Route::get('invoice', 'InvoiceController@customerInvoice')->name('invoice')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::get('proposal', 'ProposalController@customerProposal')->name('proposal')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );

        Route::get('proposal/{id}/show', 'ProposalController@customerProposalShow')->name('proposal.show')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );

        Route::get('invoice/{id}/send', 'InvoiceController@customerInvoiceSend')->name('invoice.send')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::post('invoice/{id}/send/mail', 'InvoiceController@customerInvoiceSendMail')->name('invoice.send.mail')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );

        Route::get('invoice/{id}/show', 'InvoiceController@customerInvoiceShow')->name('invoice.show')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );

        Route::post('invoice/{id}/payment', 'StripePaymentController@addpayment')->name('invoice.payment')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::get('payment', 'CustomerController@payment')->name('payment')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::get('transaction', 'CustomerController@transaction')->name('transaction')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::post('logout', 'CustomerController@customerLogout')->name('logout')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::get('profile', 'CustomerController@profile')->name('profile')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );

        Route::post('update-profile', 'CustomerController@editprofile')->name('update.profile')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::post('billing-info', 'CustomerController@editBilling')->name('update.billing.info')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::post('shipping-info', 'CustomerController@editShipping')->name('update.shipping.info')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::post('change.password', 'CustomerController@updatePassword')->name('update.password')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::get('change-language/{lang}', 'CustomerController@changeLanquage')->name('change.language')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );

        Route::post('{id}/pay-with-paypal', 'PaypalController@customerPayWithPaypal')->name('pay.with.paypal')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
        Route::get('{id}/get-payment-status', 'PaypalController@customerGetPaymentStatus')->name('get.payment.status')->middleware(
            [
                'auth:customer',
                'XSS', 'revalidate',
            ]
        );
    }
);

Route::prefix('vender')->as('vender.')->group(
    function () {
        Route::get('login/{lang}', 'Auth\LoginController@showVenderLoginLang')->name('login.lang')->middleware(['XSS']);
        Route::get('login', 'Auth\LoginController@showVenderLoginForm')->name('login')->middleware(['XSS']);
        Route::post('login', 'Auth\LoginController@VenderLogin')->name('login')->middleware(['XSS']);

        Route::get('/password/resets/{lang?}', 'Auth\LoginController@showVendorLinkRequestForm')->name('change.langPass');
        Route::post('/password/email', 'Auth\LoginController@postVendorEmail')->name('password.email');

        Route::get('reset-password/{token}', 'Auth\LoginController@getVendorPassword')->name('reset.password');
        Route::post('reset-password', 'Auth\LoginController@updateVendorPassword')->name('password.update');

        Route::get('dashboard', 'VenderController@dashboard')->name('dashboard')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );
        Route::get('bill', 'BillController@VenderBill')->name('bill')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );
        Route::get('bill/{id}/show', 'BillController@venderBillShow')->name('bill.show')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );

        Route::get('bill/{id}/send', 'BillController@venderBillSend')->name('bill.send')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );
        Route::post('bill/{id}/send/mail', 'BillController@venderBillSendMail')->name('bill.send.mail')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );

        Route::get('payment', 'VenderController@payment')->name('payment')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );
        Route::get('transaction', 'VenderController@transaction')->name('transaction')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );
        Route::post('logout', 'VenderController@venderLogout')->name('logout')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );

        Route::get('profile', 'VenderController@profile')->name('profile')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );

        Route::post('update-profile', 'VenderController@editprofile')->name('update.profile')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );
        Route::post('billing-info', 'VenderController@editBilling')->name('update.billing.info')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );
        Route::post('shipping-info', 'VenderController@editShipping')->name('update.shipping.info')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );
        Route::post('change.password', 'VenderController@updatePassword')->name('update.password')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );
        Route::get('change-language/{lang}', 'VenderController@changeLanquage')->name('change.language')->middleware(
            [
                'auth:vender',
                'XSS', 'revalidate',
            ]
        );
    }
);

Route::get('/', 'DashboardController@index')->name('dashboard')->middleware(['XSS', 'revalidate']);

Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::get('user/{id}/plan', 'UserController@upgradePlan')->name('plan.upgrade')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::get('user/{id}/plan/{pid}', 'UserController@activePlan')->name('plan.active')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::get('profile', 'UserController@profile')->name('profile')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::post('edit-profile', 'UserController@editprofile')->name('update.account')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::resource('users', 'UserController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::post('change-password', 'UserController@updatePassword')->name('update.password');

Route::resource('roles', 'RoleController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::resource('permissions', 'PermissionController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('change-language/{lang}', 'LanguageController@changeLanquage')->name('change.language');
        Route::get('manage-language/{lang}', 'LanguageController@manageLanguage')->name('manage.language');
        Route::post('store-language-data/{lang}', 'LanguageController@storeLanguageData')->name('store.language.data');
        Route::get('create-language', 'LanguageController@createLanguage')->name('create.language');
        Route::post('store-language', 'LanguageController@storeLanguage')->name('store.language');

        Route::delete('/lang/{lang}', 'LanguageController@destroyLang')->name('lang.destroy');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::resource('systems', 'SystemController');
        Route::post('email-settings', 'SystemController@saveEmailSettings')->name('email.settings');
        Route::post('company-settings', 'SystemController@saveCompanySettings')->name('company.settings');
        Route::post('stripe-settings', 'SystemController@savePaymentSettings')->name('payment.settings');
        Route::post('system-settings', 'SystemController@saveSystemSettings')->name('system.settings');
        Route::get('company-setting', 'SystemController@companyIndex')->name('company.setting');
        Route::post('business-setting', 'SystemController@saveBusinessSettings')->name('business.setting');
        Route::post('company-payment-setting', 'SystemController@saveCompanyPaymentSettings')->name('company.payment.settings');
        Route::get('test-mail', 'SystemController@testMail')->name('test.mail');
        Route::post('test-mail', 'SystemController@testSendMail')->name('test.send.mail');
    }
);

Route::get('productservice/index', 'ProductServiceController@index')->name('productservice.index');
Route::resource('productservice', 'ProductServiceController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('customer/{id}/show', 'CustomerController@show')->name('customer.show');
        Route::resource('customer', 'CustomerController');
    }
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('vender/{id}/show', 'VenderController@show')->name('vender.show');
        Route::resource('vender', 'VenderController');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::resource('bank-account', 'BankAccountController');
    }
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('transfer/index', 'TransferController@index')->name('transfer.index');
        Route::resource('transfer', 'TransferController');
    }
);

Route::resource('taxes', 'TaxController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::resource('product-category', 'ProductServiceCategoryController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::resource('product-unit', 'ProductServiceUnitController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::get('invoice/pdf/{id}', 'InvoiceController@invoice')->name('invoice.pdf')->middleware(['XSS', 'revalidate']);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('invoice/{id}/duplicate', 'InvoiceController@duplicate')->name('invoice.duplicate');
        Route::get('invoice/{id}/shipping/print', 'InvoiceController@shippingDisplay')->name('invoice.shipping.print');
        Route::get('invoice/{id}/payment/reminder', 'InvoiceController@paymentReminder')->name('invoice.payment.reminder');
        Route::get('invoice/index', 'InvoiceController@index')->name('invoice.index');
        Route::post('invoice/product/destroy', 'InvoiceController@productDestroy')->name('invoice.product.destroy');
        Route::post('invoice/product', 'InvoiceController@product')->name('invoice.product');
        Route::post('invoice/customer', 'InvoiceController@customer')->name('invoice.customer');
        Route::get('invoice/{id}/sent', 'InvoiceController@sent')->name('invoice.sent');
        Route::get('invoice/{id}/resent', 'InvoiceController@resent')->name('invoice.resent');
        Route::get('invoice/{id}/payment', 'InvoiceController@payment')->name('invoice.payment');
        Route::post('invoice/{id}/payment', 'InvoiceController@createPayment')->name('invoice.payment');
        Route::post('invoice/{id}/payment/{pid}/destroy', 'InvoiceController@paymentDestroy')->name('invoice.payment.destroy');
        Route::get('invoice/items', 'InvoiceController@items')->name('invoice.items');

        Route::resource('invoice', 'InvoiceController');
        Route::get('invoice/create/{cid}', 'InvoiceController@create')->name('invoice.create');
    }
);

Route::get(
    '/invoices/preview/{template}/{color}',
    [
                                              'as' => 'invoice.preview',
                                              'uses' => 'InvoiceController@previewInvoice',
                                          ]
);
Route::post(
    '/invoices/template/setting',
    [
                                    'as' => 'template.setting',
                                    'uses' => 'InvoiceController@saveTemplateSettings',
                                ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('credit-note', 'CreditNoteController@index')->name('credit.note');
        Route::get('custom-credit-note', 'CreditNoteController@customCreate')->name('invoice.custom.credit.note');
        Route::post('custom-credit-note', 'CreditNoteController@customStore')->name('invoice.custom.credit.note');
        Route::get('credit-note/invoice', 'CreditNoteController@getinvoice')->name('invoice.get');
        Route::get('invoice/{id}/credit-note', 'CreditNoteController@create')->name('invoice.credit.note');
        Route::post('invoice/{id}/credit-note', 'CreditNoteController@store')->name('invoice.credit.note');
        Route::get('invoice/{id}/credit-note/edit/{cn_id}', 'CreditNoteController@edit')->name('invoice.edit.credit.note');
        Route::post('invoice/{id}/credit-note/edit/{cn_id}', 'CreditNoteController@update')->name('invoice.edit.credit.note');
        Route::delete('invoice/{id}/credit-note/delete/{cn_id}', 'CreditNoteController@destroy')->name('invoice.delete.credit.note');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('debit-note', 'DebitNoteController@index')->name('debit.note');
        Route::get('custom-debit-note', 'DebitNoteController@customCreate')->name('bill.custom.debit.note');
        Route::post('custom-debit-note', 'DebitNoteController@customStore')->name('bill.custom.debit.note');
        Route::get('debit-note/bill', 'DebitNoteController@getbill')->name('bill.get');
        Route::get('bill/{id}/debit-note', 'DebitNoteController@create')->name('bill.debit.note');
        Route::post('bill/{id}/debit-note', 'DebitNoteController@store')->name('bill.debit.note');
        Route::get('bill/{id}/debit-note/edit/{cn_id}', 'DebitNoteController@edit')->name('bill.edit.debit.note');
        Route::post('bill/{id}/debit-note/edit/{cn_id}', 'DebitNoteController@update')->name('bill.edit.debit.note');
        Route::delete('bill/{id}/debit-note/delete/{cn_id}', 'DebitNoteController@destroy')->name('bill.delete.debit.note');
    }
);

Route::get(
    '/bill/preview/{template}/{color}',
    [
                                          'as' => 'bill.preview',
                                          'uses' => 'BillController@previewBill',
                                      ]
);
Route::post(
    '/bill/template/setting',
    [
                                'as' => 'bill.template.setting',
                                'uses' => 'BillController@saveBillTemplateSettings',
                            ]
);

Route::resource('taxes', 'TaxController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::get('revenue/index', 'RevenueController@index')->name('revenue.index')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::resource('revenue', 'RevenueController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::get('bill/pdf/{id}', 'BillController@bill')->name('bill.pdf')->middleware(['XSS', 'revalidate']);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('bill/{id}/duplicate', 'BillController@duplicate')->name('bill.duplicate');
        Route::get('bill/{id}/shipping/print', 'BillController@shippingDisplay')->name('bill.shipping.print');
        Route::get('bill/index', 'BillController@index')->name('bill.index');
        Route::post('bill/product/destroy', 'BillController@productDestroy')->name('bill.product.destroy');
        Route::post('bill/product', 'BillController@product')->name('bill.product');
        Route::post('bill/vender', 'BillController@vender')->name('bill.vender');
        Route::get('bill/{id}/sent', 'BillController@sent')->name('bill.sent');
        Route::get('bill/{id}/resent', 'BillController@resent')->name('bill.resent');
        Route::get('bill/{id}/payment', 'BillController@payment')->name('bill.payment');
        Route::post('bill/{id}/payment', 'BillController@createPayment')->name('bill.payment');
        Route::post('bill/{id}/payment/{pid}/destroy', 'BillController@paymentDestroy')->name('bill.payment.destroy');
        Route::get('bill/items', 'BillController@items')->name('bill.items');

        Route::resource('bill', 'BillController');
        Route::get('bill/create/{cid}', 'BillController@create')->name('bill.create');
    }
);

Route::get('payment/index', 'PaymentController@index')->name('payment.index')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::resource('payment', 'PaymentController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::resource('plans', 'PlanController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::resource('expenses', 'ExpenseController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('/orders', 'StripePaymentController@index')->name('order.index');
        Route::get('/stripe/{code}', 'StripePaymentController@stripe')->name('stripe');
        Route::post('/stripe', 'StripePaymentController@stripePost')->name('stripe.post');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('report/transaction', 'TransactionController@index')->name('transaction.index');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('report/income-summary', 'ReportController@incomeSummary')->name('report.income.summary');
        Route::get('report/expense-summary', 'ReportController@expenseSummary')->name('report.expense.summary');
        Route::get('report/income-vs-expense-summary', 'ReportController@incomeVsExpenseSummary')->name('report.income.vs.expense.summary');
        Route::get('report/tax-summary', 'ReportController@taxSummary')->name('report.tax.summary');
        Route::get('report/profit-loss-summary', 'ReportController@profitLossSummary')->name('report.profit.loss.summary');

        Route::get('report/invoice-summary', 'ReportController@invoiceSummary')->name('report.invoice.summary');
        Route::get('report/bill-summary', 'ReportController@billSummary')->name('report.bill.summary');

        Route::get('report/invoice-report', 'ReportController@invoiceReport')->name('report.invoice');
        Route::get('report/account-statement-report', 'ReportController@accountStatement')->name('report.account.statement');

        Route::get('report/balance-sheet', 'ReportController@balanceSheet')->name('report.balance.sheet');
        Route::get('report/ledger', 'ReportController@ledgerSummary')->name('report.ledger');
        Route::get('report/file-export', 'ReportController@fileExport')->name('file-export');
        Route::get('report/student-ledger', 'ReportController@studentLedger')->name('student-ledger');
        Route::get('report/trial-balance', 'ReportController@trialBalanceSummary')->name('trial.balance');
    }
);

Route::get(
    '/apply-coupon',
    [
                       'as' => 'apply.coupon',
                       'uses' => 'CouponController@applyCoupon',
                   ]
)->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::resource('coupons', 'CouponController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::get('proposal/pdf/{id}', 'ProposalController@proposal')->name('proposal.pdf')->middleware(['XSS', 'revalidate']);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::get('proposal/{id}/status/change', 'ProposalController@statusChange')->name('proposal.status.change');
        Route::get('proposal/{id}/convert', 'ProposalController@convert')->name('proposal.convert');
        Route::get('proposal/{id}/duplicate', 'ProposalController@duplicate')->name('proposal.duplicate');
        Route::post('proposal/product/destroy', 'ProposalController@productDestroy')->name('proposal.product.destroy');
        Route::post('proposal/customer', 'ProposalController@customer')->name('proposal.customer');
        Route::post('proposal/product', 'ProposalController@product')->name('proposal.product');
        Route::get('proposal/items', 'ProposalController@items')->name('proposal.items');
        Route::get('proposal/{id}/sent', 'ProposalController@sent')->name('proposal.sent');
        Route::get('proposal/{id}/resent', 'ProposalController@resent')->name('proposal.resent');

        Route::resource('proposal', 'ProposalController');
        Route::get('proposal/create/{cid}', 'ProposalController@create')->name('proposal.create');
    }
);

Route::get(
    '/proposal/preview/{template}/{color}',
    [
                                              'as' => 'proposal.preview',
                                              'uses' => 'ProposalController@previewProposal',
                                          ]
);
Route::post(
    '/proposal/template/setting',
    [
                                    'as' => 'proposal.template.setting',
                                    'uses' => 'ProposalController@saveProposalTemplateSettings',
                                ]
);

Route::resource('goal', 'GoalController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::resource('account-assets', 'AssetController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::get('/some/route', function () {
    return 'Hello World';
});
Route::resource('document-entry', 'DocumentsController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);
Route::resource('custom-field', 'CustomFieldController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::post('plan-pay-with-paypal', 'PaypalController@planPayWithPaypal')->name('plan.pay.with.paypal')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::get('{id}/plan-get-payment-status', 'PaypalController@planGetPaymentStatus')->name('plan.get.payment.status')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::post('chart-of-account/subtype', 'ChartOfAccountController@getSubType')->name('charofAccount.subType')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::resource('chart-of-account', 'ChartOfAccountController');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS', 'revalidate',
        ],
    ],
    function () {
        Route::post('journal-entry/account/destroy', 'JournalEntryController@accountDestroy')->name('journal.account.destroy');
        Route::resource('journal-entry', 'JournalEntryController');
    }
);

//================================= Custom Landing Page ====================================//

Route::get('/landingpage', 'LandingPageSectionController@index')->name('custom_landing_page.index')->middleware(['auth', 'XSS']);
Route::get('/LandingPage/show/{id}', 'LandingPageSectionController@show');
Route::post('/LandingPage/setConetent', 'LandingPageSectionController@setConetent')->middleware(['auth', 'XSS']);
Route::get('/get_landing_page_section/{name}', function ($name) {
    $plans = \DB::table('plans')->get();

    return view('custom_landing_page.' . $name, compact('plans'));
});
Route::post('/LandingPage/removeSection/{id}', 'LandingPageSectionController@removeSection')->middleware(['auth', 'XSS']);
Route::post('/LandingPage/setOrder', 'LandingPageSectionController@setOrder')->middleware(['auth', 'XSS']);
Route::post('/LandingPage/copySection', 'LandingPageSectionController@copySection')->middleware(['auth', 'XSS']);
