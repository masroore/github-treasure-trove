<?php
/*
 * File name: OptionGroupDataTable.php
 * Last modified: 2021.04.12 at 10:19:39
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\DataTables;

use App\Models\CustomField;
use App\Models\OptionGroup;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class OptionGroupDataTable extends DataTable
{
    /**
     * custom fields columns.
     *
     * @var array
     */
    public static $customFields = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query results from query() method
     *
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
        $dataTable = $dataTable
            ->editColumn('name', function ($optionGroup) {
                return $optionGroup->name;
            })
            ->editColumn('updated_at', function ($optionGroup) {
                return getDateColumn($optionGroup, 'updated_at');
            })
            ->editColumn('allow_multiple', function ($optionGroup) {
                return getBooleanColumn($optionGroup, 'allow_multiple');
            })
            ->addColumn('action', 'option_groups.datatables_actions')
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            [
                'data' => 'name',
                'title' => trans('lang.option_group_name'),

            ],
            [
                'data' => 'allow_multiple',
                'title' => trans('lang.option_group_allow_multiple'),

            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.option_group_updated_at'),
                'searchable' => false,
            ],
        ];

        $hasCustomField = in_array(OptionGroup::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', OptionGroup::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.option_group_' . $field->name),
                    'orderable' => false,
                    'searchable' => false,
                ]]);
            }
        }

        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OptionGroup $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
            ->parameters(array_merge(
                config('datatables-buttons.parameters'),
                [
                    'language' => json_decode(
                        file_get_contents(
                            base_path('resources/lang/' . app()->getLocale() . '/datatable.json')
                        ),
                        true
                    ),
                ]
            ));
    }

    /**
     * Export PDF using DOMPDF.
     *
     * @return mixed
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $pdf = PDF::loadView($this->printPreview, compact('data'));

        return $pdf->download($this->filename() . '.pdf');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'option_groupsdatatable_' . time();
    }
}
