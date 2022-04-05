<?php
/*
    16.12.2019
    RolesService.php
*/

namespace App\Services;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FormService
{
    public function __construct()
    {
    }

    public function saveSingleFormData($slug, $request, $formId): void
    {
        $formField = new FormField();
        $formField->name = $request[$slug . '_name'];
        $formField->type = $request[$slug . '_field_type'];
        if (isset($request[$slug . '_browse'])) {
            $formField->browse = 1;
        } else {
            $formField->browse = 0;
        }
        if (isset($request[$slug . '_read'])) {
            $formField->read = 1;
        } else {
            $formField->read = 0;
        }
        if (isset($request[$slug . '_edit'])) {
            $formField->edit = 1;
        } else {
            $formField->edit = 0;
        }
        if (isset($request[$slug . '_add'])) {
            $formField->add = 1;
        } else {
            $formField->add = 0;
        }
        if (isset($request[$slug . '_relation_table'])) {
            $formField->relation_table = $request[$slug . '_relation_table'];
        }
        if (isset($request[$slug . '_relation_column'])) {
            $formField->relation_column = $request[$slug . '_relation_column'];
        }
        $formField->form_id = $formId;
        $formField->column_name = $slug;
        $formField->save();
    }

    public function updateSingleFormField($field, $request): void
    {
        $field->name = $request[$field->id . '_name'];
        $field->type = $request[$field->id . '_field_type'];
        if (isset($request[$field->id . '_browse'])) {
            $field->browse = 1;
        } else {
            $field->browse = 0;
        }
        if (isset($request[$field->id . '_read'])) {
            $field->read = 1;
        } else {
            $field->read = 0;
        }
        if (isset($request[$field->id . '_edit'])) {
            $field->edit = 1;
        } else {
            $field->edit = 0;
        }
        if (isset($request[$field->id . '_add'])) {
            $field->add = 1;
        } else {
            $field->add = 0;
        }
        if (isset($request[$field->id . '_relation_table'])) {
            $field->relation_table = $request[$field->id . '_relation_table'];
        }
        if (isset($request[$field->id . '_relation_column'])) {
            $field->relation_column = $request[$field->id . '_relation_column'];
        }
        $field->save();
    }

    public function updateForm($formId, $request): void
    {
        $form = Form::find($formId);
        $form->name = $request['name'];
        $form->pagination = $request['pagination'];
        if (isset($request['read'])) {
            $form->read = true;
        } else {
            $form->read = false;
        }
        if (isset($request['edit'])) {
            $form->edit = true;
        } else {
            $form->edit = false;
        }
        if (isset($request['add'])) {
            $form->add = true;
        } else {
            $form->add = false;
        }
        if (isset($request['delete'])) {
            $form->delete = true;
        } else {
            $form->delete = false;
        }
        $form->save();
        $formFields = FormField::where('form_id', '=', $formId)->get();
        foreach ($formFields as $field) {
            $this->updateSingleFormField($field, $request);
        }
        $this->revokeAllPermisions($form->id, $request);
        $this->givePermissions($form->id, $request);
    }

    public function addNewForm($model, $request): void
    {
        $form = new Form();
        $form->name = $request['name'];
        $form->pagination = $request['pagination'];
        $form->table_name = $model;
        if (isset($request['read'])) {
            $form->read = true;
        } else {
            $form->read = false;
        }
        if (isset($request['edit'])) {
            $form->edit = true;
        } else {
            $form->edit = false;
        }
        if (isset($request['add'])) {
            $form->add = true;
        } else {
            $form->add = false;
        }
        if (isset($request['delete'])) {
            $form->delete = true;
        } else {
            $form->delete = false;
        }
        $form->save();
        $formDatas = $this->getFormDataByModel($model);
        foreach ($formDatas as $formData) {
            if ($formData != 'id') {
                $this->saveSingleFormData($formData, $request, $form->id);
            }
        }
        $this->givePermissions($form->id, $request);
    }

    public function getBreadRoles($formId)
    {
        $result = [];
        $roles = Role::all();
        foreach ($roles as $role) {
            if ($role->hasPermissionTo('browse bread ' . $formId)) {
                $result[] = $role->name;
            }
        }

        return $result;
    }

    public function createPermissions($formId): void
    {
        $permission = Permission::where('name', '=', 'browse bread ' . $formId)->first();
        if (empty($permission)) {
            Permission::create(['name' => 'browse bread ' . $formId]);
        }
        $permission = Permission::where('name', '=', 'read bread ' . $formId)->first();
        if (empty($permission)) {
            Permission::create(['name' => 'read bread ' . $formId]);
        }
        $permission = Permission::where('name', '=', 'edit bread ' . $formId)->first();
        if (empty($permission)) {
            Permission::create(['name' => 'edit bread ' . $formId]);
        }
        $permission = Permission::where('name', '=', 'add bread ' . $formId)->first();
        if (empty($permission)) {
            Permission::create(['name' => 'add bread ' . $formId]);
        }
        $permission = Permission::where('name', '=', 'delete bread ' . $formId)->first();
        if (empty($permission)) {
            Permission::create(['name' => 'delete bread ' . $formId]);
        }
    }

    public function givePermissions($formId, $request): void
    {
        $this->createPermissions($formId);
        $assign = [];
        $roles = Role::all();
        foreach ($roles as $role) {
            if (isset($request['_role_' . $role->name])) {
                $role->givePermissionTo('browse bread ' . $formId);
                if (isset($request['read'])) {
                    $role->givePermissionTo('read bread ' . $formId);
                }
                if (isset($request['edit'])) {
                    $role->givePermissionTo('edit bread ' . $formId);
                }
                if (isset($request['add'])) {
                    $role->givePermissionTo('add bread ' . $formId);
                }
                if (isset($request['delete'])) {
                    $role->givePermissionTo('delete bread ' . $formId);
                }
            }
        }
    }

    public function revokeAllPermisions($formId, $request): void
    {
        $assign = [];
        $roles = Role::all();
        foreach ($roles as $role) {
            $permission = Permission::where('name', '=', 'browse bread ' . $formId)->first();
            if (!empty($permission)) {
                $permission->removeRole($role);
            }
            $permission = Permission::where('name', '=', 'read bread ' . $formId)->first();
            if (!empty($permission)) {
                $permission->removeRole($role);
            }
            $permission = Permission::where('name', '=', 'edit bread ' . $formId)->first();
            if (!empty($permission)) {
                $permission->removeRole($role);
            }
            $permission = Permission::where('name', '=', 'add bread ' . $formId)->first();
            if (!empty($permission)) {
                $permission->removeRole($role);
            }
            $permission = Permission::where('name', '=', 'delete bread ' . $formId)->first();
            if (!empty($permission)) {
                $permission->removeRole($role);
            }
        }
    }

    public function getFormDataByModel($model)
    {
        $columns = DB::getSchemaBuilder()->getColumnListing($model);

        return $columns;
    }

    /** PRZERZUCIĆ TO DO INNEGO PLIKU */
    public function getFromOptionsStandardInput()
    {
        return [
            [
                'value' => 'checkbox',
                'name' => 'checkbox',
            ],
            [
                'value' => 'color',
                'name' => 'color',
            ],
            [
                'value' => 'date',
                'name' => 'date',
            ],
            [
                'value' => 'datetime-local',
                'name' => 'datetime-local',
            ],
            [
                'value' => 'email',
                'name' => 'email',
            ],
            [
                'value' => 'hidden',
                'name' => 'hidden',
            ],
            [
                'value' => 'month',
                'name' => 'month',
            ],
            [
                'value' => 'number',
                'name' => 'number',
            ],
            [
                'value' => 'password',
                'name' => 'password',
            ],
            [
                'value' => 'radio',
                'name' => 'radio',
            ],
            [
                'value' => 'range',
                'name' => 'range',
            ],
            [
                'value' => 'reset',
                'name' => 'reset',
            ],
            [
                'value' => 'search',
                'name' => 'search',
            ],
            [
                'value' => 'tel',
                'name' => 'tel',
            ],
            [
                'value' => 'text',
                'name' => 'text',
            ],
            [
                'value' => 'time',
                'name' => 'time',
            ],
            [
                'value' => 'url',
                'name' => 'url',
            ],
            [
                'value' => 'week',
                'name' => 'week',
            ],
        ];
    }

    public function getFormOptions()
    {
        $otherOptions = [
            [
                'value' => 'text_area',
                'name' => 'text area',
            ],
            [
                'value' => 'relation_select',
                'name' => 'relation select',
            ],
            [
                'value' => 'relation_radio',
                'name' => 'relation radio',
            ],
            [
                'value' => 'file',
                'name' => 'file',
            ],
            [
                'value' => 'image',
                'name' => 'image',
            ],
        ];

        return array_merge($this->getFromOptionsStandardInput(), $otherOptions);
    }
}
