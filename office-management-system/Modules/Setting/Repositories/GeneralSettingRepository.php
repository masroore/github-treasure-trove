<?php

namespace Modules\Setting\Repositories;

use Modules\Setting\Model\GeneralSetting;

class GeneralSettingRepository implements GeneralSettingRepositoryInterface
{
    public function all()
    {
        return GeneralSetting::first();
    }

    public function update(array $data)
    {
        return GeneralSetting::first()->update($data);
    }
}
