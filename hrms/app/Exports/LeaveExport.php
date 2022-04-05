<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Leave;
use Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Leave::get();
        foreach ($data as $k => $leave) {
            $data[$k]['employee_id'] = Employee::employee_name($leave->employee_id);
            $data[$k]['leave_type_id'] = !empty(Auth::user()->getLeaveType($leave->leave_type_id)) ? Auth::user()->getLeaveType($leave->leave_type_id)->title : '';
            $data[$k]['created_by'] = Employee::login_user($leave->created_by);
            $leave->created_at = null; $leave->updated_at = null;
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee Name',
            'Leave Type',
            'Applied on',
            'Start Date',
            'End date',
            'Total leave Days',
            'Leave Reason',
            'Remark',
            'Status',
            'Created By',
        ];
    }
}
