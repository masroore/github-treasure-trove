<div class="content-table">
    <h3>{{ __('Type Storage') }}</h3>

    @if(Session::has('mensaje'))
    {{Session::get('mensaje')}}
    @endif

    <a href="{{route('typeStore.create')}}" class="btn btn-primary title new link_ajax" data-dataType="html">{{ __('New') }} </a>
    <table class="dataTable table" cellspacing="0" width="100%">   
        <thead >
            <tr>
                <th scope='col'>{{ __('Description')}}</th>
                <th scope='col'>{{ __('Bank')}}</th>
                <th scope='col'>{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($type_storages as $value )
            <tr>
                <td>{{$value['description']}}</td>
                <td>{{$value['bank_name']}}</td>
                <td> 
     
                @if($value['status']== '1')
                    
                    <a href="{{route('typeStore.edit', [$value['crypt_id']])}}" data-dataType="html" class="btn btn-moderation edit link_ajax" >
                        <i class="fa fa-pen"></i> {{__('Edit')}}
                    </a>
                    <a href="{{route('typeStore.change_status', [$value['crypt_id'], 0] )}}" data-dataType="json" class="btn btn-moderation delete link_ajax" >
                    <i class="fa fa-trash"></i> {{__('Delete')}}
                    </a>
                
                 @else
                    <a href="{{route('typeStore.change_status', [$value['crypt_id'], 1] )}}" data-dataType="json" class="btn btn-moderation active link_ajax" >
                    <i class="fas fa-history"></i> {{__('Activate')}}
                    </a>    
                     
                 @endif
                
                </td>  
            </tr>
            @endforeach
        </tbody>  
    </table>
</div>


