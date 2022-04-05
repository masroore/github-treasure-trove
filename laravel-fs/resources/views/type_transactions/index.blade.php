<div class="content-table">
    <h3>{{ __('Type Transation') }}</h3>
    <a class="btn btn-primary title new link_ajax" data-dataType="html" href="{{route('type_transactions.create')}}"> {{ __('New') }} </a>
      <table class="dataTable table" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th scope="col" class="text-center">{{ __('Description') }}</th>
                  <th scope="col" class="text-center">{{ __('Actions') }}</th>
              </tr>
          </thead >
          <tbody id="contenido" class="text-center">
            @foreach($model as $value)
                  <tr>
                      <td>{{$value['name_transaction']}}</td>
                      <td>
                        @if($value['status'] == 1)
                            <a class="btn btn-moderation edit link_ajax" href="{{route('type_transactions.edit',$value['crypt_id'])}}" data-dataType="html"><i class="fa fa-pen"></i>{{__('Edit')}}</a>

                            <a class="btn btn-moderation delete link_ajax" href="{{route('type_transactions.change_status',[$value['crypt_id'], 0])}}" data-dataType="json"><i class="fa fa-trash"></i>{{__('Delete')}}</a> 
                            
                        @else
                            <a href="{{route('type_transactions.change_status', [$value['crypt_id'], 1])}}" class="btn btn-moderation active link_ajax" data-dataType="json"><i class="fas fa-history"></i>{{__('Activate')}}</a>   
                       @endif
                      </td>    
                  </tr>
              @endforeach
          </tbody>
      </table>    
</div>


