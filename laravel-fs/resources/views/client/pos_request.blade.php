<div class="content-table">

    <h3>{{ __('Register POS Request') }}</h3>

    <div class="content-space">

        {{ Form::open(['id' => 'frm1_reg_pos_request', 'class' => 'validate', 'onsubmit' => 'return false', 'autocomplete' => 'Off']) }}
        <div class="row">
            <div class="col-xs-11 col-sm-11 col-md-11 mb-4 te-1">
                <div class="form-group floating-label">
                    {{ Form::text('code_client', null, ['class' => 'form-control numeric number', 'id'=> 'code_client', 'maxlength'=>'5','minlength'=>'5','placeholder' => __('Code Client'), 'required'=>'required'])}}
                    {{Form::label('labelcode', __('Code Client'), ['class' => 'title'])}}
                </div>  
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 mb-4">
                {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary','data-step-valid'=>'#step-1', 'id' => 'search_code_client']) }}
            </div>
        </div>

        <div class="content-table inside content-space" style="display:none" id="ocult">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('document', null, ['class' => 'form-control alphanum', 'id'=> 'document', 'maxlength'=>'9','minlength'=>'9','placeholder' => __('Document'), 'readonly'=>'readonly'])}}
                        {{Form::label('labelcode', __('Document'), ['class' => 'title'])}}
                    </div>  
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('name_client', null, ['class' => 'form-control alphanum', 'id'=> 'name_client', 'maxlength'=>'9','minlength'=>'9','placeholder' => __(''), 'readonly'=>'readonly'])}}
                        {{Form::label('labelcode', __('Name'), ['class' => 'title'])}}
                    </div>  
                </div>
            
                <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                    <div class="form-group floating-label">
                        {{Form::select('model', [0=>'',1 =>'AMP 9000'] ,'', ['id'=>'model', 'class'=>'form-control select2 required', 'placeholder' => __('Select...')])}}
                        {{Form::label('type_account', __('Model'), ['class' => 'selec2label'])}}
                    </div>  
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                    <div class="form-group floating-label">
                        {{Form::select('insurance', [0=>'Si', 1=>'No'] ,'', ['id'=>'insurance', 'class'=>'form-control select2 required', 'placeholder' => __('Select...')])}}
                        {{Form::label('insurance', __('Insurance'), ['class' => 'selec2label'])}}
                    </div>  
                </div> 
                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                    <div class="form-group floating-label">
                        {{Form::select('dual_sim', [0=>'Si', 1=>'No'] ,'', ['id'=>'dual_sim', 'class'=>'form-control select2 required', 'placeholder' => __('Select...')])}}
                        {{Form::label('dual_sim', __('Dual Sim'), ['class' => 'selec2label'])}}
                    </div>   
                </div> 
                <div class="col-xs-1 col-sm-1 col-md-1 mb-4">
                    {{ Form::button('<i class="fa fa-plus-circle"></i>', ['class' => 'btn btn-primary','data-step-valid'=>'#step-1', 'id' => 'add_table']) }}
                </div>   
            </div>
            
                <div class="table-formstep ">
                    <table id="table_ica" class="dataTable">
                        <thead>
                            <tr>
                                <th colspan="2">{{__('Model')}}</th>
                                <th colspan="2">{{__('Insurance')}}</th>
                                <th colspan="2">{{__('Dual Sim')}}</th>
                                <th>{{__('Account')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            
            <div class="col-5 mx-auto"> 
                {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'save1', 'type' => 'submit']) }}
            </div>
        </div>
        {{ Form::close() }}
        
    </div>
</div>

<script>
    $(document).ready(function () {
        $(document).on('click', '#dell', function (event) {
            event.preventDefault();
            $(this).closest('tr').remove();
        });
        $('#add_table').click(function(){
            add_table();
        });
        $('#search_code_client').on('click', function () {
                /*$.post("{{route('client.search_client')}}", $('#frm1_client').serialize(), function (data) {
                    if (data['status'] === 0) {
                        Swal.fire(data['title'], data['message'], data['type_message']);*/
                        $('#ocult').slideDown('fast');
                   /* } else {
                        toastr.info(data.message);
                        $('#ocult').slideUp('fast');
                    }
                }, 'json').fail(function (){ Swal.close(); });*/
        });
    });
    function add_table(){
        var cont_detail=0;
        if($('#model, #insurance, #dual_sim').valid()){
            var model=$('#model').val();
            var insurance=$('#insurance').val();
            var dual_sim=$('#dual_sim').val();
            var amount= '150$';
            var description_model=$('#model > :selected').text();
            var description_dual_sim=$('#dual_sim > :selected').text();
            var description_insurance=$('#insurance > :selected').text();

            var fila='<tr ">'+'<td><input class="form-control text-center" type="hidden" name="detail['+cont_detail+'][model]" value="'+model+'" readonly></td>'+ '<td><input class="form-control text-center" type="text" name="detail['+cont_detail+'][description_model]" value="'+description_model+'" readonly></td>'+'<td><input class="form-control text-center" type="hidden" name="detail['+cont_detail+'][insurance]" value="'+insurance+'" readonly></td>'+ '<td><input class="form-control text-center" type="text" name="detail['+cont_detail+'][description_insurance]" value="'+description_insurance+'" readonly></td>'+'<td><input class="form-control text-center" type="hidden" name="detail['+cont_detail+'][dual_sim]" value="'+dual_sim+'" readonly></td>'+ '<td><input class="form-control text-center" type="text" name="detail['+cont_detail+'][description_dual_sim]" value="'+description_dual_sim+'" readonly></td>'+'<td><input class="form-control text-center" type="button" " name="detail['+cont_detail+'][amount]" value="'+amount+'" readonly></td>'+'<td><a class="btn btn-moderation delete link_ajax" data-dataType="json" id="dell"><i class="fa fa-trash"></i> {{ __('Delete')}} </a></td>'+'</tr>';

            $('#table_ica').append(fila);
            cont_detail++;
            $('#code_ica').val('');
        }
    }
    
</script>


