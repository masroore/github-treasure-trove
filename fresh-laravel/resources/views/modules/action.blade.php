   @can('edit-module')
       <a href="modules/{{ $module->id }}/edit" data-url="{{ route('modules.edit', $module->id) }}"><i
               class="fa fa-edit"></i>{{__('Edit')}}</a>
       <br>
   @endcan

   @can('delete-module')

       <a href="#" class=" text-danger" data-toggle="tooltip" data-original-title="{{ __('Delete') }}"
           onclick="confirm('{{ __('Are You sure ?') }}')?document.getElementById('delete-form-{{ $module->id }}').submit():'';"><i
               class="fas fa-trash"></i> {{__('Delete')}}</a>
       {!! Form::open(['method' => 'DELETE', 'route' => ['modules.destroy', $module->id], 'id' => 'delete-form-' . $module->id]) !!}
       {!! Form::close() !!}
   @endcan
