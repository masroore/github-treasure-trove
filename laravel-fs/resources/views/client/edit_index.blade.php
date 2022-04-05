<div class="content-table">

    <h3>{{ __('Update Clients') }}</h3>

    <div class="content-space">

        {{ Form::open(['id' => 'frmUpdateClient', 'class' => 'validate', 'onsubmit' => 'return false', 'autocomplete' => 'Off']) }}

        <div class="row ocult">
             <div class="col-xs-1 col-sm-1 col-md-1 lo">
                <div class="form-check">
                    {{ Form::radio('check', 1, true, ['class' => 'form-check-input', 'checked'=> 'checked','id'=> 'check1'])}}

                </div>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-4 te-b mb-4">
                <div class="form-group floating-label">
                    {{ Form::number('code_client', 1, ['class' => 'form-control numeric number', 'id'=> 'code_client', 'placeholder' => __('Code Client')])}}
                    {{Form::label('labelcode', __('Code Client'), ['class' => 'title'])}}
                </div>  
            </div>

            <div class="col-xs-1 col-sm-1 col-md-1 lo">
                <div class="form-check">
                    {{ Form::radio('check', 2, false, ['class' => 'form-check-input checkSearch','id'=> 'check2'])}}

                </div>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 te-b te-1">
                <div class="form-group floating-label">
                    {{Form::label('type_documenttlabel', __('Type Document'), ['class' => 'selec2label'])}}
                    {{Form::select('type_document', $type_document ,'', ['id'=>'type_document', 'class'=>'form-control select2', 'placeholder' => __('Select...'), 'disabled' => 'disabled' ])}}
                </div>
            </div>
            <div class="col-xs-7 col-sm-7 col-md-3 te-b">
                <div class="form-group floating-label">
                    {{ Form::number('document','', ['class' => 'form-control number numeric', 'id'=> 'document', 'maxlength'=>'9', 'minlength'=>'8','placeholder' => __('RIF'), 'readonly' => true]) }}
                    {{Form::label('documentlabel', __('RIF'), ['class' => 'title'])}}
                </div> 
            </div>


            <div class="col-xs-1 col-sm-1 col-md-1">  
                {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary', 'id' => 'search']) }}
            </div>                                       

        </div>

        {{ Form::close() }}
    </div>
    <div id="client_bank">
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#check1').on('click', function () {

            $('#code_client').prop('readonly', false);
            $('#type_document').prop("disabled", true);
            $('#document').prop('readonly', true);             
            $("#type_document").val('').trigger('change');
            $("#document").val('');

        });

        $('#check2').on('click', function () {

            $('#code_client').prop('readonly', true);
            $('#document').prop('readonly', true);                
            $('#type_document').prop("disabled", false);
            $("#document").removeAttr("readonly");
            $("#code_client").val('');        

        });

        $('#search').on('click', function () {
				loadingWait()
                $.post("{{route('client_edit.search_client_edit')}}", $('#frmUpdateClient').serialize(), function (response) {
					Swal.close(); 
                    $('#client_bank').html(response);
                }, 'html').fail(function (){ 
                    toastr['error']('{{ __('Your request could not be processed') }}');
                });
        });
        $('#document').on('keypress', function (e) {
            if (e.which == 13) {
                $('#search').click();
            }
        });
    });
</script>
