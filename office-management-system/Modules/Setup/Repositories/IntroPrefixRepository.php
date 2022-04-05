<?php

namespace Modules\Setup\Repositories;

use Modules\Setup\Entities\IntroPrefix;

class IntroPrefixRepository implements IntroPrefixRepositoryInterface
{
    public function all()
    {
        return IntroPrefix::latest()->get();
    }

    public function serachBased($search_keyword)
    {
        return IntroPrefix::whereLike(['title'], $search_keyword)->get();
    }

    public function create(array $data)
    {
        return IntroPrefix::create($data);
    }

    public function find($id)
    {
        return IntroPrefix::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return IntroPrefix::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return IntroPrefix::findOrFail($id)->delete();
    }
}
