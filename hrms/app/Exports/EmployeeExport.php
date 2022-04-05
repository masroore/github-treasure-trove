<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Employee::get();
        foreach ($data as $k => $employee) {
            $data[$k]['branch_id'] = $employee->branch->name;
            $data[$k]['department_id'] = $employee->department->name;
            $data[$k]['designation_id'] = $employee->designation->name;
            $data[$k]['salary_type'] = !empty($employee->salary_type) ? $employee->salaryType->name : '-';
            $data[$k]['salary'] = Employee::employee_salary($employee->salary);
            $data[$k]['created_by'] = Employee::login_user($employee->created_by);
            $employee->id = null; $employee->user_id = null; $employee->documents = null; $employee->tax_payer_id = null; $employee->is_active = null; $employee->created_at = null; $employee->updated_at = null;
        }

        return $data;
    }

    public function headings(): array
    {
        return [

            'Name',
            'Date of Birth',
            'Gender',
            'Phone Number',
            'Address',
            'Email ID',
            'Password',
            'Employee ID',
            'Branch',
            'Department',
            'Designation',
            'Date of Join',
            'Account Holder Name',
            'Account Number',
            'Bank Name',
            'Bank Identifier Code',
            'Branch Location',
            'Salary Type',
            'Salary',
            'Created By',
        ];
    }
}
