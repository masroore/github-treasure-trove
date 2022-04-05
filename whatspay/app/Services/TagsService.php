<?php

namespace App\Services;

use App\Repositories\TagsRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class TagsService
{
    /**
     * @var
     */
    protected $tagsRepository;

    /**
     * CategoryService constructor.
     */
    public function __construct(
        TagsRepositoryInterface $tagsRepository
    ) {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * Get all tags.
     */
    public function getAll()
    {
        try {
            $tags = $this->tagsRepository->findByColumn([
                'status' => 1,
            ], [
                'name',
                'status',
            ], [])->paginate(10);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $tags;
    }

    public function store(Request $request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'name' => 'required|string|unique:tags,name',
                'status' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $tag = $this->tagsRepository->create($request->input());
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $tag;
    }

    /*public function show($id) {
        try {
            $category = $this->tagsRepository->findByColumn([
                'id' => $id,
            ], [
                'id',
                'name',
                'status'
            ]);

        } catch(Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $category;
    }

    public function destroy($id) {
        try {
            $deleted = $this->tagsRepository->deleteById($id);
        } catch(Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }

    public function update(Request $request, $id) {
        try{

            // validate request
            $validator = Validator::make($request->input(), [
                'name' => 'required|string|unique:tags,name,'.$id,
                'status' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            return $this->tagsRepository->update($id, $request->input());

        } catch(Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }*/

    public function search($keyword)
    {
        try {
            return $this->tagsRepository->findByKeyword('name', '%' . $keyword . '%', ['id', 'name']);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
