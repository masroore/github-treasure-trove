<div class="content-table">
    <h3>{{ __('Models') }}</h3>

    <a class="btn btn-primary title new link_ajax" data-dataType="html" href="{{route('models.showRegister')}}"> {{ __('New') }} </a>

      <table class="dataTable table" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th scope="col" class="text-center">{{ __('Model') }}</th>
                  <th scope="col" class="text-center">{{ __('Quantity Per Box') }}</th>
                  <th scope="col" class="text-center">{{ __('Price') }}</th>
                  <th scope="col" class="text-center">{{ __('Status') }}</th>
                  <th scope="col" class="text-center">{{ __('Actions') }}</th>
              </tr>
          </thead >
          <tbody id="contenido" class="text-center">
            @foreach($models as $key => $value)
                  <tr>
                      <td>{{  $value['mark'].' '.$value['serial']}}</td>
                      <td>{{  $value['quantity']                 }}</td>
                      <td>{{  '$'.$value['price']                }}</td>
                      <td>{{  $value['change_status_models']     }}</td>
                      <td>
                        @if($value['status'] == 1)
                            <a class="btn btn-moderation edit link_ajax" href="{{route('models.showEdit',$value['crypt_id'])}}" data-dataType="html"><i class="fa fa-pen"></i>{{__('Edit')}}</a>
                            <a class="btn btn-moderation delete link_ajax" href="{{route('models.change_status_models',[$value['crypt_id'], 0])}}" data-dataType="json"><i class="fa fa-trash"></i>{{__('Delete')}}</a> 
                        @else
                            <a href="{{route('models.change_status_models', [$value['crypt_id'], 1])}}" class="btn btn-moderation active link_ajax" data-dataType="json"><i class="fas fa-history"></i>{{__('Activate')}}</a>   
                       @endif
                      </td>    
                  </tr>
              @endforeach
          </tbody>
      </table>    
</div>


