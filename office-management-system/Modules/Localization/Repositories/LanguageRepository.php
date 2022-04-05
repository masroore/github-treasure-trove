<?php

namespace Modules\Localization\Repositories;

use Modules\Localization\Entities\Language;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function all()
    {
        return Language::orderBy('status', 'desc')->get();
    }

    public function serachBased($search_keyword)
    {
        return Language::whereLike(['name', 'native', 'code'], $search_keyword)->get();
    }

    public function create(array $data): void
    {
        $language = new Language();
        $language->fill($data)->save();
    }

    public function find($id)
    {
        return Language::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return Language::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Language::findOrFail($id)->delete();
    }

    public function findByCode($code)
    {
        return Language::where('code', $code)->first();
    }
}
