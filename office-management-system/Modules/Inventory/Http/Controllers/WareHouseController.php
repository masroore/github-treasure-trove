<?php

namespace Modules\Inventory\Http\Controllers;

use App\Traits\Notification;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Inventory\Http\Requests\WarehouseFormRequest;
use Modules\Inventory\Repositories\WareHouseRepositoryInterface;

class WareHouseController extends Controller
{
    use Notification;

    protected $wareHouseRepository;

    public function __construct(WareHouseRepositoryInterface $wareHouseRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->wareHouseRepository = $wareHouseRepository;
    }

    public function index(Request $request)
    {
        try {
            $search_keyword = null;
            if ($request->input('search_keyword') != null) {
                $search_keyword = $request->input('search_keyword');
                $warehouses = $this->wareHouseRepository->serachBased($search_keyword);
            } else {
                $warehouses = $this->wareHouseRepository->all();
            }

            return view('inventory::warehouses.index', [
                'warehouses' => $warehouses,
                'search_keyword' => $search_keyword,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation failed');

            return back();
        }
    }

    public function store(WarehouseFormRequest $request)
    {
        try {
            $warehouse = $this->wareHouseRepository->create($request->except('_token'));
            $user_id = null;
            $role_id = $request->for_whom;
            $subject = $warehouse->name;
            $class = $warehouse;
            $data = 'A WareHouse Has been Created';
            $url = 'showroom.index';
            $this->sendNotification($class, null, $subject, null, null, $data, $user_id, $role_id, $url);

            LogActivity::successLog('New WareHouse - (' . $request->name . ') has been created.');
            Toastr::success(__('inventory.WareHouse has been added Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for WareHouse creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function edit(Request $request)
    {
        try {
            $warehouse = $this->wareHouseRepository->find($request->id);

            return view('inventory::warehouses.edit', [
                'warehouse' => $warehouse,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return $e->getMessage();
        }
    }

    public function update(WarehouseFormRequest $request, $id)
    {
        try {
            $warehouse = $this->wareHouseRepository->update($request->except('_token'), $id);
            LogActivity::successLog($request->name . '- has been updated.');
            Toastr::success(__('inventory.WareHouse has been updated Successfully'));

            return redirect()->route('warehouse.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for WareHouse update');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $warehouse = $this->wareHouseRepository->delete($id);
            LogActivity::successLog('A WareHouse has been destroyed.');
            Toastr::success(__('inventory.WareHouse has been deleted Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for WareHouse Destroy');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }
}
