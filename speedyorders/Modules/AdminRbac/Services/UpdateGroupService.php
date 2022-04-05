<?php

namespace Modules\AdminRbac\Services;

use Exception;
use Modules\AdminRbac\Models\AdminGroup;

class UpdateGroupService
{
    /**
     * @return bool
     */
    public function handle(array $data, int $id)
    {
        try {
            AdminGroup::find($id)->update($data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
