<?php

namespace App\Services;

use App\Repositories\Eloquent\ShippingRuleRepository;
use App\Repositories\ShippingRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ShippingService
{
    /**
     * @var
     */
    protected $shippingRepository;

    /**
     * @var
     */
    protected $shippingRuleRepository;

    /**
     * AddressService constructor.
     */
    public function __construct(
        ShippingRepositoryInterface $shippingRepository,
        ShippingRuleRepository $shippingRuleRepository
    ) {
        $this->shippingRepository = $shippingRepository;
        $this->shippingRuleRepository = $shippingRuleRepository;
    }

    /**
     * Get all addresses of a user.
     */
    public function getAll(Request $request)
    {
        try {
            $addresses = $this->shippingRepository->findAllByColumn([
                'store_id' => $request['store_id'],
            ], [
                'id',
                'title',
                'country',
            ], ['config' => function ($query) {
                $query->select('shipping_id', 'id', 'min', 'max', 'charges');
            }, 'cities' => function ($query) {
                $query->select('id', 'parent_id', 'city', 'radius');
            }]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $addresses;
    }

    public function store(Request $request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'rules.*.country' => 'required|string',
                'rules.*.config.*.min' => 'required',
            ], [
                'rules.*.country.required' => 'The country field is required',
                'rules.*.country.string' => 'The country field must be a string',

            ]);

            // if validation fails throw exception
            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            foreach ($request->input('rules') as $key => $rules) {
                // create shipping
                $shipping = $this->shippingRepository->create([
                    'country' => $rules['country'],
                    'status' => $rules['status'],
                    'store_id' => $request['store_id'],
                ]);

                if ($shipping) {
                    // save country shipping rules
                    foreach ($rules['config'] as $config) {
                        $this->shippingRuleRepository->create([
                            'shipping_id' => $shipping->id,
                            'min' => $config['min'], // minimum order amount
                            'max' => $config['max'], // maximum order amount
                            'charges' => $config['charges'],
                        ]);
                    }

                    // save cities shipping
                    foreach ($rules['cities'] as $city) {
                        $child_shipping = $this->shippingRepository->create([
                            'store_id' => $request['store_id'],
                            'parent_id' => $shipping->id,
                            'country' => $rules['country'],
                            'city' => $city['city'],
                            'status' => $city['status'],
                        ]);

                        if ($child_shipping) {
                            // save cities shipping rules
                            foreach ($city['config'] as $city_config) {
//                                dd($city_config);
                                $this->shippingRuleRepository->create([
                                    'shipping_id' => $child_shipping->id,
                                    'min' => $city_config['min'], // minimum order amount
                                    'max' => $city_config['max'], // maximum order amount
                                    'charges' => $city_config['charges'],
                                ]);
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $shipping->fresh(['config' => function ($query) {
            $query->select('shipping_id', 'id', 'min', 'max', 'charges');
        }, 'cities' => function ($query) {
            $query->select('parent_id', 'id', 'city', 'radius', 'latitude', 'longitude', 'status');
        }])->only(['id', 'title', 'country', 'status', 'config', 'cities']);
    }

    public function show(Request $request, $id)
    {
        try {
            $shipping = $this->shippingRepository->findByColumn([
                'id' => $id,
                'store_id' => $request['store_id'],
            ], [
                'id',
                'title',
                'country',
                'status',
            ], ['config', 'cities' => function ($query) {
                $query->select('id', 'parent_id', 'city', 'radius');
            }]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $shipping;
    }

    public function destroy(Request $request, $id)
    {
        try {
            $ids = $request->input('ids');

            // if not array convert
            if (!\is_array($ids)) {
                $ids = explode(',', $ids);
            }

            $deleted = $this->shippingRepository->deleteByIds($ids);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }

    public function update(Request $request, $id)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'rules.*.country' => 'required|string',
//                'rules.*.id' => 'required',
                'rules.*.config.*.min' => 'required',
            ], [
                'rules.*.country.required' => 'The country field is required',
                'rules.*.country.string' => 'The country field must be a string',

            ]);

            // if validation fails throw exception
            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $return = [];

            foreach ($request->input('rules') as $key => $rules) {
                if (!isset($rules['id'])) {
                    $rules['id'] = 0;
                }

                // create or update
                $shipping = $this->shippingRepository->updateGetModel([
                    'id' => $rules['id'],
                    'store_id' => $request['store_id'],
                ], [
                    'country' => $rules['country'],
                    'status' => $rules['status'],
                    'store_id' => $request['store_id'],
                ]);

                if ($shipping) {
                    // save country shipping rules
                    foreach ($rules['config'] as $config) {
                        if (!isset($config['id'])) {
                            $config['id'] = 0;
                        }

                        // create or update
                        $this->shippingRuleRepository->updateGetModel([
                            'id' => $config['id'],
                            'shipping_id' => $shipping->id,
                        ], [
                            'shipping_id' => $shipping->id,
                            'min' => $config['min'], // minimum order amount
                            'max' => $config['max'], // maximum order amount
                            'charges' => $config['charges'],
                        ]);
                    }

                    // save cities shipping
                    foreach ($rules['cities'] as $city) {
                        if (!isset($city['id'])) {
                            $city['id'] = 0;
                        }

                        $child_shipping = $this->shippingRepository->updateGetModel([
                            'id' => $city['id'],
                        ], [
                            'parent_id' => $shipping->id,
                            'store_id' => $request['store_id'],
                            'country' => $rules['country'],
                            'city' => $city['city'],
                            'status' => $city['status'],
                        ]);

                        if ($child_shipping) {

                            // save cities shipping rules
                            foreach ($city['config'] as $city_config) {
                                if (!isset($city_config['id'])) {
                                    $city_config['id'] = 0;
                                }

                                $this->shippingRuleRepository->updateGetModel([
                                    'id' => $city_config['id'],
                                ], [
                                    'shipping_id' => $child_shipping->id,
                                    'min' => $city_config['min'], // minimum order amount
                                    'max' => $city_config['max'], // maximum order amount
                                    'charges' => $city_config['charges'],
                                ]);
                            }
                        }
                    }

                    $return[] = $shipping->fresh(['config' => function ($query) {
                        $query->select('shipping_id', 'id', 'min', 'max', 'charges');
                    }, 'cities' => function ($query) {
                        $query->select('parent_id', 'id', 'city', 'radius', 'latitude', 'longitude', 'status');
                    }])->only(['id', 'title', 'country', 'status', 'config', 'cities']);
                }
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $return;
    }
}
