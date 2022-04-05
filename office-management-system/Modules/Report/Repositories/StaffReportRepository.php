<?php

namespace Modules\Report\Repositories;

use App\Staff;

class StaffReportRepository implements StaffReportRepositoryInterface
{
    public function search($showroom_id, $department_id, $warehouse_id)
    {
        $conditions = [];

        if ($showroom_id != null) {
            $conditions = array_merge($conditions, ['showroom_id' => $showroom_id]);
        }

        if ($department_id != null) {
            $conditions = array_merge($conditions, ['department_id' => $department_id]);
        }

        if ($warehouse_id != null) {
            $conditions = array_merge($conditions, ['warehouse_id' => $warehouse_id]);
        }

        if (count($conditions) > 0) {
            $results = Staff::with('user')->where($conditions)->latest()->get();
        } else {
            $results = Staff::with('user.role')->latest()->get();
        }

        return $results;
    }
}
