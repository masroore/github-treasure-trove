<div class="content-table">
    <h3>{{ __('Banks') }}</h3>
 
        <a href="{{route('banks.create')}}" class="btn btn-primary title new link_ajax" data-dataType="html"> {{__('New')}} </a>

<table class="dataTable table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th scope='col'>{{__('Name Bank')}}</th>
            <th scope='col'>{{__('Code')}}</th>
            <th scope='col'>{{__('Name Fantasy')}}</th>
            <th scope='col'>{{__('Document')}}</th>
            <th scope='col'>{{__('Email')}}</th>
            <th scope='col'>{{__('Phone')}}</th>
            <th scope='col'>{{__('Actions')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bank as $key => $value)
        <tr>
            <td>{{$value['name_bank']}}</td>
            <td>{{$value['code']}}</td>
            <td>{{$value['name_fantasy']}}</td>
            <td>{{$value['document']}}</td>
            <td>{{$value['email']}}</td>
            <td>{{$value['phone']}}</td>
            <td> 
                @if($value->status==1)
                    <a class="btn btn-moderation edit link_ajax" href="{{route('banks.edit',$value->crypt_id)}}" data-dataType="html"><i class="fa fa-pen"></i> {{ __('Edit') }} </a> 
                    @if($value->number_ica!=$restringer)
                        <a class="btn btn-moderation edit link_ajax" href="{{route('banks.icaProcess',$value->crypt_id)}}" data-dataType="html"><i class="fab fa-cc-mastercard"></i> {{ __('Products') }} </a>
                    @endif
                    <a class="btn btn-moderation delete link_ajax" href="{{route('banks.delete',$value->crypt_id)}}" data-dataType="json"><i class="fa fa-trash"></i>{{__('Delete')}}</a>  
                @else
                    <a href="{{route('banks.reactivate', $value->crypt_id )}}" class="btn btn-moderation edit link_ajax" data-dataType="json"><i class="fas fa-history"></i>{{__('Activate')}}</a>  
                @endif 

            </td>               
        </tr>
        @endforeach
    </tbody>
</table>

</div>