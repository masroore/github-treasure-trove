<?php

namespace App\Services;

use App\Repositories\EmployeeRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
//use Doctrine\Common\Cache\Psr6\InvalidArgument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class EmployeeService
{
    /**
     * @var
     */
    protected $employeeRepository;

    protected $userRepository;

    /**
     * EmployeeService constructor.
     */
    public function __construct(EmployeeRepositoryInterface $employeeRepository, UserRepositoryInterface $userRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->userRepository = $userRepository;
    }

    public function getAll(Request $request)
    {
        try {
            $employee = $this->employeeRepository->findAllByColumn([
                'store_id' => $request['store_id'],
                'is_admin' => 0,
            ], [
                'id',
                'user_id',
                'store_id',
                'phones',
                'addresses',
                'role_id',
            ], ['user' => function ($query): void {
                $query->select('id', 'name', 'email AS username');
            }]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $employee;
    }

    public function store(Request $request)
    {
        try {

            //Validate request
            $validator = Validator::make($request->input(), [
                'username' => 'required|string|unique:users,email',
                'name' => 'required|string',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors());
            }

            $password = $request['password'];
            $request['password'] = bcrypt($password);

            $request['phones'] = json_encode($request['phones']);
            $request['addresses'] = json_encode($request['addresses']);

            // create user
            $user = $this->userRepository->create([
                'name' => $request['name'],
                'email' => $request['username'],
                'password' => bcrypt($request['password']),
                'user_type' => 'employee',
                'wp_num_inc_code' => $request['username'],
                'wp_num_exc_code' => $request['username'],
                'user_status' => 1,
            ]);

            //$employee = $request->input()
            $new_employee = $this->employeeRepository->create([
                'user_id' => $user->id,
                'store_id' => $request['store_id'],
                'role_id' => $request['role_id'],
                'is_admin' => 0,
            ]);

            $employee['id'] = $new_employee->id;
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $employee;
    }

    public function show(Request $request, $id)
    {
        try {
            $employee = $this->employeeRepository->findByColumn([
                'id' => $id,
                'store_id' => $request['store_id'],
                'is_admin' => 0,
            ], [
                'id',
                'user_id',
                'store_id',
                'phones',
                'addresses',
                'role_id',
            ], ['user' => function ($query): void {
                $query->select('id', 'name', 'email AS username');
            }]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $employee;
    }

    public function update(Request $request, $id)
    {
        try {

            // validate request
            /*$validator = Validator::make($request->input(), [
                'store_id' => 'required|integer',
                'username' => 'required|string|unique:users,email,'.$id,
                'full_name' => 'required'
            ]);*/
            $employee_updated = false;
            $validator = Validator::make($request->input(), [
                'store_id' => 'required|integer',
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            $user_id = $request['user_id'];
            $updated = $this->employeeRepository->updateByColumn(
                [
                    'id' => $id,
                    'store_id' => $request['store_id'],
                    'user_id' => $user_id,
                ],
                [
                    'role_id' => $request['role_id'],
                    'phones' => json_encode($request['phones']),
                    'addresses' => json_encode($request['addresses']),
                ]
            );
            if (true === $updated) {
                $user_data = [];
                if ($request->has('password') && $request->filled('password')) {
                    $user_data['password'] = bcrypt($request['password']);
                }
                $user_data['name'] = $request['name'];
                $employee_updated = $this->userRepository->update($user_id, $user_data);
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $employee_updated;
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = $this->employeeRepository->findByColumn([
                'id' => $id,
                'store_id' => $request['store_id'],
                'is_admin' => 0,
            ], ['user_id']);

            $employee = $this->employeeRepository->deleteByColumn(['id' => $id, 'store_id' => $request['store_id']]);
            if (true === $employee) {
                $this->userRepository->deleteById($user->user_id);
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $employee;
    }
}
