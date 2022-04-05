<?php

namespace Modules\AdminRbac\Services;

use Exception;
use Modules\AdminRbac\Models\AdminGroup;
use Modules\AdminRbac\Models\AdminPermissionGroup;

class UpdatePermissionService
{
    /**
     * @param $id
     *
     * @return bool
     */
    public function handle(array $data, int $id)
    {
        try {
            AdminPermissionGroup::where('group_id', $id)
                ->delete();

            $group = AdminGroup::find($id);

            $references = $data['permission_reference_id'] ?? [];

            if (\count($references)) {
                $permissions = [];

                foreach ($references as $reference) {
                    $permissions[] = [
                        'group_id' => $group->id,
                        'permission_reference_id' => $reference,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                AdminPermissionGroup::insert($permissions);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
