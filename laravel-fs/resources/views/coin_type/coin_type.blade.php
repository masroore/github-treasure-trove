<div class="content-table">
    <h3>{{ __('Coin Type') }}</h3>
    <a class="btn btn-primary title new link_ajax" data-dataType="html" href="{{route('typeCoin.create')}}"> {{ __('New') }} </a>
    <table class="dataTable table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th scope='col'>{{__('Symbol')}}</th>
                <th scope='col'>{{__('Description')}}</th>
                <th scope='col'>{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coin as $key => $value)
                <tr>
                    <td>{{$value['symbol']}}</td>
                    <td>{{$value['name_coin']}}</td>
                        @if($Special_Permission_user)
                        @if($value['status'] == 1)
                        <td> 
                            <a class="btn btn-moderation edit link_ajax" data-dataType="html" href="{{route('typeCoin.edit',$value['crypt_id'])}}"><i class="fa fa-pen"></i> {{ __('Edit') }} </a>
                            <a class="btn btn-moderation delete link_ajax" data-dataType="json" href="{{route('typeCoin.change_status',[$value['crypt_id'], 0])}}"><i class="fa fa-trash"></i> {{ __('Delete') }} </a>
                        </td>            
                        @else
                        <td> 
                            <a class="btn btn-moderation active link_ajax" data-dataType="json" href="{{route('typeCoin.change_status',[$value['crypt_id'], 1])}}"><i class="fas fa-history"></i> {{ __('Activate') }} </a>
                        </td>
                        @endif
                        @else
                         <td> 
                            &nbsp;
                        </td>
                        @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>