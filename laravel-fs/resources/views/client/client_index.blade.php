<div class="content-table">

    <h3>{{ __('Client') }}</h3>

    <div class="content-space">

        {{ Form::open(['id' => 'frm1_client', 'class' => 'validate', 'onsubmit' => 'return false', 'autocomplete' => 'Off']) }}

        <div class="row mb-3">

            <div class="col-xs-12 col-sm-12 col-md-3 te-1">

                <div class="form-group floating-label">

                    {{Form::label('documentlabe', __('Document Type'), ['class' => 'selec2label'])}}

                    {{Form::select('type_document', $type_document , null, ['id'=>'type_document', 'class'=>'form-control select2 required', 'placeholder' => __('Select...'), 'required'=>'required' ])}}

                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-8 te-1">

                <div class="form-group floating-label">

                    {{ Form::text('document','', ['class' => 'form-control number numeric required', 'id'=> 'document', 'maxlength'=>'9', 'minlength'=>'8','placeholder' => __('RIF'), 'required'=>'required']) }}
                    {{Form::label('documentl', __('RIF'), ['class' => 'title'])}}

                </div> 

            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">  
                    {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary', 'id' => 'search']) }}
                </div>

        </div>



        <div style="display:none" id="ocult" class=" content-table inside content-space">





            <div class="row mb-4">

                <div class="col-xs-12 col-sm-12 col-md-6">

                    <div class="form-group floating-label">

                        {{Form::label('operativel', __('Operative'), ['class' => 'selec2label'])}}
                        {{Form::select('operative', $operative , 1, ['id'=>'operative', 'class'=>'form-control select2 required' ,'placeholder' =>__('Select...'), 'required'=>'required'])}}

                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6">

                    <div class="form-group floating-label">

                        {{Form::label('operativel', __('Storage'), ['class' => 'selec2label'])}}
                        {{Form::select('storage', $storage , Auth::user()->storage_id, ['id'=>'storage', 'class'=>'form-control select2 required' ,'placeholder' => __('Select...'), 'required'=>'required'])}}

                    </div>

                </div>

            </div>



            <div class="col-5 mx-auto"> 

                {{ Form::button(__('Next'), ['class' => 'btn btn-primary next', 'id' => 'submit','onClick'=>'netx()']) }}

            </div>



        </div>


        {{ Form::close() }}
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#search').on('click', function () {
            if ($('#type_document, #document').valid()) {
				loadingWait()
                $.post("{{route('client.search_client')}}", $('#frm1_client').serialize(), function (data) {
					Swal.close(); 
                    if (data['status'] === 0) {
                        Swal.fire(data['title'], data['message'], data['type_message']);
                        $('#ocult').slideUp('fast');
                    } else {
						toastr.info(data.message);
                        $('#ocult').slideDown('fast');
                    }
                }, 'json').fail(function (){ Swal.close(); });
            }
        });
        $('#document').on('keypress', function (e) {
            if (e.which == 13) {
                $('#search').click();
            }
        });
    });
    function netx() {
        if ($('#frm1_client').valid()) {
			loadingWait();
            $.post("{{route('client.decision')}}", $('#frm1_client').serialize(), function (data) {
                if (data['status'] == 1) {
					Swal.close();
                    sendAjax(data['redirect']);
                }
            }, 'json');
        }
    }
</script>
