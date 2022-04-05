<div class="row" id="principal_modal">
	{{ Form::open(['id'=>'lock_users', 'autocomplete'=>'Off', 'class'=>'Validate', "enctype"=>"multipart/form-data"]) }}
	{{ Form::hidden('id', $item['crypt_id'], ['id'=> 'id'])}}
		@if($item->isSuspended()==false)
	    
        <div class="content-space pa-1">

        	<h1>{{__('Block user')}}</h1>

        	<div class="col-7 mx-auto">
           
				{{ Form::button('<i class="fas fa-lock"></i>'.' '.__('Block user'), ['class' => 'btn btn-moderation delete mt-2 mb-4', 'id' => 'block']) }}

			</div>

			<h1>{{__('Suspend user')}}</h1>

            <div id="layOff">
                
				<p class="mt-2 mb-4">{{  __('Select the time range for the suspension') }}  </p>      	
                <div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-6 mb-2">
			            <div class="form-group floating-label">
							{{	Form::text('date_in', date('d/m/Y'), ['id'=>'date_in','class'=>'form-control date_in_before', 'placeholder'=>__('Date Start'), 'required' => 'required' ]) }}
							{{	Form::label('', __('Date Start'), ['class' => 'title'])}}    
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 mb-2">
			            <div class="form-group floating-label">
							{{  Form::text('date_out',  date('d/m/Y'), ['id'=>'date_out','class'=>'form-control date_in_before', 'placeholder'=>__('Date End'), 'required' => 'required']) }}
							{{	Form::label('', __('Date End'), ['class' => 'title'])}}
						</div>
					</div>
				</div>
          
                <div class="col-5 mx-auto">  
	            	{{ Form::button('<i class="fa fa-pause"></i>'.' '.__('Suspend'), ['class' => 'btn btn-moderation delete', 'id' => 'save']) }}
	            </div>
           		  
            </div>

        </div>
	   	@else
	   		<div class="content-space pa-1">
	   			{{ Form::button('<i class="fa fa-pause"></i>'.' '.__('Quitar Suspención'), ['class' => 'btn btn-moderation delete', 'id' => 'suspended', 'onclick'=>"removeSus('".$item['crypt_id']."')"]) }}
	   		</div>
	   	@endif
    {{ Form::close() }}       
</div>
<script type="text/javascript">
	$(document).ready(function (){
        $('.date_in_before').each(function(){
		    $(this).datepicker({
		        format: 'dd/mm/yyyy',
		        autoclose: true,
		        closeOnDateSelect: true,
		        startDate: new Date()
		    });
        });
	    $('#block').on('click', function(value){ 
			$.get("U0001.lock_user/"+ $('#id').val(), function(data){
	            $('#remoteModal').modal('hide');
	            window.location.reload();
				toastr[data.type_message](data.message, data.tittle,
	                    { "progressBar"  : true,
	                      "onclick": null,
	                      "positionClass": "toast-bottom-center"
	                    });
			},'json').fail(function(){
	            toastr.error('{{ __('Your request could not be processed') }}');
	            swal.close();
	        });
		});
		
		$('#save').on('click', function(value){
			params = $('#id').val()+'/'+saveDate($("#date_in").val())+'/'+saveDate($("#date_out").val());
			
	        $.get("U0001.susp_user/"+ params, function(data){
	            toastr[data.type_message](data.message, data.title,{
	                "progressBar": true,
	                "onclick": null,
	                "positionClass": "toast-bottom-center"
	            });
	            window.location.reload();
	        },'json');	        
	    });	
	});
	function removeSus(id){
        $.get("{{url('U0001.removeSus')}}/"+id,function(response){
        	toastr[response.type_message](response.message, response.title,{
	                "progressBar": true,
	                "onclick": null,
	                "positionClass": "toast-bottom-center"
	            });
        	$('#modalBlock').modal('hide');
        	window.location.reload();
        });
    }
	
</script>