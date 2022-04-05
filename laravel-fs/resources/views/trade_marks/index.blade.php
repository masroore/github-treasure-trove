<div class="content-table">
    <h3>{{ __('Trade Marks') }}</h3>
    <a class="btn btn-primary title new link_ajax" data-dataType="html" href="{{route('trade_marks.showRegister')}}"> {{ __('New') }} </a>

      <table class="dataTable table" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th scope="col" class="text-center">{{ __('Mark') }}</th>
                  <th scope="col" class="text-center">{{ __('Status') }}</th>
                  <th scope="col" class="text-center">{{ __('Actions') }}</th>
              </tr>
          </thead >
          <tbody id="contenido" class="text-center">
            @foreach($trade_marks as $key => $value)
                  <tr>
                      <td>{{  $value['name_trade_mark']     }}</td>
                      <td>{{  $value['change_status_marks'] }}</td>
                      <td>
                        @if($value['status'] == 1)
                            <a class="btn btn-moderation edit link_ajax" href="{{route('trade_marks.showEdit',$value['crypt_id'])}}" data-dataType="html"><i class="fa fa-pen"></i>{{__('Edit')}}</a>
                            <a class="btn btn-moderation delete link_ajax" href="{{route('trade_marks.change_status_trade_marks',[$value['crypt_id'], 0])}}" data-dataType="json"><i class="fa fa-trash"></i>{{__('Delete')}}</a> 
                        @else
                            <a href="{{route('trade_marks.change_status_trade_marks', [$value['crypt_id'], 1])}}" class="btn btn-moderation active link_ajax" data-dataType="json"><i class="fas fa-history"></i>{{__('Activate')}}</a>   
                       @endif
                      </td>    
                  </tr>
              @endforeach
          </tbody>
      </table>    
</div>


