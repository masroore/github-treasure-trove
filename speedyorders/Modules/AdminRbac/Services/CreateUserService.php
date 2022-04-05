<?php

namespace Modules\AdminRbac\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateUserService extends UserService
{
    public function handle(array $data, ?int $id = null)
    {
        try {
            DB::beginTransaction();

            $data['password'] = bcrypt($data['password']);
            $groups = $data['groups'] ?? [];

            if (isset($data['groups'])) {
                unset($data['groups']);
            }

            $user = User::create($data);

            $details['user_id'] = $user->id;

            if (\count($groups) > 0) {
                $this->addUserGroup($user, $groups);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
