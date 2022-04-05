<div class="box-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th style="width: 50%">Код</th>
                {{--<th>Лимит</th>--}}
                {{--<th>Активный</th>--}}
                <th title="Информационное поле. Например, отправлен в рассылке клиенту,...">Выдан/Отправлен</th>
                <th>Использован</th>
                <th>Дейстия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($promoCodes as $code)
                <tr>
{{--                <td>{{ $loop->iteration }}</td>--}}
                    <td>{{ $code->id }}</td>
                    <td>{{ $code->code }}</td>
                    {{--<td>{{ $menu->used_limit }}</td>--}}
                    {{--<td>{{ $menu->active }}</td>--}}
                   <td>
                       @include('admin.fields.field-x-editable', [
                           'value' => $code->transferred,
                           'type' => 'select',
                           'field_name' => 'transferred',
                           'source' => [["value" => "1", "text" => "Выдан"], ["value" => "0", "text" => "Не выдан"]],
                           'pk' => $code->id,
                           'url' => route('admin.sale-promo-codes.editable', $code),
                       ])
                   </td>
                    <td style="text-align: center" title="Использован {{ $code->used_count }} с {!! $code->used_limit > 0 ?: 'безлимитно' !!} возможных">@if($code->used_count)<i class="fa fa-check-square-o"></i>@else<i class="fa fa-square-o"></i>@endif</td>
                    <td>
                        <div class="btn-group">
                            <a href="#"
                               data-method="DELETE"
                               data-confirm="Удалить?"
                               data-url="{{ route('admin.sale-promo-codes.destroy', [$code, 'destination' => \Request::fullUrl()]) }}"
                               class="btn btn-xs btn-danger js-action-click"
                               data-html-container='#promo-codes-table'
                            ><i class="fa fa-remove"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $promoCodes->appends(request()->except('page'))->setPath(route('admin.sales.options', $sale))->links() !!}
    </div>
</div>