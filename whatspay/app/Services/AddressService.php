<?php

namespace App\Services;

use App\Repositories\AddressRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AddressService
{
    /**
     * @var
     */
    protected $addressRepository;

    /**
     * AddressService constructor.
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository
    ) {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Get all addresses of a user.
     */
    public function getAll()
    {
        try {
            $addresses = $this->addressRepository->findAllByColumn([
                'user_id' => Auth::user()->id,
            ], [
                'id',
                'title',
                'phone',
                'country',
                'city',
                'address',
                'is_default',
            ]);
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
                'title' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'address' => 'required|string',
                'is_default' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            // update previous default address
            if ($request['is_default']) {
                $this->addressRepository->updateByColumn(
                    ['user_id' => Auth::user()->id],
                    [
                        'is_default' => 0,
                    ]
                );
            }

            $request['user_id'] = Auth::user()->id;

            $address = $this->addressRepository->create(
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function show($id)
    {
        try {
            $address = $this->addressRepository->findByColumn([
                'id' => $id,
                'user_id' => Auth::user()->id,
            ], [
                'title',
                'phone',
                'country',
                'city',
                'address',
                'is_default',
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function destroy($id)
    {
        try {
            $address = $this->addressRepository->deleteById($id);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function update(Request $request, $id)
    {
        try {

            // validate request
            $validator = Validator::make($request->input(), [
                'title' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'address' => 'required|string',
                'is_default' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            return $this->addressRepository->update(
                $id,
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function default($id): void
    {
        try {
            // update previous default address to 0
            $this->addressRepository->updateByColumn([
                'user_id' => Auth::user()->id,
            ], [
                'is_default' => 0,
            ]);

            // now make specified address default (1)
            $this->addressRepository->updateByColumn([
                'user_id' => Auth::user()->id,
                'id' => $id,
            ], [
                'is_default' => 1,
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
