<?php

namespace Modules\Report\Repositories;

interface StaffReportRepositoryInterface
{
    public function search($showroom_id, $department_id, $warehouse_id);
}
