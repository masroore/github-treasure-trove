<?php

namespace App\Services;

use App\Models\Deal;
use App\Repositories\DealGroupDetailsRepositoryInterface;
use App\Repositories\DealGroupsRepositoryInterface;
use App\Repositories\DealRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class DealService
{
    /**
     * @var DealRepositoryInterface
     */
    protected $dealRepository;

    protected $dealgroupsRepository;

    protected $dealgroupdetailsRepository;

    public function __construct(
        DealRepositoryInterface $dealRepository,
        DealGroupsRepositoryInterface $dealgroupsRepository,
        DealGroupDetailsRepositoryInterface $dealgroupdetailsRepository
    ) {
        $this->dealRepository = $dealRepository;
        $this->dealgroupsRepository = $dealgroupsRepository;
        $this->dealgroupdetailsRepository = $dealgroupdetailsRepository;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            //    validate request
            $validator = Validator::make($request->input(), [
                'deal_price' => 'required|numeric',
                'original_price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'start_date' => 'required',
            ]);
            // if validation fails throw exception
            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            $deals = $this->dealRepository->update(
                $id,
                $request->except('deal_group')
            );
            foreach ($request->deal_group as $groups) {
                if (!isset($groups['id'])) {
                    $groups['id'] = 0;
                }
                $group = $this->dealgroupsRepository->updateGetModel(
                    [
                        'id' => $groups['id'],
                        'deal_id' => $id,
                    ],
                    [
                        'title' => $groups['title'],
                        'deal_id' => $id,
                        'status' => 1,
                    ]
                );
                $group_id = $group->id;
//                dd($groups['products_id']);
                foreach ($groups['products_id'] as $product) {
                    $this->dealgroupdetailsRepository->updateGetModel(
                        [
                            'deal_group_id' => $group_id,
                            'product_id' => $product,
                        ],
                        [
                            'deal_group_id' => $group_id,
                            'product_id' => $product,
                            'status' => 1,
                        ]
                    );
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw new InvalidArgumentException($e->getMessage());
        }
        $data = Deal::where('id', $id)->with('groups', function ($q): void {
            $q->where('status', 1);
            $q->select('id', 'title', 'status', 'deal_id');
            $q->with('groupDetails', function ($k): void {
                $k->where('status', 1);
                $k->select('id', 'deal_group_id', 'product_id', 'status');
                $k->with('products', function ($p): void {
                    $p->select('id', 'name', 'price');
                });
            });
        })->first();

        return $data;
    }

    public function store(Request $request)
    {
//        dd($request->all());
        DB::beginTransaction();

        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'deal_price' => 'required|numeric',
                'original_price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'start_date' => 'required',
            ]);

            // if validation fails throw exception
            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $deals = $this->dealRepository->create($request->input());
            $deal_id = $deals->id;
            foreach ($request->deal_group as $groups) {
                $group = $this->dealgroupsRepository->create([
                    'title' => $groups['title'],
                    'deal_id' => $deal_id,
                    'status' => 1,
                ]);
                $group_id = $group->id;
                foreach ($groups['products_id'] as $product) {
                    $this->dealgroupdetailsRepository->create([
                        'deal_group_id' => $group_id,
                        'product_id' => $product,
                        'status' => 1,
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw new InvalidArgumentException($e->getMessage());
        }
        $data = Deal::where('id', $deals->id)->with('groups', function ($q): void {
            $q->where('status', 1);
            $q->select('id', 'title', 'status', 'deal_id');
            $q->with('groupDetails', function ($k): void {
                $k->where('status', 1);
                $k->select('id', 'deal_group_id', 'product_id', 'status');
                $k->with('products', function ($p): void {
                    $p->select('id', 'name', 'price');
                });
            });
        })->first();

        return $data;
    }

    public function view(Deal $deal)
    {
        try {
            $data = Deal::where('id', $deal->id)->with('groups', function ($q): void {
                $q->where('status', 1);
                $q->select('id', 'title', 'status', 'deal_id');
                $q->with('groupDetails', function ($k): void {
                    $k->where('status', 1);
                    $k->select('id', 'deal_group_id', 'product_id', 'status');
                    $k->with('products', function ($p): void {
                        $p->select('id', 'name', 'price');
                    });
                });
            })->first();
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $data;
    }

    public function index(Request $request)
    {
        try {
            $data = Deal::where('store_id', $request->store_id)->with('groups', function ($q): void {
                $q->where('status', 1);
                $q->select('id', 'title', 'status', 'deal_id');
                $q->with('groupDetails', function ($k): void {
                    $k->where('status', 1);
                    $k->select('id', 'deal_group_id', 'product_id', 'status');
                    $k->with('products', function ($p): void {
                        $p->select('id', 'name', 'price');
                    });
                });
            })->get();
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $data;
    }

    public function destroy($deal)
    {
        try {
            $data = $this->dealRepository->deleteByIds([$deal]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $data;
    }

    public function groupDelete($deal)
    {
        try {
            $data = $this->dealgroupsRepository->deleteByIds([$deal]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $data;
    }

    public function choiceDelete($deal)
    {
        try {
            $data = $this->dealgroupdetailsRepository->deleteByIds([$deal]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $data;
    }
}
