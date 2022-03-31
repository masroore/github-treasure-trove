<?php

namespace Modules\AdminRbac\Services;

use Modules\AdminRbac\Models\AdminGroup;

class CreateGroupService
{
    /**
     * @return bool|object
     */
    public function handle(array $data)
    {
        try {
            AdminGroup::create($data);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
