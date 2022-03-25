<?php

namespace App\Services;

use App\Repositories\IndustriesRepositoryInterface;
use Exception;
use InvalidArgumentException;

class IndustriesService
{
    /**
     * @var
     */
    protected $industriesRepository;

    /**
     * AddressService constructor.
     */
    public function __construct(
        IndustriesRepositoryInterface $industriesRepository
    ) {
        $this->industriesRepository = $industriesRepository;
    }

    /**
     * Get all industries with types.
     *
     * @return $industries
     */
    public function all()
    {
        try {
            $industries = $this->industriesRepository->findAllByColumn(['parent_id' => 0], [
                'id',
                'name',
                'parent_id',
            ], ['types' => function ($query) {
                $query->select('id', 'name', 'parent_id');
            }]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $industries;
    }

    /**
     * get industry by id.
     *
     * @param $id
     *
     * @return $industry
     */
    public function show($slug)
    {
        $id = getIdBySlug($slug, 'App\Models\Industries');
        try {
            $industry = $this->industriesRepository->findById($id, [
                'id',
                'name',
                'parent_id',
            ], ['types' => function ($query) {
                $query->select('id', 'name', 'parent_id');
            }]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $industry;
    }
}
