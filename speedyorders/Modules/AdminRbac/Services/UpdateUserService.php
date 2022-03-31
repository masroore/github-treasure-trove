<?php

namespace Modules\AdminRbac\Services;

use Illuminate\Support\Facades\DB;
use Modules\AdminRbac\Models\AdminUserGroup;

class UpdateUserService extends UserService
{
    public function handle(array $data, ?int $id = null)
    {
        try {
            DB::beginTransaction();

            $user = $this->findById($id);

            $groups = $data['groups'] ?? [];

            $user->update($data);

            if (\count($groups) > 0) {
                AdminUserGroup::where('user_id', $user->id)->delete();
                $this->addUserGroup($user, $groups);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
