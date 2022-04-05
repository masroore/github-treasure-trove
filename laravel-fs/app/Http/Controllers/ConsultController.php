<?php

namespace App\Http\Controllers;

use App\Helpers\Encryptor;
use App\Models\Models;
use App\Models\PosBoxe;
use App\Models\PosInventory;
use App\Models\PosRequest;
use App\Models\Storage;
use App\Models\TypeDocument;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultController extends Controller
{
    public $storage_find;
    /**
     *Consul Pos.
     */

    //protected $statusAvailable = 1; // status registers available

    public function consult_pos()
    {
        if (\Request::ajax()) {
            $tradeMark = Models::where('status', $this->statusAvailable)->get()->pluck('name_model', 'id')->toArray();

            $storage = Storage::pluck('name_storage', 'id');

            $search_box = PosBoxe::join('pos_inventories', 'pos_inventories.pos_box_id', '=', 'pos_boxes.id')
                ->join('storages', 'storages.id', '=', 'pos_inventories.storage_id')
                ->select('pos_boxes.*', 'pos_inventories.id as h', 'storages.*', 'pos_inventories.*')
                ->get()->toArray();

            return view('consult.consult_pos', compact('storage', 'tradeMark', 'search_box'));
        }

        return Redirect::to('home');
    }

    /**
     * Show the form for searh pos.
     */
    public function consult_pos_search(Request $request)
    {
        $where[] = [DB::raw('1'), '1'];
        if ($request->all() != null) {
            if ($request->model != null) {
                $where[] = ['pos_boxes.model_id', $request->model];
            }
            if ($request->serial != null) {
                $where[] = ['pos_inventories.serial', $request->serial];
            }
            if ($request->box_number != null) {
                $where[] = ['pos_boxes.number_box', $request->box_number];
            }
            if ($request->storage != null) {
                $where[] = ['pos_inventories.storage_id', $request->storage];
            }
        }
        $search_box = PosBoxe::join('pos_inventories', 'pos_inventories.pos_box_id', '=', 'pos_boxes.id')
            ->join('storages', 'storages.id', '=', 'pos_inventories.storage_id')
            ->select('pos_boxes.*', 'pos_inventories.id as h', 'storages.*', 'pos_inventories.*')
            ->where($where)
            ->get()->toArray();

        if (count($search_box) == 0) {
            $result['status'] = 0;
            $result['message'] = __('Data no found');
            $result['type_message'] = 'error';
            $result['redirect'] = '';
        } else {
            $result['status'] = 1;
            $result['message'] = __('Data Found');
            $result['data'] = $search_box;
            $result['type_message'] = 'success';
            $result['redirect'] = '';
        }

        return $result;
    }

    /**
     * view detail pos after search consult pos.
     */
    public function detail_pos($id1)
    {
        $search_pos = PosInventory::find($id1);

        try {
            $result['status'] = 1;
            $result['message'] = __('Success');
            $result['model'] = $search_pos['model'];
            $result['model_serial'] = $search_pos['model_serial'];
            $result['storage'] = $search_pos['storage'];
            $result['box_number'] = $search_pos['box_number'];
            $result['type_message'] = 'success';
            $result['redirect'] = '';
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['message'] = __('Failed, contact the administrator.');
            $result['data'] = null;
            $result['type_message'] = 'error';
            $result['redirect'] = '';
        }

        return $result;
    }

    /**
     * Consult request pos.
     */
    public function consult_request_pos()
    {
        if (\Request::ajax()) {
            return view('consult.consult_pos_request');
        }

        return Redirect::to('home');
    }

    /**
     * Show the form for searh request pos.
     */
    public function consult_request_pos_search($number)
    {
        $SearchNumber = Encryptor::encrypt($number);
        $search_request = PosRequest::where('storage_request_id', Auth::user()->storage_id)->find($number);
        if ($search_request === null) {
            $search_request = PosRequest::whereIn('storage_id', Auth::user()->list_storage_id)->find($number);

            if ($search_request === null) {
                $result = '';

                return $result;
            }
            //return view('consult.consult_pos_request_detail', compact('search_request'));
        }

        return view('consult.consult_pos_request_detail', compact('search_request', 'SearchNumber'));
    }

    public function consult_client()
    {
        if (\Request::ajax()) {
            $type_document = TypeDocument::pluck('abbreviation', 'id');

            return view('consult_clients.consult_client', compact('type_document'));
        }

        return Redirect::to('home');
    }

    public function view_graphic($storage_id)
    {
        $this->storage_find = $storage_id;
        // $model  = PosBoxe::where('processing', 0)->where('storage_id', $storage_id)->get()->toArray();
        //  $model  = Models::leftJoin('pos_boxes', 'pos_boxes.model_id', '=', 'models.id')
        $model = Models::leftJoin('pos_boxes', function ($join): void {
            $join->on('pos_boxes.model_id', '=', 'models.id');
            $join->on('pos_boxes.processing', '=', DB::raw('0'));
            $join->on('pos_boxes.storage_id', '=', DB::raw($this->storage_find));
        })
            ->leftJoin('trade_marks', 'trade_marks.id', '=', 'models.trade_mark_id')
            ->where('models.status', 1)
            ->select('models.id', 'models.serial')
            ->selectRaw("concat(trade_marks.name_trade_mark, ' ', models.serial) as full_name")
            ->selectRaw('count(pos_boxes.id) as cant_boxes')
            ->selectRaw('count(pos_boxes.id) *  models.quantity as cant_pos')
            ->groupBy('models.id', 'models.serial', 'full_name')
            ->get();
        $name_model = [];
        $amount_model = [];
        $amount_pos = [];
        foreach ($model as $value) {
            $name_model[] = $value->full_name;
            $amount_model[] = $value->cant_boxes;
            $amount_pos[] = $value->cant_pos;
        }

        return view('consult.consult_storage', compact('name_model', 'amount_model', 'amount_pos'));
    }
}
