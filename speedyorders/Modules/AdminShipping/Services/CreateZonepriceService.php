<?php

namespace Modules\AdminShipping\Services;

use App\Models\ShippingDeliveryTime;
use App\Models\ShippingPackage;
use App\Models\ShippingZoneGroup;
use App\Models\ShippingZonePrice;
use Illuminate\Support\Facades\DB;
use Log;

class CreateZonepriceService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();

            $type = $validatedData['type'];

            $zonetimes = (isset($validatedData['shipping_delivery_times_id'])) ? $validatedData['shipping_delivery_times_id'] : [];
            $zonetimesprice = (isset($validatedData['price'])) ? $validatedData['price'] : [];

            switch ($type) {
                case '1':

                        $zoneGroup = new ShippingZoneGroup();
                        $zoneGroup->group_name = $validatedData['group_name'];
                        $zoneGroup->save();

                        $zipcode_data = explode(',', $validatedData['zip_code']);
                        $zip_counts = \count($zipcode_data);

                        if ($zip_counts > 1) {
                            foreach ($zipcode_data as $zipcode) {
                                $price_data['zip_code'] = $zipcode;
                                $price_data['shipping_zone_groups_id'] = $zoneGroup->id;

                                for ($i = 0; $i < \count($zonetimes); $i++) {
                                    $price_data['shipping_delivery_times_id'] = $zonetimes[$i];
                                    $price_data['shipping_packages_id'] = $validatedData['shipping_packages_id'];
                                    $price_data['price'] = $zonetimesprice[$i];

                                    ShippingZonePrice::create($price_data);
                                }
                            }
                        } else {
                            $price_data['zip_code'] = $validatedData['zip_code'];
                            $price_data['group_name'] = $validatedData['group_name'];
                            $price_data['shipping_packages_id'] = $validatedData['shipping_packages_id'];

                            for ($j = 0; $j < \count($zonetimes); $j++) {
                                $price_data['shipping_delivery_times_id'] = $zonetimes[$j];
                                $price_data['price'] = $zonetimesprice[$j];
                                $price_data['shipping_zone_groups_id'] = $zoneGroup->id;

                                ShippingZonePrice::create($price_data);
                            }
                        }
                    break;

                case '2':
                        $fileName = '';
                        if (isset($validatedData['file_name'])) {
                            $file_name = $validatedData['file_name'];
                            $fileName =
                                uniqid() .
                                time() .
                                '.' .
                                $file_name->getClientOriginalExtension();
                            $file_name->move(public_path('images/zoneprices'), $fileName);
                            $validatedData['file_name'] = $fileName;
                        }

                        // Now parse the csv and store all values in DB
                        $filename = public_path('images/zoneprices/' . $fileName);
                        $file = fopen($filename, 'r');
                        $all_data = [];

                        $count_header = 0;
                        while (($data = fgetcsv($file, 200, ',')) !== false) {
                            if ($count_header > 0) {
                                $group_name = $data[0];
                                $zip_code = $data[1];
                                $delivery_time = $data[2];
                                $package_name = $data[3];
                                $price = $data[4];

                                // check if package already exists
                                $package_Data = ShippingPackage::where('package_name', $package_name)->first();
                                if (!empty($package_Data)) {
                                    $shipping_packages_id = $package_Data['id'];
                                } else {
                                    $package_data = explode(' ', $package_name);

                                    $package_size_unit = 'inch';
                                    $package_length = $package_width = $package_height = '';
                                    if (isset($package_data[0]) && '' != $package_data[0]) {
                                        $sizes = explode('x', $package_data[0]);

                                        $package_length = (isset($sizes[0])) ? $sizes[0] : '';
                                        $package_width = (isset($sizes[1])) ? $sizes[1] : '';
                                        $package_height = (isset($sizes[2])) ? $sizes[2] : '';
                                    }

                                    $package_weight = $package_weight_unit = '';
                                    if (isset($package_data[0]) && '' != $package_data[0]) {
                                        $package_weight = preg_replace('/[^0-9]/', '', $package_data[1]);
                                        $package_weight_unit = preg_replace('/[^a-zA-Z]/', '', $package_data[1]);
                                    }

                                    $package = new ShippingPackage();
                                    $package->package_name = $package_name;
                                    $package->package_length = $package_length;
                                    $package->package_width = $package_width;
                                    $package->package_height = $package_height;
                                    $package->package_weight = $package_weight;
                                    $package->package_size_unit = $package_size_unit;
                                    $package->package_weight_unit = $package_weight_unit;
                                    $package->created_at = now();
                                    $package->save();

                                    $shipping_packages_id = $package->id;
                                }

                                // check if group name already exists
                                $shipping_zone_groups_Data = ShippingZoneGroup::where('group_name', $group_name)->first();
                                if (!empty($shipping_zone_groups_Data)) {
                                    $shipping_zone_groups_id = $shipping_zone_groups_Data['id'];
                                } else {
                                    $shipping_zone_group = new ShippingZoneGroup();
                                    $shipping_zone_group->group_name = $group_name;
                                    $shipping_zone_group->created_at = now();
                                    $shipping_zone_group->save();

                                    $shipping_zone_groups_id = $shipping_zone_group->id;
                                }

                                // check if delivery time already exists
                                $shipping_delivery_times_Data = ShippingDeliveryTime::where('name', $delivery_time)->first();
                                if (!empty($shipping_delivery_times_Data)) {
                                    $shipping_delivery_times_id = $shipping_delivery_times_Data['id'];
                                } else {
                                    $shipping_delivery_times = new ShippingDeliveryTime();
                                    $shipping_delivery_times->name = $delivery_time;
                                    $shipping_delivery_times->is_available = 1;
                                    $shipping_delivery_times->created_at = now();
                                    $shipping_delivery_times->save();

                                    $shipping_delivery_times_id = $shipping_delivery_times->id;
                                }

                                // Check if same value available for the group/package/delivery time combination then update it else add new one
                                $shippingzoneprice = ShippingZonePrice::where('shipping_zone_prices.zip_code', $zip_code)
                                    ->where('shipping_zone_prices.shipping_zone_groups_id', $group_name)
                                    ->where('shipping_zone_prices.shipping_delivery_times_id', $shipping_delivery_times_id);
                                $shippingzonepriceCount = $shippingzoneprice->count();

                                if ($shippingzonepriceCount > 0) {
                                    $shippingzoneprice->update(['file_name' => $fileName, 'price' => $price]);
                                } else {
                                    $shippingPrice = new ShippingZonePrice();
                                    $shippingPrice->shipping_zone_groups_id = $shipping_zone_groups_id;
                                    $shippingPrice->zip_code = $zip_code;
                                    $shippingPrice->price = $price;
                                    $shippingPrice->shipping_delivery_times_id = $shipping_delivery_times_id;
                                    $shippingPrice->shipping_packages_id = $shipping_packages_id;
                                    $shippingPrice->file_name = $fileName;
                                    $shippingPrice->save();
                                }
                            }

                            $count_header++;
                        }

                    break;

            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::info('Error' . $e->getMessage());
            // DB::rollback();
            return false;
        }
    }
}
