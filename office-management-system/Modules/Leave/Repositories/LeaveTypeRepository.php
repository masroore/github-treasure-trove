<?php

namespace Modules\Leave\Repositories;

use Illuminate\Support\Facades\Auth;
use Modules\Leave\Entities\LeaveType;

class LeaveTypeRepository
{
    public function all()
    {
        return LeaveType::latest()->get();
    }

    public function create(array $data): void
    {
        $variant = new LeaveType();
        $data['created_by'] = Auth::id();
        $variant->fill($data)->save();
    }

    public function find($id)
    {
        return LeaveType::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $variant = LeaveType::findOrFail($id);
        $data['updated_by'] = Auth::id();
        $variant->update($data);
    }

    public function delete($id)
    {
        return LeaveType::destroy($id);
    }

    public function activeTypes()
    {
        return LeaveType::Active()->get();
    }
}
