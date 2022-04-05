<div class="content-table">
    <h3>{{ __('Transactions') }}</h3>

    <a href="{{route('transactions.create')}}" class="btn btn-primary title new link_ajax" data-dataType="html">{{ __('New') }}</a>
    
    <table class="dataTable table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th scope='col'>{{__('Coin Type')}}</th>
                <th scope='col'>{{__('Type Transaction')}}</th>
                <th scope='col'>{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($model as $value)
                  <tr>
                      <td>{{$value['type_coin_name']}}</td>
                      <td>{{$value['type_transaction_name']}}</td>
                      <td>
                        @if($value['status'] == 1)
                            <a class="btn btn-moderation edit link_ajax" href="{{route('transactions.edit',$value['crypt_id'])}}" data-dataType="html"><i class="fa fa-pen"></i>{{__('Edit')}}</a>

                            <a class="btn btn-moderation delete link_ajax" href="{{route('transactions.change_status',[$value['crypt_id'], 0])}}" data-dataType="json"><i class="fa fa-trash"></i>{{__('Delete')}}</a> 
                            
                        @else
                            <a href="{{route('transactions.change_status', [$value['crypt_id'], 1])}}" class="btn btn-moderation active link_ajax" data-dataType="json"><i class="fas fa-history"></i>{{__('Activate')}}</a>   
                       @endif
                      </td>    
                  </tr>
              @endforeach
        </tbody>
    </table>
</div>



        