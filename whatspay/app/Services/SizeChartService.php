<?php

namespace App\Services;

use App\Repositories\SizeChartRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class SizeChartService
{
    /**
     * @var
     */
    protected $sizeChartRepository;

    protected $userRepository;

    /**
     * SizeChartService constructor.
     */
    public function __construct(
        SizeChartRepositoryInterface $sizeChartRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->sizeChartRepository = $sizeChartRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Get all Categories of a user.
     */
    public function getAll(Request $request)
    {
        try {
            $get_data = $this->sizeChartRepository->findAllByColumn([
                'store_id' => $request['store_id'],
            ], [
                'id', 'name', 'image', 'description', 'status',
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $get_data;
    }

    public function store(Request $request)
    {
        try {

            // validate request
            $validator = Validator::make($request->input(), [
                'store_id' => 'required',
                'name' => 'required|string|unique:size_charts,name',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $sizechart = $this->sizeChartRepository->create(
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $sizechart;
    }

    public function show(Request $request, $id)
    {
        try {
            $get_data = $this->sizeChartRepository->findByColumn([
                'id' => $id,
                'store_id' => $request['store_id'],
            ], [
                'id', 'name', 'image', 'description', 'status',
            ], []);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $get_data;
    }

    public function update(Request $request, $id)
    {
        try {

            // validate request
            $validator = Validator::make($request->input(), [
                'store_id' => 'required',
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            return $this->sizeChartRepository->update(
                $id,
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function changeStatus(Request $request, $id)
    {
        try {

            // validate request
            $validator = Validator::make($request->input(), [
                'status' => 'required|in:0,1',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            return $this->sizeChartRepository->update(
                $id,
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ids = explode(',', $id);
            $deleted = $this->sizeChartRepository->deleteByIds($ids);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }
}
