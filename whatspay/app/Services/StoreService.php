<?php

namespace App\Services;

use App\Jobs\SendEmail;
use App\Jobs\WhatsAppJob;
use App\Models\Categories;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\Products;
use App\Models\Store;
use App\Models\User;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\EmployeeRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\StoreRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class StoreService
{
    /**
     * @var
     */
    protected $storeRepository;

    protected $employeeRepository;

    protected $userRepository;

    protected $categoryRepository;

    protected $productRepository;

    /**
     * AddressService constructor.
     */
    public function __construct(
        StoreRepositoryInterface $storeRepository,
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository,
        EmployeeRepositoryInterface $employeeRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->storeRepository = $storeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->employeeRepository = $employeeRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Get all stores of a user.
     */
    public function getAll()
    {
        try {
            $stores = Auth::user()->stores;
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $stores;
    }

    public function validateBasic($request, $id)
    {
        $rules = [
            'name' => 'required|string',
            'whatsapp' => 'required|string|unique:stores,whatsapp_num,' . $id,
            'business_url' => 'required|string|unique:stores,business_url,' . $id,
            'industry' => 'required',
            'industry_type' => 'required',
            'description' => 'required|string',
        ];

        // validate request
        return Validator::make($request->input(), $rules);
    }

    public function validateBranch($request)
    {
        $rules = [
            'name' => 'required|string',
            'whatsapp' => 'required|string|unique:stores,whatsapp_num',
            'email' => 'required|email',
            'address' => 'required|string',
            'postal_code' => 'required|string',
            'area' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ];

        // validate request
        return Validator::make($request->input(), $rules);
    }

    /**
     * update basic store info.
     *
     * @param $id
     */
    public function updateBasic(Request $request, $id)
    {
        try {
            $validator = $this->validateBasic($request, $id);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $result = $this->storeRepository->updateByColumn([
                'user_id' => Auth::user()->id,
                'id' => $id,
            ], [
                'store_name' => $request['name'],
                'whatsapp_num' => $request['whatsapp'],
                'business_url' => $request['business_url'],
                'email' => $request['email'],
                'industry_id' => $request['industry'],
                'industry_types' => $request['industry_type'],
                'description' => $request['description'],
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return [];
    }

    public function validateContact($request, $id)
    {
        if (1 == $request['is_online']) {
            $rules = [
                'email' => 'required|email',
                'mobile_number' => 'required|string',
                'address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'country' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
            ];
        } else {
            $rules = [
                'email' => 'required|email',
                'address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'country' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
                'purpose' => 'required|string',
                'is_online' => 'required',
                'area' => 'required',
                'mobile_number' => 'required',
            ];
        }

        // validate request
        return Validator::make($request->input(), $rules);
    }

    /**
     * update store contact info.
     *
     * @param $id
     */
    public function updateContact(Request $request, $id)
    {
        try {

            // validate request
            $validator = $this->validateContact($request, $id);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            // update
            $this->storeRepository->updateByColumn([
                'user_id' => Auth::user()->id,
                'id' => $id,
            ], [
                'email' => $request['email'],
                'website' => $request['website'],
                'street_address' => $request['address'],
                'city' => $request['city'],
                'state' => $request['state'],
                'postal_code' => $request['postal_code'],
                'area' => $request['area'],
                'is_online' => $request['is_online'],
                'phone_number' => $request['phone_number'],
                'mobile_number' => $request['mobile_number'],
                'ntn_num' => $request['ntn_num'],
                'acc_number' => $request['acc_number'],
                'iban_number' => $request['iban_number'],
                'country' => $request['country'],
                'latitude' => $request['latitude'],
                'longitude' => $request['longitude'],
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return [];
    }

    /**
     * update store bank info.
     *
     * @param $id
     */
    public function updateBank(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->input(), [
                'payment_method' => 'required|string|in:paypal,bank',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            if ('paypal' == $request['payment_method']) {
                $validator = Validator::make($request->input(), [
                    'paypal_email' => 'required|string',
                ]);
            } else {
                $validator = Validator::make($request->input(), [
                    'iban_number' => 'required',
                    'acc_holder_name' => 'required',
                    'bank_name' => 'required',
                    'acc_holder_mobile_number' => 'required',
                ]);
            }

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            // update
            $this->storeRepository->updateByColumn([
                'user_id' => Auth::user()->id,
                'id' => $id,
            ], $request->except(['purpose', 'store_id']));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return [];
    }

    public function validateSettings($request)
    {
        $rules = [
            'cash_on_delivery' => 'in:enable,disable',
            'currency' => 'in:PKR,USD,AED',
            'shipping_percentage_type' => 'in:flat,percentage',
            'shipping_percentage' => 'integer',
            'applicable_range' => 'integer',
            // 'delivery_days' => 'required',
            'delivery_hours' => 'integer',
            'delivery_minutes' => 'integer',
            //            'delivery_range' => 'required',
            'delivery_radius' => 'in:0,1',
            'disount_type' => 'in:flat,percentage',
            'discount_amount' => 'integer',
            //            'service_options' => 'required',
            'orders_accept_status' => 'in:yes,no',
            'is_tax_enable' => 'in:0,1',
            'tax_rate' => 'integer',
            'is_tax_included' => 'in:0,1',
            'custom_tax_config' => 'in:0,1',
            'allow_checkout_when_out_of_stock' => 'in:0,1',
            'min_order_price' => 'integer',
            'max_order_price' => 'integer',
            'min_order_qty' => 'integer',
            'max_order_qty' => 'integer',
        ];

        // validate request
        return Validator::make($request->json()->all(), $rules);
//        return Validator::make($request->input(), $rules);
    }

    /**
     * update store contact info.
     *
     * @param $id
     */
    public function updateSettings(Request $request, $id)
    {
        try {
            // validate request
            $validator = $this->validateSettings($request);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            // update
            $this->storeRepository->updateByColumn([
                'user_id' => Auth::user()->id,
                'id' => $id,
            ], $request->except(['store_id']));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return [];
    }

    /**
     * Update Profile Image.
     *
     * @param $request
     *
     * @return $message
     */
    public function imageUpdate(Request $request)
    {
        try {
            $store_id = request()->user()->currentAccessToken()->store_id;
            // $store_id = 1;
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $store = $this->storeRepository->findById($store_id, [
                'store_name',
            ]);

            $name = slugify($store->store_name);

            $without_ext = strtolower($name . '-' . time() . '-whatspays');
            $ext = $request->image->extension();
            $file_name = $without_ext . '.' . $ext;
            // $imageName = time().'.'.$request->image->extension();
            // $request->image->move(public_path('images'), $imageName);
            $request->image->storeAs('uploads/store/media', $file_name);

            return $this->storeRepository->updateByColumn([
                'id' => $store_id,
            ], [
                'store_logo' => $file_name,
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update Store Timings.
     *
     * @param $request
     *
     * @return $message
     */
    public function storeTimings(Request $request)
    {
        try {
//            dd($request->except(['store_id']));
//            $validator = Validator::make($request->json()->all(), [
//                'Sunday' => 'required',
//                'Monday' => 'required',
//                'Tuesday' => 'required',
//                'Wednesday' => 'required',
//                'Thursday' => 'required',
//                'Friday' => 'required',
//                'Saturday' => 'required'
//            ]);
//
//            if ($validator->fails()) {
//                throw new InvalidArgumentException($validator->errors()->first());
//            }

            $result = $this->storeRepository->updateByColumn([
                'id' => $request['store_id'],
            ], [
                'store_timings' => json_encode($request->except(['store_id'])),
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Get Store Data.
     *
     * @param $request
     *
     * @return $message
     */
    public function getStore(Request $request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'business_url' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
//            dd($request['business_url']);
            $store = $this->storeRepository->findByColumn(['business_url' => $request['business_url']], [
                'id',
                'user_id',
                'parent_branch_id',
                'store_logo',
                'store_name',
                'whatsapp_num',
                'whatsapp_username',
                'whatsapp_password',
                'business_url',
                'description',
                'images',
                'email',
                'website',
                'ntn_num',
                'street_address',
                'latitude',
                'longitude',
                'country',
                'is_online',
                'postal_code',
                'area',
                'bank_phone',
                'payment_method',
                'service_options',
                'delivery_hours',
                'delivery_minutes',
                'store_timings',
            ]);
            $delivery_time = getStoreDeliveryTime($store);
            $store_id = $store->id;
            if ('enable' == $store->cash_on_delivery) {
                $store['payment_type'] = 'Accept Cash & Online Payment';
            } else {
                $store['payment_type'] = 'Accept Online Payment';
            }
            $store_min_max = Products::selectRaw('MIN(price) AS min_price, MAX(price) AS max_price')->where([['price', '>', 0], ['store_id', '=', $store_id]])->first();
            $store['store_min_max'] = $store_min_max;
            $shipping = 'Free Delivery';
            if ($store->shipping_percentage > 0) {
                switch ($store->shipping_percentage_type) {
                    case 'flat':
                        $shipping = $store->shipping_percentage . ' Delivery fee';

                        break;

                    case 'percentage':
                        $shipping = $store->shipping_percentage . ' %Delivery fee';

                        break;
                }
            }
            $store['delivery_fee'] = $shipping;
            $store['delivery_time'] = $delivery_time;
//            $store_min_max->min_price;
//            echo $max_price = Products::max('price');
//            echo '<br>';
//            echo $min_price = Products::min('price');
//            var_dump($store_min_max);
//            exit();
//            $stores = Store::where('business_url', $request['business_url'])->first();

//            $categories = $stores->categories()->paginate(2);

//            $stores['categories'] = $categories;
//                var_dump($stores->user_id);
//                exit();
//            dd($stores);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $store;
    }

    /**
     * Get Branch Data.
     *
     * @param $request
     *
     * @return $message
     */
    public function getBranch(Request $request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'business_url' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Get Store Categories.
     *
     * @param $request
     *
     * @return $message
     */
    public function getStoreCategory(Request $request, $id)
    {
        try {
            $stores = $this->categoryRepository->findAllByPagination(['store_id' => $id], [
                'id',
                'parent_id',
                'name',
                'icon',
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $stores;
    }

    /**
     * Get Store Products against Category.
     *
     * @param $request
     *
     * @return $message
     */
    public function getStoreProducts(Request $request, $store_id, $category_id)
    {
        try {
            $products = $this->productRepository->findAllByColumn(['store_id' => $store_id], [
                'id',
                'store_id',
                'name',
                'description',
                'status',
                'images',
                'sku',
                'price',
                'with_storehouse_management',
                'quantity',
                'category_id',
                'brand_id',
                'is_variation',
                'sale_price',
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $products;
    }

    public function homeListing()
    {
        try {
            $stores = Store::paginate(5);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $stores;
    }

    public function viewStore($slug)
    {
        try {
            $id = getIdBySlug($slug, 'App\Models\Store');
            $store = $this->storeRepository->findById($id);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $store;
    }

    public function storesByIndustry($slug)
    {
        try {
            $id = getIdBySlug($slug, 'App\Models\Industries');
            $store = $this->storeRepository->findAllByColumn(['industry_id' => $id]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $store;
    }

    /**
     * Update Store Timings.
     *
     * @param $request
     *
     * @return $message
     */
    public function changeStatus(Request $request, $id)
    {
        $validator = Validator::make($request->input(), [
            'store_id' => 'required|integer',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data = ['status' => $request['status']];

        return $this->storeRepository->update(
            $id,
            $data
        );
    }

    /**
     * Create Store.
     *
     * @param $request
     *
     * @return $message
     */
    public function createStore(Request $request)
    {
        DB::beginTransaction();

        try {
            $result = extract_number_and_cc($request);
            $whatsapp = $result['with_cc'];
            $request['whatsapp_num'] = (int) $whatsapp;

            $validator = Validator::make($request->input(), [
                'store_name' => 'required|unique:stores,store_name',
                'business_url' => ['required',
                    function ($attribute, $value, $fail): void {
                        if (
                            preg_match('/^[0-9]+$/', $value) ||
                            !preg_match('/^[a-zA-Z0-9-]*$/', $value) ||
                            'www' == $value ||
                            'whatspays' == $value
                        ) {
                            $fail('This business url is not allowed.');
                        }
                    }, 'unique:stores,business_url',
                ],
                'whatsapp_num' => 'required|integer|unique:stores,whatsapp_num',
                'industry_id' => 'required|integer',
                'industry_types' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $auth_user = Auth::user();
            $user_id = $auth_user->id;
            $user_name = $auth_user->name;
            $user_email = $auth_user->email;

            // create a store for company user
            $create_store = $this->storeRepository->create([
                'user_id' => $user_id,
                'store_name' => $request['store_name'],
                'business_url' => $request['business_url'],
                'whatsapp_num' => $request['whatsapp_num'],
                'industry_id' => $request['industry_id'],
                'industry_types' => $request['industry_types'],
                'description' => $request['description'],
            ]);
            $this->employeeRepository->create([
                'user_id' => $user_id,
                'store_id' => $create_store->id,
                'is_admin' => 1,
            ]);

            $email_subject = get_email_subject('create-store', $user_name);
            $whatsapp_msg = get_whatsapp_message('create-store', [
                'name' => $user_name,
            ]);

            // send email in queue
            $email_job = new SendEmail([
                'view' => 'email.create_store',
                'email' => $user_email,
                'subject' => $email_subject,
                'name' => $user_name,
                'whatsapp_link' => $whatsapp_msg,
            ]);
            // dispatch job
            dispatch($email_job);

            $otp = generate_random_string();
            $hash = Hash::make(time() . $request['whatsapp_num'] . 'whatspays');
            // send whatsapp in queue
            $whatsapp_job = new WhatsAppJob([
                'to' => $whatsapp,
                'data' => [
                    'template_name' => 'register_final',
                    'to' => (int) $whatsapp,
                    'name' => $user_name,
                    'code' => $otp,
                    'hash' => $hash,
                ],
            ]);
            dispatch($whatsapp_job);

            $request->user()->currentAccessToken()->update(['store_id' => $create_store->id]);
            DB::commit();

            return $create_store;
        } catch (Exception $e) {
            DB::rollback();

            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function delete($ids, $user_id)
    {
        DB::beginTransaction();

        try {

            //branches
            $child_record = $this->storeRepository->findByMultipleColumns('parent_branch_id', $ids, ['user_id' => $user_id], ['id']);

            $branches = [];
            if ($child_record) {
                foreach ($child_record as $val) {
                    $branches[] = $val['id'];
                }
            }

            $user_ids = [];
            if (!empty($branches)) {
                //Delete Employees of branches
                $store_users = (new Employee())->whereIn('store_id', $branches)->orWhereIn('store_id', $ids)->get('user_id');
                if ($store_users) {
                    foreach ($store_users as $val) {
                        $user_ids[] = $val['user_id'];
                    }
                }
            }
            $user_ids = array_unique($user_ids);
            //Delete Employees
            (new Employee())->whereIn('user_id', $user_ids)->delete();
            //Delete Users
            (new User())->whereIn('id', $user_ids)->delete();

            //Delete Branches
            $this->storeRepository->deleteMultipleByColumn('parent_branch_id', $ids);
            //Select main store users
            $this->storeRepository->deleteMultipleByColumn('user_id', $ids);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw new InvalidArgumentException($e->getMessage());
        }

        return true;
    }

    public function notificationview(Request $request)
    {
        try {
            $data = Notification::where('notifiable_id', $request->store_id)
                ->where('notifiable_type', 'App\Models\Store')
                ->get();
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $data;
    }

    public function deletenoti($id)
    {
        try {
            $data = Notification::where('id', $id)->delete();
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $data;
    }

    public function statuChange(Request $request, $id)
    {
        try {
            $data = Notification::where('id', $id)->update([
                'status' => $request->status,
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $data;
    }
}
