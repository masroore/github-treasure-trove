<?php

namespace App\Repositories;

use App\Staff;
use App\StaffDocument;
use App\Traits\ImageStore;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Importer;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\TimePeriodAccount;
use Modules\Account\Repositories\OpeningBalanceHistoryRepository;
use Modules\Setting\Model\BusinessSetting;

class UserRepository implements UserRepositoryInterface
{
    use ImageStore;

    public function user()
    {
        return User::with('leaves', 'leaveDefines')->latest()->get();
    }

    public function all($relational_keyword = [])
    {
        if (count($relational_keyword) > 0) {
            return Staff::with($relational_keyword)->latest()->get();
        }

        return Staff::latest()->get();
    }

    public function create(array $data)
    {
        $user = User::create($data);

        if (BusinessSetting::where('type', 'email_verification')->first()->status != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->save();
        } else {
            $user->sendEmailVerificationNotification();
        }
        $staff = new Staff();
        $staff->user_id = $user->id;
        $staff->save();
        $chart_account = new ChartAccount();
        $chart_account->level = 2;
        $chart_account->is_group = 0;
        $chart_account->name = $staff->user->name;
        $chart_account->description = null;
        $chart_account->parent_id = 6;
        $chart_account->status = 1;
        $chart_account->configuration_group_id = 4;
        $chart_account->type = 1;
        $chart_account->contactable_type = 'App\\User';
        $chart_account->contactable_id = $user->id;
        $chart_account->save();
        ChartAccount::findOrFail($chart_account->id)->update(['code' => '0' . $chart_account->type . '-' . $chart_account->parent_id . '-' . $chart_account->id]);

        return $staff;
    }

    public function store(array $data)
    {
        $role = explode('-', $data['role_id']);
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->username = $data['username'] ?? null;
        $user->role_id = $role[0];
        if (isset($data['photo'])) {
            $data = Arr::add($data, 'avatar', $this->saveAvatar($data['photo']));
            $user->avatar = $data['avatar'];
        }
        if (isset($data['signature_photo'])) {
            $data = Arr::add($data, 'signature', $this->saveAvatar($data['signature_photo'], 120, 60));
            $user->signature = $data['signature'];
        }
        $user->password = Hash::make($data['password']);
        if ($user->save()) {
            $staff = new Staff();
            $staff->user_id = $user->id;
            $staff->department_id = $data['department_id'];
            $staff->showroom_id = $data['showroom_id'];
            $staff->warehouse_id = (!empty($data['warehouse_id'])) ? $data['warehouse_id'] : null;
            $staff->phone = $data['username'] ?? null;
            if ($role[1] != 'system_user') {
                $staff->opening_balance = $data['opening_balance'];
                $staff->bank_name = $data['bank_name'];
                $staff->bank_branch_name = $data['bank_branch_name'];
                $staff->bank_account_name = $data['bank_account_name'];
                $staff->bank_account_no = $data['bank_account_no'];
                $staff->basic_salary = $data['basic_salary'] ?? 0;
                $staff->employment_type = $data['employment_type'] ?? 'Permanent';
                $staff->date_of_joining = isset($data['date_of_joining']) ? Carbon::parse($data['date_of_joining'])->format('Y-m-d') : date('Y-m-d');
                if (!empty($data['provisional_months'])) {
                    $staff->provisional_months = $data['provisional_months'];
                }
                $staff->date_of_birth = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
                $staff->leave_applicable_date = Carbon::parse($data['leave_applicable_date'])->format('Y-m-d');
                $staff->current_address = $data['current_address'];
                $staff->permanent_address = $data['permanent_address'];
            }
            if ($staff->save()) {
                if (BusinessSetting::where('type', 'email_verification')->first()->status != 1) {
                    $user->email_verified_at = date('Y-m-d H:m:s');
                    $user->save();
                } else {
                    $user->sendEmailVerificationNotification();
                }
            }
            if ($role[1] != 'system_user') {
                $chart_account = new ChartAccount();
                $chart_account->level = 2;
                $chart_account->is_group = 0;
                $chart_account->name = $staff->user->name;
                $chart_account->description = null;
                $chart_account->parent_id = 9;
                $chart_account->status = 1;
                $chart_account->configuration_group_id = 4;
                $chart_account->type = 1;
                $chart_account->contactable_type = 'App\\User';
                $chart_account->contactable_id = $user->id;
                $chart_account->save();
                ChartAccount::findOrFail($chart_account->id)->update(['code' => '0' . $chart_account->type . '-' . $chart_account->parent_id . '-' . $chart_account->id]);
                if ($staff->opening_balance != null || $staff->opening_balance > 0) {
                    $repo = new OpeningBalanceHistoryRepository();
                    $repo->createForUser([
                        'asset_account_id' => $chart_account->id,
                        'asset_amount' => $staff->opening_balance,
                        'date' => Carbon::now()->format('Y-m-d'),
                        'time_period_id' => TimePeriodAccount::latest()->first()->id,
                        'liability_account_id' => ChartAccount::where('code', '02-09')->first()->id,
                        'liability_amount' => $staff->opening_balance,
                    ]);
                    $repo->createForHistory([
                        'account_id' => $chart_account->id,
                        'type' => 'staff',
                        'amount' => $staff->opening_balance,
                    ]);
                }

                return $staff;
            }

            return $staff;
        }
    }

    public function find($id)
    {
        return Staff::with('user')->findOrFail($id);
    }

    public function findUser($id)
    {
        return User::findOrFail($id);
    }

    public function findDocument($id)
    {
        return StaffDocument::where('staff_id', $id)->get();
    }

    public function update(array $data, $id)
    {
        $role = explode('-', $data['role_id']);
        $user = User::findOrFail($id);
        $staff = $user->staff;
        if (isset($data['photo'])) {
            $data = Arr::add($data, 'avatar', $this->saveAvatar($data['photo']));
            $user->avatar = $data['avatar'];
        }
        if (isset($data['signature_photo'])) {
            $data = Arr::add($data, 'signature', $this->saveAvatar($data['signature_photo'], 120, 60));
            $user->signature = $data['signature'];
        }

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->name = $data['name'];
        $user->username = $data['username'] ?? null;
        $user->role_id = $role[0];
        $result = $user->save();
        if ($result) {
            $staff->user_id = $user->id;
            $staff->department_id = $data['department_id'];
            if ($role[1] != 'system_user') {
                $staff->opening_balance = $data['opening_balance'];
                $staff->bank_name = $data['bank_name'];
                $staff->bank_branch_name = $data['bank_branch_name'];
                $staff->bank_account_name = $data['bank_account_name'];
                $staff->bank_account_no = $data['bank_account_no'];
                $staff->basic_salary = $data['basic_salary'];
                $staff->employment_type = $data['employment_type'];
                $staff->date_of_joining = Carbon::parse($data['date_of_joining'])->format('Y-m-d');
                if (!empty($data['provisional_months'])) {
                    $staff->provisional_months = $data['provisional_months'];
                }
                $staff->date_of_birth = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
                $staff->current_address = $data['current_address'];
                $staff->permanent_address = $data['permanent_address'];
            }

            $staff->showroom_id = $data['showroom_id'];
            $staff->warehouse_id = (!empty($data['warehouse_id'])) ? $data['warehouse_id'] : null;
            $staff->phone = $data['username'] ?? null;

            $staff->save();
        }

        return $staff;
    }

    public function updateProfile(array $data, $id)
    {
        $user = User::findOrFail($id);
        if (isset($data['avatar'])) {
            $user->avatar = $this->saveAvatar($data['avatar'], 60, 60);
        }
        $user->name = $data['name'];
        if (isset($data['password']) && $data['password']) {
            $user->password = bcrypt($data['password']);
        }

        $result = $user->save();
        $staff = $user->staff;
        if ($result) {
            $staff->phone = $data['phone'];
            if ($user->role_id != 1) {
                $staff->bank_name = $data['bank_name'];
                $staff->bank_branch_name = $data['bank_branch_name'];
                $staff->bank_account_name = $data['bank_account_name'];
                $staff->bank_account_no = $data['bank_account_no'];
                $staff->current_address = $data['current_address'];
                $staff->permanent_address = $data['permanent_address'];
            }

            $staff->save();
        }

        return $staff;
    }

    public function delete($id): void
    {
        $user = User::findOrFail($id);
        if (File::exists($user->avatar)) {
            File::delete($user->avatar);
        }
        $user->staff->delete();
        $user->delete();
    }

    public function statusUpdate($data): void
    {
        $user = User::find($data['id']);
        $user->is_active = $data['status'];
        $user->save();
    }

    public function deleteStaffDoc($id): void
    {
        $document = StaffDocument::findOrFail($id)->delete();
    }

    public function normalUser()
    {
        return User::where('id', Auth::id())->orwhere('role_id', 3)->get();
    }

    public function roleUsers($role_id)
    {
        return User::where('role_id', $role_id)->where('is_active', 1)->get();
    }

    public function csv_upload_staff($data): void
    {
        if (!empty($data['file'])) {
            ini_set('max_execution_time', 0);
            $a = $data['file']->getRealPath();
            $column_name = Importer::make('Excel')->load($a)->getCollection()->skip(1)->first();

            foreach (Importer::make('Excel')->load($a)->getCollection()->skip(2) as $ke => $row) {
                if (checkEmail($row[1])) {
                    $user = User::create([
                        $column_name[0] => $row[0],
                        $column_name[1] => $row[1],
                        $column_name[2] => $row[2],
                        $column_name[3] => bcrypt($row[3]),
                        'role_id' => 3,
                        'email_verified_at' => date('Y-m-d H:m:s'),
                    ]);
                } else {
                    $user = User::create([
                        $column_name[0] => $row[0],
                        $column_name[2] => $row[2],
                        $column_name[3] => bcrypt($row[3]),
                        'role_id' => 3,
                        'email_verified_at' => date('Y-m-d H:m:s'),
                    ]);
                }

                $staff = Staff::create([
                    'user_id' => $user->id,
                    'department_id' => 1,
                    'showroom_id' => 1,
                    $column_name[4] => $row[4],
                    $column_name[5] => Carbon::parse($row[5])->format('Y-m-d'),
                    $column_name[6] => $row[6],
                    $column_name[7] => $row[7],
                    $column_name[8] => $row[8],
                    $column_name[9] => $row[9],
                    $column_name[10] => $row[10],
                    $column_name[11] => $row[11],
                    $column_name[12] => $row[12],
                    $column_name[13] => $row[13],
                    $column_name[14] => $row[14],
                    $column_name[15] => empty($row[15]) ? null : Carbon::parse($row[15])->format('Y-m-d'),
                ]);

                $this->create_chart_account($user, $staff);
            }
        }
    }

    public function create_chart_account($user, $staff): void
    {
        $chart_account = new ChartAccount();
        $chart_account->level = 2;
        $chart_account->is_group = 0;
        $chart_account->name = $staff->user->name;
        $chart_account->description = null;
        $chart_account->parent_id = 9;
        $chart_account->status = 1;
        $chart_account->configuration_group_id = 4;
        $chart_account->type = 1;
        $chart_account->contactable_type = 'App\\User';
        $chart_account->contactable_id = $user->id;
        $chart_account->save();
        ChartAccount::findOrFail($chart_account->id)->update(['code' => '0' . $chart_account->type . '-' . $chart_account->parent_id . '-' . $chart_account->id]);
        if ($staff->opening_balance != null || $staff->opening_balance > 0) {
            $repo = new OpeningBalanceHistoryRepository();
            $repo->createForUser([
                'asset_account_id' => $chart_account->id,
                'asset_amount' => $staff->opening_balance,
                'date' => Carbon::now()->format('Y-m-d'),
                'time_period_id' => TimePeriodAccount::latest()->first()->id,
                'liability_account_id' => ChartAccount::where('code', '02-09')->first()->id,
                'liability_amount' => $staff->opening_balance,
            ]);
            $repo->createForHistory([
                'account_id' => $chart_account->id,
                'type' => 'staff',
                'amount' => $staff->opening_balance,
            ]);
        }
    }
}
