{{ Form::open(['return'=>null,'id'=>'frmUpdateRegisterPos','autocomplete'=>'Off', "enctype"=>"multipart/form-data", 'class' => 'validate']) }}
<div class="content-table">
    <h3>{{ __('Update Register Pos') }}</h3>
    <div class="content-space"> 
        <div class="content-table inside content-space">      
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-5 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::select('model', $models, null, ['class' => 'form-select required', 'id'=> 'model','placeholder'=>__('Select...')]) }} 
                        {{Form::label('model', __('Models'), ['class' => 'title'])}}
                    </div>
                </div>               
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('num_box', null, ['class' => 'form-control required', 'id'=> 'num_box','placeholder'=>__('N° Box')]) }}
                         {{ Form::label('num_box', __('N° Box'), ['class' => 'title'])}}
                    </div>
                </div>
                 <div class="col-xs-1 col-sm-1 col-md-1 ">
                    {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary', 'id' => 'edit_boxes']) }}
                </div>
            </div>
        </div>
    </div>  
   <table class="dataTable table" cellspacing="0" width="100%" id="table_edit_boxes">
        <thead>
            <tr>
                <th scope='col'>{{__('Model')}}</th>
                <th scope='col'>{{__('N° Box')}}</th>
                <th scope='col'>{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
{{ Form::close() }}

<script type="text/javascript">

$(document).ready(function () {

    $('#edit_boxes').on('click',function(){   
        if($('#frmUpdateRegisterPos').valid()){   
            loadingWait();
			$("#c_all").remove();
            $.post("{{url('PO008.consult_boxes_search')}}", $('#frmUpdateRegisterPos').serialize(),function(response){
            $('#table_edit_boxes').dataTable().fnClearTable();
			if(response.status==1){
				ids = '';
				for (var i = 0; i < response.data.length; i++) {
					ids += '<input type="hidden" class="ids" name="ids[]" value="'+response.data[i].crypt_id+'" />';
					let row_table = [    
						response.data[i].model,
						response.data[i].number_box,                           
						'<a onClick="clearBox(\''+response.data[i].crypt_id+'\', this);" href="#" class="btn btn-moderation delete" title="{{ __('Delete')}}" ><i class="fa fa-trash"></i>{{ __('Delete')}}</a>'
						];
					$('#table_edit_boxes').dataTable().fnAddData(row_table); 					
				}
				
				$("#table_edit_boxes").before(`<div id="c_all" class="d-flex justify-content-end me-4">{{ Form::button('<i class="fa fa-trash"></i>'.__('Clear All Boxes'), ['class' => 'btn btn-moderation delete ', 'id'=>'clearAllBoxes', 'onClick'=>'clearAll()']) }}</div>`);
				$(".ids").remove();
				$("#frmUpdateRegisterPos").append(ids);			 
				
			}
			toastr[response.type_message](response.message);
			
			Swal.close();
            },'json').fail(function(){
				toastr['error']('{{ __('Your request could not be processed') }}');
                
               $("#c_all").remove();

            });   
        }        
    });  
   
});


function clearBox(id, obj){

    Swal.fire({
        title: "{{ __('¿Are you sure you want to Delete this Record?') }}",
        icon: 'question',
        showDenyButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: "{{ __('Yes') }}",
        confirmButtonColor: "var(--color-primary)",
        denyButtonText: "{{ __('No') }}",
        denyButtonColor: "var(--bs-gray)"
    }).then((result) => {
        if (result.isConfirmed) {
			 loadingWait();
			$.get("{{url('PO008.updateRegisterBoxes')}}/"+id,function(data){
				
				tr    =  $(obj).parents('tr').get(); 
				index = $('#table_edit_boxes').DataTable().row( tr ).index();
				$("#table_edit_boxes").DataTable().row(tr).remove().draw();
				toastr['success'](data.message);
				 Swal.close();
			},'json').fail(function(){
				toastr.error('{{ __('Your request could not be processed') }}');
			});
        } else {
            Swal.close();
        }
    });
}

function clearAll(){
    
    Swal.fire({
        title: "{{ __('¿Are you sure you want to delete all these records?') }}",
        icon: 'question',
        showDenyButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: "{{ __('Yes') }}",
        confirmButtonColor: "var(--color-primary)",
        denyButtonText: "{{ __('No') }}",
        denyButtonColor: "var(--bs-gray)"
    }).then((result) => {
        if (result.isConfirmed) {
            loadingWait();
            $.post("{{route('pos_register_edit.clearAll')}}",$("#frmUpdateRegisterPos").serialize(),function(data){
                
                $("#table_edit_boxes").DataTable().clear().draw();
                
                $("#c_all").remove();
                
                 Swal.close();
            },'json').fail(function(){
                toastr.error('{{ __('Your request could not be processed') }}');
            });
        } else {
            Swal.close();
        }
    });
    
     
}


</script>
