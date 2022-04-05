<div class="content-table inside content-space mt-4">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                <div class="form-group floating-label">
                    {{ Form::text('storage_request',$search_request['storage_request_name'], ['readonly'=>'true','class' => 'form-control required', 'id'=> 'storage_request','placeholder' => __('Requesting Department')]) }}
                    {{Form::label('storage_request', __('Requesting Department'), ['class' => 'title'])}}
                </div> 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                <div class="form-group floating-label">
                    {{ Form::text('responsable',$search_request['user_name'], ['readonly'=>'true','class' => 'form-control', 'id'=> 'responsable','placeholder' => __('responsable')]) }}
                    {{Form::label('responsable', __('Responsable'), ['class' => 'title'])}}
                </div> 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                <div class="form-group floating-label">
                    {{ Form::text('date_request',show_full_date($search_request['date_register']), ['readonly'=>'true','class' => 'form-control', 'id'=> 'date_request','placeholder' => __('Date Request')]) }}
                    {{Form::label('date_request', __('Date Request'), ['class' => 'title'])}}
                </div> 
            </div>
        </div>

        <div class="table-formstep noborder mt-4">
            <table class="text-center" id="models">
                <thead>
                    <tr>
                        <th>{{__('Model')}}</th>
                        <th>{{__('Quantity')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($search_request['details'] as $key => $value)
                        <tr>
                            <td >{{$value['model']}}</td>
                            <td >{{$value['quantity']}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tr>
                    <td colspan="3">
                    
                        <a class="btn btn-primary  " target="_blank" href="{{url('PO003.viewPDF').'/'.$SearchNumber}}" > {{ __('Imprent') }} </a>
                    
                    </td>
                </tr>
                        
            </table>
        </div>
</div>
<div class="content-table inside content-space mt-4">
    
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
          @foreach($search_request['pos_shipment'] as $key => $value)

        <button class="nav-link {{ ($key == 0 ? 'active':'') }}" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#model_{{ $key }}" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{ __('Shipment Number ').FullSerial($value['id']) }}</button>
          @endforeach

      </div>
    </nav>
    <div class="bodytable">
        <div class="tab-content" id="nav-tabContent">
        @if(count($search_request['pos_shipment'])===0)
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="note-footer" style="text-align: center; padding: 2rem;">
                    {{__('No Shipping')}}
                </div>
            </div>
        @endif
          @foreach($search_request['pos_shipment'] as $key => $value)          

            <div class="tab-pane fade show {{ ($key == 0 ? 'active':'') }} " id="model_{{ $key }}" role="tabpanel" aria-labelledby="nav-home-tab">
                 <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 mt-4">
                        <div class="form-group floating-label">
                            {{ Form::text('date_send',show_full_date($value['date_register']), ['readonly'=>'true','class' => 'form-control required', 'id'=> 'date_send','placeholder' => __('Date Send')]) }}
                            {{Form::label('date_send', __('Date Send'), ['class' => 'title'])}}
                        </div> 
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 mt-4">
                        <div class="form-group floating-label">
                            {{ Form::text('number_send',FullSerial($value['id']), ['readonly'=>'true','class' => 'form-control', 'id'=> 'number_send','placeholder' => __('Number Send')]) }}
                            {{Form::label('number_send', __('Number Send'), ['class' => 'title'])}}
                        </div> 
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 mt-4">
                        <div class="form-group floating-label">
                            {{ Form::text('responsable',$value['user_name'], ['readonly'=>'true','class' => 'form-control', 'id'=> 'responsable','placeholder' => __('Responsable')]) }}
                            {{Form::label('responsable', __('Responsable'), ['class' => 'title'])}}
                        </div> 
                    </div>
                </div>
                <div class="table-formstep noborder mt-4">
                    <table class="text-center" id="model2">
                        <thead>
                            <tr>
                                <th>{{__('Box')}}</th>
                                <th>{{__('Model')}}</th>
                                <th>{{__('Serial')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($value['detail_shipment'] as $key2 => $value2)
                            <tr>
                                <td >{{$value2->boxes->number_box}}</td>
                                <td >{{$value2->boxes->model}}</td>
                                <td >{{$value2->boxes->serial_end}}</td>
                            </tr>
                        @endforeach
                        </tbody>
    					<tr>
    						<td colspan="3">
    						
    							<a class="btn btn-primary  " target="_blank" href="{{url('PO004.viewPDF').'/'.$value->crypt_id}}" > {{ __('Imprent') }} </a>
    						
    						</td>
    					</tr>
    					
                    </table>
                </div>
				
            </div>
			
			
			
          @endforeach 
		  
		  
        </div>
        {{ Form::hidden('pdf', $search_request['id'],['id'=>'pdf'])}}
               
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#send').on('click',function(){  
        loadingWait();
                $.get("{{url('RQ0002.viewPDF')}}/"+ $('#pdf').val(),function(response){
                    
                },'html');
        swal.close();
        });
    });
</script>