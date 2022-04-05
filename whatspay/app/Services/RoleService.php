<?php

namespace App\Services;

use App\Repositories\RoleRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class RoleService
{
    /**
     * @var
     */
    protected $roleRepository;

    /**
     * AttributeSetService constructor.
     */
    public function __construct(
        RoleRepositoryInterface $roleRepository
    ) {
        $this->roleRepository = $roleRepository;
    }

    public function store(Request $request)
    {
        $request['store_id'] = request()
            ->user()
            ->currentAccessToken()
            ->store_id;
//        dd($request['store_id']);
        try {
            $validator = Validator::make($request->input(), [
                'name' => 'required|string|unique:roles,name,',
                'store_id' => 'required|integer',
                'permissions' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            // create data
            $role = $this->roleRepository->create($request->input());
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $role;
    }

    public function update(Request $request, $id)
    {
        $request['store_id'] = request()
            ->user()
            ->currentAccessToken()
            ->store_id;

        try {
            $validator = Validator::make($request->input(), [
                'name' => 'required|string|unique:roles,name,' . $id,
                'store_id' => 'required|integer',
                'permissions' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $role = $this->roleRepository->updateByColumn(
                ['id' => $id],
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $role;
    }

    public function show($id)
    {
        try {
            $role = $this->roleRepository->findByColumn(['id' => $id]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $role;
    }

    public function index($request)
    {
        $request['store_id'] = request()
            ->user()
            ->currentAccessToken()
            ->store_id;

        try {
//             update data
            $role = $this->roleRepository->findAllByColumn(['store_id' => $request['store_id']]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $role;
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->roleRepository->deleteByColumn([
                'id' => $id,
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }
}
