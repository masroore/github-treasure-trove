<form action="{{ \Request::fullUrl() }}" method="GET">
    <section class="content" style="min-height: inherit">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Фильтр</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Номер</label>
                            <input type="text" name="filter[number]" value="{{ request('filter.number') }}" placeholder="23435" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">

                        @include('admin.fields.field-daterangepicker', [
                            'label' => 'Период оформления',
                            'field_name' => 'range',
                            'field_name_start' => 'filter[ordered_at_from]',
                            'field_name_end' => 'filter[ordered_at_to]',
                            'date_start' => request('filter.ordered_at_from', \Carbon\Carbon::now()->subYear(1)->format('m/d/Y')),
                            'date_end' => request('filter.ordered_at_to', \Carbon\Carbon::now()->format('m/d/Y')),
                            //'show_saved' => true,
                        ])
                    </div>

                </div>



                <div class="row">

                    <div class="col-md-6">
                        @include('admin.fields.field-select2-static', [
                           'label' => 'Статус заказа',
                           'field_name' => 'filter[status]',
                           'attributes' => [null => 'Не указано'] + \App\Models\Taxonomy\Term::byVocabulary('order_statuses')->pluck('name', 'system_name')->toArray(),
                           'selected' => request('filter.status'),
                       ])
                    </div>

                    <div class="col-md-6">
                        @include('admin.fields.field-select2-static', [
                            'label' => 'Статус оплаты заказа',
                            'field_name' => 'filter[payment_status]',
                            'attributes' => [null => 'Не указано'] + \App\Models\Taxonomy\Term::byVocabulary('payment_statuses')->pluck('name', 'system_name')->toArray(),
                            'selected' => request('filter.payment_status'),
                        ])
                    </div>

                </div>
            </div>


            <div class="box-footer">
                <div class="form-buttons pull-right ">
                    <div role="group" class="btn-group">
                        <a href="{{ Request::url() }}" class="btn btn-sm btn-default">Сбросить</a>
                        <button type="submit" class="btn btn-sm btn-success">Применить</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>