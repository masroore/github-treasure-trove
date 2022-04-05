<?php

namespace Modules\Leave\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Leave\Entities\LeaveDefine;

class LeaveDefineRepository
{
    public function all()
    {
        return LeaveDefine::latest()->get();
    }

    public function create(array $data)
    {
        if (!empty($data['users']) && count($data['users']) > 0) {
            $data['days'] = $data['total_days'];
            foreach ($data['users'] as $user_id) {
                $data['user_id'] = $user_id;

                $user_leave = $this->userWiseLeave($data['user_id'], $data['leave_type_id']);
                if ($user_leave) {
                    $user_leave->total_days = $data['adjust_days'] + $data['total_days'];
                    $user_leave->year = array_key_exists('year', $data) ? Carbon::now()->year : null;
                    $user_leave->save();
                } else {
                    if (array_key_exists('adjusted', $data) && $data['adjusted'] == 1) {
                        $data['total_days'] = $data['adjust_days'] + $data['days'];
                    }

                    $data['year'] = array_key_exists('year', $data) ? Carbon::now()->year : null;

                    LeaveDefine::create($data);
                }
            }
        } else {
            $defines = LeaveDefine::where('role_id', $data['role_id'])->where('leave_type_id', $data['leave_type_id'])->where('user_id', null)->get();
            foreach ($defines as $define) {
                $define->total_days += $data['total_days'];
                $define->save();
            }
            LeaveDefine::create($data);
        }

        return true;
    }

    public function find($id)
    {
        return LeaveDefine::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $leave = LeaveDefine::findOrFail($id);
        $data['updated_by'] = Auth::id();
        if (!array_key_exists('adjusted', $data)) {
            $data['adjusted'] = 0;
        }
        $data['adjust_days'] = $leave->total_days;
        $defines = LeaveDefine::where('role_id', $data['role_id'])->where('leave_type_id', $data['leave_type_id'])->where('id', '!=', $id)->get();
        foreach ($defines as $define) {
            $data['days'] = $data['total_days'];
            if ($leave->adjusted == 1) {
                $data['days'] = $data['total_days'] - $leave->total_days;
            }

            if (array_key_exists('adjusted', $data) && $data['adjusted'] == 1) {
                $define->total_days += $data['days'];
                $define->save();
            } else {
                $define->total_days -= $data['total_days'];
                $define->save();
            }
        }
        if (!empty($data['users']) && count($data['users']) > 0) {
            $data['days'] = $data['total_days'];
            foreach ($data['users'] as $user_id) {
                $exists = $this->userWiseLeave($data['leave_type_id'], $user_id);
                if ($exists) {
                    $exists->year = array_key_exists('year', $data) ? Carbon::now()->year : null;
                    $exists->total_days = $data['total_days'] + $data['adjust_days'];
                    $exists->save();
                } else {
                    $data['user_id'] = $user_id;
                    if (array_key_exists('adjusted', $data) && $data['adjusted'] == 1) {
                        $data['total_days'] = $data['days'];
                    }

                    $data['year'] = array_key_exists('year', $data) ? Carbon::now()->year : null;
                    LeaveDefine::create($data);
                }
            }
        }
        $data['user_id'] = null;
        $leave->update($data);
    }

    public function delete($id)
    {
        return LeaveDefine::destroy($id);
    }

    public function roleWiseLeave($leave_type_id, $role_id)
    {
        return LeaveDefine::where('role_id', $role_id)->where('leave_type_id', $leave_type_id)->where('user_id', null)->first();
    }

    public function userWiseLeave($leave_type_id, $user_id)
    {
        return LeaveDefine::where('leave_type_id', $leave_type_id)->where('user_id', $user_id)->first();
    }
}
