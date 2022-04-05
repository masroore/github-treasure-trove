<tr>
    <td>{{ $color->id }}</td>
    <td>{{ $color->name }}</td>
    <td><div style="width: 80px; height: 30px; background: {{'#'.$color->color_cod}}" ></div></td>
    <td>{{ $color->markup }}</td>

    <td style="width: 110px">
        <div class="btn-group">
            <a href="{{ route('admin.colors.edit', $color) }}" data-toggle="tooltip" title="Редактировать" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
            <a href="#" data-url="{{ route('admin.colors.destroy', $color) }}" data-destination="{{ request()->fullUrl() }}" data-toggle="tooltip" title="Удалить" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
        </div>
    </td>
</tr>