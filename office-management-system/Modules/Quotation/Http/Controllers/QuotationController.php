<?php

namespace Modules\Quotation\Http\Controllers;

use App\Traits\Notification;
use App\Traits\PdfGenerate;
use App\Traits\QuotationProductSelect;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Mail;
use Modules\Contact\Repositories\ContactRepositoriesInterface;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Repositories\ShowRoomRepositoryInterface;
use Modules\Inventory\Repositories\WareHouseRepositoryInterface;
use Modules\Product\Repositories\ProductRepositoryInterface;
use Modules\Product\Repositories\VariantRepositoryInterface;
use Modules\Quotation\Http\Requests\QuotationRequest;
use Modules\Quotation\Repositories\QuotationRepositoryInterface;
use Modules\Setting\Model\EmailTemplate;
use Modules\Setting\Repositories\GeneralSettingRepositoryInterface;
use Modules\Setup\Repositories\IntroPrefixRepositoryInterface;
use Modules\Setup\Repositories\TaxRepositoryInterface;
use PDF;
use Session;
use stdClass;

class QuotationController extends Controller
{
    use Notification;
    use PdfGenerate;
    use QuotationProductSelect;

    protected $showRoomRepository;

    protected $variationRepository;

    protected $productRepository;

    protected $contactRepositories;

    protected $settingRepository;

    protected $quotationRepository;

    protected $wareHouseRepository;

    protected $taxRepository;

    protected $introPrefixRepository;

    public function __construct(
        QuotationRepositoryInterface $quotationRepository,
        ContactRepositoriesInterface $contactRepositories,
        ShowRoomRepositoryInterface $showRoomRepository,
        ProductRepositoryInterface $productRepository,
        GeneralSettingRepositoryInterface $settingRepository,
        WareHouseRepositoryInterface $wareHouseRepository,
        TaxRepositoryInterface $taxRepository,
        VariantRepositoryInterface $variationRepository,
        IntroPrefixRepositoryInterface $introPrefixRepository
    ) {
        $this->middleware(['auth', 'verified']);
        $this->quotationRepository = $quotationRepository;
        $this->productRepository = $productRepository;
        $this->showRoomRepository = $showRoomRepository;
        $this->contactRepositories = $contactRepositories;
        $this->settingRepository = $settingRepository;
        $this->wareHouseRepository = $wareHouseRepository;
        $this->taxRepository = $taxRepository;
        $this->introPrefixRepository = $introPrefixRepository;
        $this->variationRepository = $variationRepository;
    }

    public function index()
    {
        try {
            $quotations = $this->quotationRepository->all();

            return view('quotation::quotation.index', compact('quotations'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something Went Wrong', 'Error!');

            return back();
        }
    }

    public function create()
    {
        session()->forget('sku');

        try {
            $productList = [];
            $products = $this->productRepository->productForPurchase();
            $combos = $this->productRepository->houseComboProduct(session()->get('showroom_id'), ShowRoom::class);
            $services = $this->productRepository->allService();

            foreach ($products as $key => $product) {
                $item = new stdClass();
                $item->product_name = $product->product_name;
                $item->brand_name = @$product->brand->name;
                $item->model_name = @$product->model->name;
                $item->product_type = $product->product_type;
                $item->image_source = $product->image_source;
                $item->origin = @$product->origin;
                if ($product->product_type == 'Single') {
                    $sku = $product->skus->first();
                    $item->product_id = $sku->id;
                } else {
                    $item->product_id = $product->id;
                }
                $productList[] = $item;
            }
            foreach ($combos as $key => $product) {
                $item = new stdClass();
                $item->product_id = $product->id;
                $item->product_name = $product->name;
                $item->brand_name = null;
                $item->model_name = null;
                $item->origin = null;
                $item->product_type = 'Combo';
                $item->image_source = $product->image_source;
                $productList[] = $item;
            }
            foreach ($services as $key => $product) {
                $item = new stdClass();

                $item->product_id = $product->skus->first()->id;

                $item->product_name = $product->product_name;
                $item->product_type = $product->product_type;
                $item->brand_name = @$product->brand->name;
                $item->model_name = @$product->model->name;
                $item->image_source = $product->image_source;

                $productList[] = $item;
            }
            $data = [
                'allProducts' => $productList,
                'customers' => $this->contactRepositories->witoutWalkInCustomer(),
                'warehouses' => $this->wareHouseRepository->all(),
                'showrooms' => $this->showRoomRepository->all(),
                'taxes' => $this->taxRepository->activeTax(),
                'invoice' => $this->introPrefixRepository->find(4),
            ];

            return view('quotation::quotation.create')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::success('Something Went Wrong', 'Error!');

            return back();
        }
    }

    public function store(QuotationRequest $request)
    {
        DB::beginTransaction();

        try {
            $quotation = $this->quotationRepository->create($request->except('_token'));
            $user_id = null;
            $role_id = null;
            $subject = 'Quotation Create Reminder';
            $class = $quotation;
            $data = "A Quotation, invoice no : {$quotation->invoice_no} Has been Created";
            $url = route('quotation.show', $quotation->id);
            $this->sendNotification($class, null, $subject, null, null, $data, $user_id, $role_id, $url);
            DB::commit();
            LogActivity::successLog('Quotation Added Successfully');
            if ($request->send_mail == 1) {
                $this->send_mail_quotation($quotation->id);
            }
            if ($request->preview_status == 1) {
                Session::put('preview', 1);

                return redirect()->route('quotation.edit', $quotation->id);
            }
            $data = [
                'quotation' => $quotation,
                'setting' => $this->settingRepository->all(),
            ];
            Toastr::success('Quotation Added Successfully', 'success!');

            return view('quotation::quotation.show')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();

            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function show($id)
    {
        try {
            $data = [
                'quotation' => $this->quotationRepository->find($id),
                'setting' => $this->settingRepository->all(),
            ];

            return view('quotation::quotation.show')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::success('Something Went Wrong', 'Error!');

            return back();
        }
    }

    public function edit($id)
    {
        session()->forget('sku');
        $quotation = $this->quotationRepository->find($id);

        try {
            $productList = [];
            $products = $this->productRepository->productForPurchase();
            $combos = $this->productRepository->houseComboProduct(session()->get('showroom_id'), ShowRoom::class);

            foreach ($products as $key => $product) {
                $item = new stdClass();
                $item->product_name = $product->product_name;
                $item->product_type = $product->product_type;
                $item->image_source = $product->image_source;
                $item->brand_name = @$product->brand->name;
                $item->model_name = @$product->model->name;
                $item->origin = @$product->origin;
                if ($product->product_type == 'Single') {
                    $sku = $product->skus->first();
                    $item->product_id = $sku->id;
                } else {
                    $item->product_id = $product->id;
                }
                $productList[] = $item;
            }
            foreach ($combos as $key => $product) {
                $item = new stdClass();
                $item->product_id = $product->id;
                $item->product_name = $product->name;
                $item->brand_name = null;
                $item->model_name = null;
                $item->origin = null;
                $item->product_type = 'Combo';
                $item->image_source = $product->image_source;
                $productList[] = $item;
            }
            $data = [
                'allProducts' => $productList,
                'quotation' => $quotation,
                'customers' => $this->contactRepositories->witoutWalkInCustomer(),
                'products' => $this->productRepository->allStockProduct(),
                'warehouses' => $this->wareHouseRepository->all(),
                'showrooms' => $this->showRoomRepository->all(),
                'taxes' => $this->taxRepository->activeTax(),
                'invoice' => $this->introPrefixRepository->find(4),
            ];

            return view('quotation::quotation.edit')->with($data);
        } catch (Exception $e) {
            Toastr::success('Oops, Something Went Wrong', 'Error!');

            return back();
        }
    }

    public function update(QuotationRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->quotationRepository->update($request->except('_token'), $id);
            DB::commit();
            LogActivity::successLog('Quotation Updated Successfully');
            Toastr::success('Quotation Updated Successfully', 'success!');

            return back();

            return redirect()->route('quotation.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->quotationRepository->delete($id);
            DB::commit();
            LogActivity::successLog('Quotation Deleted Successfully');
            Toastr::success('Quotation Deleted Successfully', 'Success!');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function statusChange($id)
    {
        try {
            $this->quotationRepository->statusChange($id);

            Toastr::success('Quotation Send TO SUpplier', 'Success!');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::success('Operation Failed', 'Error!');

            return back();
        }
    }

    public function convertToSale($id)
    {
        session()->forget('sku');

        $sale = $this->quotationRepository->find($id);

        try {
            if ($sale->quotationable_id != null) {
                $productList = $this->productRepository->productList($sale->quotationable_id, $sale->quotationable_type);
            } else {
                $productList = $this->productRepository->productList(1, 'Modules\Inventory\Entities\ShowRoom');
            }

            $data = [
                'allProducts' => $productList,
                'sale' => $sale,
                'customers' => $this->contactRepositories->customer(),
                'products' => $this->productRepository->allStockProduct(),
                'warehouses' => $this->wareHouseRepository->all(),
                'showrooms' => $this->showRoomRepository->all(),
                'setting' => $this->settingRepository->all(),
                'taxes' => $this->taxRepository->activeTax(),
                'invoice' => $this->introPrefixRepository->find(3),
                'quotation' => $sale,
            ];

            return view('quotation::quotation.clone_to_sale')->with($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function getPdf($id)
    {
        try {
            $order = $this->quotationRepository->find($id);

            return $this->getInvoice('quotation::quotation.pdf', $order);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function print_view($id)
    {
        try {
            $data['data'] = $this->quotationRepository->find($id);

            return view('quotation::quotation.print_view', $data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function send_mail_quotation($id)
    {
        try {
            $data = $this->quotationRepository->find($id);
            if ($data->customer->email != null) {
                $datas['email'] = app('general_setting')->email;
                $datas['title'] = EmailTemplate::where('type', 'quotation_template')->first()->subject;
                $datas['body'] = EmailTemplate::where('type', 'quotation_template')->first()->value;
                $datas['body'] = str_replace('{USER_FIRST_NAME}', $data->customer->name, $datas['body']);
                $datas['body'] = str_replace('{USER_LOGIN_EMAIL}', $data->customer->email, $datas['body']);
                $datas['body'] = str_replace('{EMAIL_SIGNATURE}', app('general_setting')->mail_signature, $datas['body']);
                $datas['body'] = str_replace('{EMAIL_FOOTER}', app('general_setting')->mail_footer, $datas['body']);
                $pdf = PDF::loadView('quotation::quotation.pdf', compact('data'))->setPaper('a4', 'portrait');
                Mail::send('quotation::emails.quote_mail', $datas, function ($message) use ($data, $datas, $pdf): void {
                    $message->to($data->customer->email, $data->customer->email)
                        ->subject($datas['title'])
                        ->attachData($pdf->output(), $data->invoice_no . '.pdf');
                });
                $data->status = 1;
                $data->save();
                Toastr::success('Quotation Send TO ' . $data->customer->email . ' Successfully!');
            } else {
                Toastr::error("Customer email Doesn't exist !");
            }

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function getPreview(Request $request)
    {
        try {
            $order = $this->quotationRepository->find($request->id);

            return view('quotation::quotation.preview_modal', compact('order'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => 'Operation Failed']);
        }
    }

    public function clone_quotation($id)
    {
        session()->forget('sku');
        $quotation = $this->quotationRepository->find($id);

        try {
            if ($quotation->quotationable_id != null) {
                $productList = $this->productRepository->productList($quotation->quotationable_id, $quotation->quotationable_type);
            } else {
                $productList = $this->productRepository->productList(1, 'Modules\Inventory\Entities\ShowRoom');
            }

            $data = [
                'allProducts' => $productList,
                'quotation' => $quotation,
                'customers' => $this->contactRepositories->witoutWalkInCustomer(),
                'products' => $this->productRepository->allStockProduct(),
                'warehouses' => $this->wareHouseRepository->all(),
                'showrooms' => $this->showRoomRepository->all(),
                'taxes' => $this->taxRepository->activeTax(),
                'invoice' => $this->introPrefixRepository->find(4),
            ];

            return view('quotation::quotation.clone_quotation')->with($data);
        } catch (Exception $e) {
            Toastr::success('Oops, Something Went Wrong', 'Error!');

            return back();
        }
    }

    //Ajax Request for Storing Products in Sale,Purchase,Pos
    public function addProduct(Request $request)
    {
        try {
            $tax = 0;
            $productSku = $this->productRepository->findSku($request->id);
            $skus = session()->get('sku');

            $sku[$productSku->sku] = $productSku->sku;

            if (!empty($skus)) {
                if (array_key_exists($productSku->sku, $skus)) {
                    return 1;
                }
                session()->put('sku', $sku + $skus);
            } else {
                session()->put('sku', $sku);
            }

            $sub_total = ($productSku->selling_price);

            $variantName = $this->variationRepository->variantName($productSku);

            $type = $productSku->id . ",'sku'";
            $description = $productSku->product->description;
            $tax_options = '<input type="number" name="product_tax[]"  value="0" onkeyup="addTax(' . $type . ')" class="primary_input_field tax tax_sku' . $productSku->id . '">';
            if (app('general_setting')->origin == 1) {
                $row = '<td class="product_sku' . $productSku->id . '">' . @$productSku->product->origin . '</td>';
            } else {
                $row = null;
            }
            $output = '';
            $output .= '<tr>
                        <td><input type="hidden" name="product_id[]" value="' . $productSku->id . '" class="primary_input_field sku_id' . $productSku->id . '">' . $productSku->product->product_name . '</br>' . $variantName . '</td>
                        <td class="product_sku' . $productSku->id . '">' . $description . '</td>
                        ' . $row . '
                        <td>' . @$productSku->product->model->name . '</td>
                        <td>' . @$productSku->product->brand->name . '</td>
                        <td><input name="product_price[]" min="1" onkeyup="priceCalc(' . $type . ')" class="primary_input_field product_price product_price_sku' . $productSku->id . '" type="number"
                        value="' . $productSku->selling_price . '"></td>

                        <td>
                            <input type="number" name="product_quantity[]" value="1" onkeyup="addQuantity(' . $type . ')" class="primary_input_field quantity quantity_sku' . $productSku->id . '">
                        </td>

                        <td>
                            ' . $tax_options . '
                        </td>

                        <td>
                            <input type="number" name="product_discount[]" value="0" onkeyup="addDiscount(' . $type . ')" class="primary_input_field discount discount_sku' . $productSku->id . '">
                        </td>
                        <td style="text-align:center" class="product_subtotal product_subtotal_sku' . $productSku->id . '">' . $sub_total . '</td>
                        <td><a data-id="' . $productSku->id . '" data-product="' . $productSku->id . '-Normal" class="primary-btn primary-circle fix-gr-bg delete_product new_delete_product" href="javascript:void(0)"><i class="ti-trash"></i></a></td>
                        </tr>

                        ';

            return response()->json($output);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function addComboProduct(Request $request)
    {
        try {
            $tax = 0;
            $productCombo = $this->productRepository->findCombo($request->id);
            $type = $productCombo->id . ",'combo'";
            $skus = session()->get('sku');

            $sku[$type] = $type;

            if (!empty($skus)) {
                if (array_key_exists($type, $skus)) {
                    return 1;
                }
                session()->put('sku', $sku + $skus);
            } else {
                session()->put('sku', $sku);
            }

            $variantName = $this->variationRepository->comboVariant($productCombo);

            $type = $productCombo->id . ",'combo'";
            $taxes = $this->taxRepository->activeTax();
            $tax_options = '<option value="0">No Tax</option>';
            foreach ($taxes as $tax) {
                $tax_options .= '<option value="' . $tax->rate . '">' . $tax->rate . '%</option>';
            }
            $output = '';
            $output .= '<tr>
                        <td><input type="hidden" name="combo_product_id[]" value="' . $productCombo->id . '" class="primary_input_field sku_id' . $productCombo->id . '">' . $productCombo->name . '</br>' . $variantName . '</td>

                        <td class="product_sku">' . $productCombo->description . '</td>
                        <td></td>
                        <td></td>
                        <td><input type="text" name="combo_product_price[]" class="primary_input_field product_price product_price_combo' . $productCombo->id . '" value="' . $productCombo->price . '"></td>

                        <td>
                            <input type="number" data-type="combo" name="combo_product_quantity[]" value="1" onfocusout="addQuantity(' . $type . ')"
                            class="primary_input_field quantity quantity_combo' . $productCombo->id . '">
                        </td>

                        <td>
                        <select name="combo_product_tax[]" class="primary_select mb-15 tax tax_combo' . $productCombo->id . '" onchange="addTax(' . $type . ')">
                            ' . $tax_options . '
                            </select>
                        </td>

                        <td>
                            <input type="number" data-type="combo" name="combo_product_discount[]" value="0" onkeyup="addDiscount(' . $type . ')"
                            class="primary_input_field discount discount_combo' . $productCombo->id . '">
                        </td>
                        <td class="product_subtotal product_subtotal_combo' . $productCombo->id . '">' . $productCombo->price . '</td>
                        <td><a data-id="' . $productCombo->id . '" data-product="' . $productCombo->id . '-Combo" class="delete_product new_delete_product" href="javascript:void(0)"><i class="ti-trash"></i></a></td>
                        </tr>

                        ';

            return response()->json($output);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function product_modal_for_select(Request $request)
    {
        try {
            $type = explode('-', $request->id);
            if ($type[1] == 'Single' || $type[1] == 'Service') {
                $data['product_id'] = $this->storeSkuSale($type[0]);
                $data['product_type'] = $type[1];

                return $data;
            } elseif ($type[1] == 'Combo') {
                $data['product_id'] = $this->storeCombo($type[0]);
                $data['product_type'] = $type[1];
            } else {
                $data['product_id'] = $type[0];
                $data['product_type'] = $type[1];

                $data['html'] = (string) view('sale::sale.product_details', [
                    'product' => $this->productRepository->find($type[0]),
                ]);
            }

            return response()->json($data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['error' => __('common.Something Went Wrong')]);
        }
    }
}
