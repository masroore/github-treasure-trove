    @can('edit-role')
        <a href="{{ route('roles.edit', $role->id) }}"> <i class="fa fa-edit m-1"></i>{{ __('Edit') }}</a><br>
    @endcan
    @can('show-role')
        <a href="{{ route('roles.show', $role->id) }}"><i class="fas fa-key m-1"></i>{{ __('Show') }}</a><br>
    @endcan
    @can('delete-role')

        <a href="#" class="text-danger" data-toggle="tooltip" data-original-title="{{ __('Delete') }}"
            onclick="confirm('{{ __('Are You sure ?') }}')?document.getElementById('delete-form-{{ $role->id }}').submit():'';"><i
                class="fas fa-trash"></i> {{__('Delete')}}</a>
        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'id' => 'delete-form-' . $role->id]) !!}
        {!! Form::close() !!}
    @endcan
