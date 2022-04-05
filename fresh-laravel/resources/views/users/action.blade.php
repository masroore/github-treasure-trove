
@can('edit-user')

    <a  href="users/{{ $user->id }}/edit" data-url="{{ route('users.edit', $user->id) }}"><i
            class="fa fa-edit"></i>{{__('Edit')}}</a><br>
@endcan


@can('delete-user')

    <a href="#" class="text-danger" data-toggle="tooltip" data-original-title="{{ __('Delete') }}"
        onclick="confirm('{{ __('Are You sure ?') }}')?document.getElementById('delete-form-{{ $user->id }}').submit():'';"><i
            class="fas fa-trash"></i> {{__('Delete')}}</a>
    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'id' => 'delete-form-' . $user->id]) !!}
    {!! Form::close() !!}
@endcan

