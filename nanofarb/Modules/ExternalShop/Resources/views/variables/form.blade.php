<div class="row">
    <div class="col-md-6">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Выгрузка товаров</h3>
            </div>
            <form action="{{ route('admin.variable.save') }}" method="POST">
                <div class="box-body">
                    @csrf
                    <input type="hidden" name="destination" value="{{ Request::fullUrl() }}">

                    <div class="form-group">
                        <label for="vars.externalshop_export_name">Короткое название магазина</label>
                        <input type="text" class="form-control" name="vars[externalshop_export_name]" value="{{ variable('externalshop_export_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="vars.externalshop_export_company_name">Полное наименование компании</label>
                        <input type="text" class="form-control" name="vars[externalshop_export_company_name]" value="{{ variable('externalshop_export_company_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="vars.externalshop_export_url">URL главной страницы</label>
                        <input type="url" class="form-control" name="vars[externalshop_export_url]" value="{{ variable('externalshop_export_url') }}">
                    </div>
                    <div class="form-group">
                        <label for="vars.externalshop_export_platform">Система управления контентом</label>
                        <input type="text" class="form-control" name="vars[externalshop_export_platform]" value="{{ variable('externalshop_export_platform') }}">
                    </div>
{{--
                    @include('admin.fields.field-select2-static', [
                         'label' => 'Атрибут, значения которого, использовать для бренда/производителя товара',
                         'field_name' => 'vars[externalshop_export_vendor_attribute]',
                         'multiple' => 0,
                         'attributes' => \App\Models\Shop\Attribute::all()->pluck('name', 'id')->toArray(),
                         'selected' => variable('externalshop_export_vendor_attribute'),
                         'empty_value' => '--не указано--',
                     ])
--}}

                    @include('admin.fields.field-checkbox', [
                         'label' => 'Использовать старые цены и акционные цены',
                         'field_name' => 'vars[externalshop_use_promo_old_price]',
                         'status' => variable('externalshop_use_promo_old_price'),
                     ])

                    @include('admin.fields.field-links', [
                       'label' => 'Дополнительные статические атрибуты товаров',
                       'field_name' => 'vars_json[externalshop_export_attributes_values]',
                       'key_key' => 'key',
                       'key_value' => 'value',
                       'placeholder_key' => 'Атрибут',
                       'placeholder_value' => 'Значение',
                       'items' => json_decode(variable('externalshop_export_attributes_values', '[]'), true),
                    ])

                    <hr>
                    <div class="form-group">
                        <label for="vars.externalshop_export_cache_minute">Время кеширования данных, мин.</label>
                        <input type="number" class="form-control" name="vars[externalshop_export_cache_minute]" value="{{ variable('externalshop_export_cache_minute', 0) }}">
                    </div>
                    <p>XML: <a href="{{ route('externalshop.export.index') }}" target="_blank">{{ route('externalshop.export.index') }}</a></p>
                </div>
                <div class="box-footer">
                    @include('admin.fields.field-form-buttons')
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Получение заказов</h3>
            </div>
            <form action="{{ route('admin.variable.save') }}" method="POST">
                <div class="box-body">
                    @csrf
                    <input type="hidden" name="destination" value="{{ Request::fullUrl() }}">

                    <h4 class="info-title">Rozetka.ua:</h4>
                    <div class="form-group">
                        <label for="vars.xml_vendor">Username</label>
                        <input type="text" class="form-control" name="vars[externalshop_rozetka_username]" value="{{ variable('externalshop_rozetka_username') }}">
                    </div>
                    <div class="form-group">
                        <label for="vars.xml_vendor">Password</label>
                        <input type="text" class="form-control" name="vars[externalshop_rozetka_password]" value="{{ variable('externalshop_rozetka_password') }}">
                    </div>

                    @include('admin.fields.field-select2-static', [
                         'label' => 'Расписание',
                         'field_name' => 'vars[externalshop_rozetka_import_cron]',
                         'attributes' => config('externalshop.cron_schedule_expression', []),
                         'empty_value' => 'Отключено',
                         'selected' => variable('externalshop_rozetka_import_cron'),
                     ])

                    <hr>
                    <h4 class="info-title">Prom.ua:</h4>
                    <div class="form-group">
                        <label for="vars.xml_vendor">API token</label>
                        <input type="text" class="form-control" name="vars[externalshop_prom_token]" value="{{ variable('externalshop_prom_token') }}">
                    </div>

                    @include('admin.fields.field-select2-static', [
                         'label' => 'Расписание',
                         'field_name' => 'vars[externalshop_prom_import_cron]',
                         'attributes' => config('externalshop.cron_schedule_expression', []),
                         'empty_value' => 'Отключено',
                         'selected' => variable('externalshop_prom_import_cron'),
                     ])

                    <hr>
                    @include('admin.fields.field-checkbox', [
                          'label' => 'Отправлять Email уведомление продавцу при новом заказе',
                          'field_name' => 'vars[externalshop_send_seller_email]',
                          'status' => variable('externalshop_send_seller_email'),
                      ])
                </div>
                <div class="box-footer">
                    @include('admin.fields.field-form-buttons')
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .info-title {
            background: #00c0ef;
            padding: 5px;
            color: white;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
        }
    </style>
@endpush