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
                    @include('admin.fields.field-select2-static', [
                           'label' => 'Тип акции',
                           'field_name' => 'filter[type]',
                           'attributes' => [null => 'Не указано'] + \App\Models\Shop\Sale::$types,
                           'selected' => request('filter.type'),
                       ])
                </div>
                <div class="col-md-6">
                    {{--
                    @include('admin.fields.field-daterangepicker', [
                        'label' => 'Период создания',
                        'field_name' => 'range',
                        'field_name_start' => 'filter[created_at_from]',
                        'field_name_end' => 'filter[created_at_to]',
                        'date_start' => request('filter.created_at_from', \Carbon\Carbon::now()->subDay(30)->format('m/d/Y')),
                        'date_end' => request('filter.created_at_to', \Carbon\Carbon::now()->format('m/d/Y')),
                        //'show_saved' => true,
                    ])
--}}
                    @include('admin.fields.field-daterangepicker', [
                        'label' => 'Период проведения',
                        'field_name' => 'range',
                        'field_name_start' => 'filter[start_at_from]',
                        'field_name_end' => 'filter[end_at_to]',
                        'date_start' => request('filter.start_at_from', \Carbon\Carbon::now()->subDay(30)->format('m/d/Y')),
                        'date_end' => request('filter.end_at_to', \Carbon\Carbon::now()->format('m/d/Y')),
                        //'show_saved' => true,
                    ])
                </div>
            </div>



            <div class="row">

                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('filter.publish') ? 'has-error' : ''}}">
                        {!! Form::label('filter[publish]', 'Статус публикации', ['class' => 'control-label',]) !!}
                        {!! Form::select('filter[publish]', [null => 'Не указано', 1 => 'Опубликовано', 0 => 'Не опубликовано',], request('filter.publish'), ['class' => 'form-control select2', 'data-minimum-results-for-search' => '-1']) !!}
                        {!! $errors->first('filter.publish', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ключовая фраза имени</label>
                        <input type="text" name="filter[name]" value="{{ request('filter.name') }}" placeholder="красный" class="form-control">
                    </div>
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