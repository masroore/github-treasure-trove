<div class="content-table">
    <h3>{{ __('Agencies') }}</h3>
    {{ link_to_route('agency.create', $title = __('New'), $parameters = [], $attributes = ['class'=>'btn btn-primary title new link_ajax', 'data-dataType'=>'html'])}}
      <table class="dataTable table" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th scope="col" class="text-center">{{ __('Code') }}</th>
                  <th scope="col" class="text-center">{{ __('Agency') }}</th>
                  <th scope="col" class="text-center">{{ __('Phone') }}</th>
                  <th scope="col" class="text-center">{{ __('Email') }}</th>
                  <th scope="col" class="text-center">{{ __('Bank') }}</th>
                  <th scope="col" class="text-center">{{ __('Actions') }}</th>
              </tr>
          </thead >
          <tbody id="contenido" class="text-center">
              @foreach($storages as $agency)
                  <tr>
                      <td>{{  $agency->code }}</td>
                      <td>{{  $agency->name_storage }}</td>
                      <td>{{  $agency->phone }}</td>
                      <td>{{  $agency->email }}</td>
                      <td>{{  $agency->bank_name }}</td>
                      <td>
                            @if($agency->status==1)
                                <a class="btn btn-moderation edit link_ajax" href="{{route('agency.edit',$agency->crypt_id)}}" data-dataType="html"><i class="fa fa-pen"></i>{{__('Edit')}}</a>
                                <a class="btn btn-moderation delete link_ajax" href="{{route('agency.change_status',[$agency->crypt_id , 0])}}" data-dataType="json"><i class="fa fa-trash"></i>{{__('Delete')}}</a> 
                            @else
                                <a href="{{route('agency.change_status', [$agency->crypt_id , 1])}}" class="btn btn-moderation edit link_ajax" data-dataType="json"><i class="fas fa-history"></i>{{__('Activate')}}</a>   
                           @endif
                        </div>
                      </td>    
                  </tr>
              @endforeach
          </tbody>
      </table>    
      <div class="d-grid gap-2 d-md-flex justify-content">
      </div>
</div>


