<div class="content-table"> 
    <h3>{{ __('POS Adequacy') }}</h3>
    <div class="content-space"> 
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{ __('Masive upload') }}</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">{{ __('Detailed upload') }}</button>
          </div>
        </nav>
        <div id="bodytable">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    {{ Form::open(['route'=>'pos_adaptation.store','id'=>'frmSearch','autocomplete'=>'Off','class' => 'validate' ]) }}
                    <div class="content-space pa-1">
                          <div class="row mb-4">
                            <div class="col-xs-11 col-sm-11 col-md-11 te-1">
                                <div class="form-group floating-label">
                                    {{ Form::text('boxes', null, ['class' => 'form-control', 'min'=>'1','id'=> 'boxes','placeholder'=>__('N° Boxes')]) }}
                                    {!!Form::label('boxes', __('N° Boxes'), ['class' => 'title'])!!}
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 ">
                                {{ Form::button(('<i class="fa fa-search"></i>'), ['class' => 'btn btn-primary style', 'id' => 'masive_searh']) }}
                            </div>
                        </div>

                        <table class="dataTable table" cellspacing="0" width="100%" id="table1">
                            <thead>
                                <tr>
                                    <th scope='col'>{{__('Model')}}</th>
                                    <th scope='col'>{{__('Box Number')}}</th>
                                    <th scope='col'>{{__('Serial')}}</th>
                                    <th scope='col'>{{__('POS Amount')}}</th>
                                    <th scope='col'>{{__('Adecuated')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="col-5 mx-auto">  
                            {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'save_masive', 'type' => 'submit']) }}
                        </div>
                     </div>
                    {{ Form::close() }}
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    {{ Form::open(['route'=>'pos_adaptation.detailed_store','id'=>'frmDStore','autocomplete'=>'Off','class' => 'validate' ]) }}
                        {{ Form::hidden('id', null, ['id'=> 'id'])}}
                         <div class="content-space pa-1">
                           <div class="row">
                                <div class="col-xs-11 col-sm-11 col-md-5 te-1 mb-4">
                                    <div class="form-group floating-label">
                                        {!!Form::label('serial', __('Serial'), ['class' => 'selec2label'])!!}
                                        {{ Form::text('serial', null, ['class' => 'form-control  number required', 'id'=> 'serial','placeholder'=>__('Serial'),'minlength'=>'6','maxlength'=>'10','min' => '1']) }}
                                    </div>
                                </div>
                                <div class="col-md-1 mb-4">
                                    {{ Form::button(('<i class="fa fa-search"></i>'), ['class' => 'btn btn-primary style', 'id' => 'detailed_searh']) }}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                    <div class="form-group floating-label">
                                        {{ Form::text('model', null, ['class' => 'form-control  onlyText', 'id'=> 'model','placeholder'=>__('Model'), 'disabled'=>true]) }}
                                        {!!Form::label('model', __('Model'), ['class' => 'title'])!!}
                                    </div>  
                                </div>                           
                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                    <div class="form-group floating-label">
                                        {{ Form::select('adequacy', [0 => __('No'), 1 =>__('Yes')], 1, ['class' => 'form-select required', 'id'=> 'adequacy', 'disabled'=>true, 'placeholder'=>__('Select...')])}}
                                        {!!Form::label('adequacy', __('Adecuated'), ['class' => 'title'])!!}
                                    </div> 
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                     <div class="form-group floating-label">
                                        {{ Form::text('observations', null, ['class' => 'form-control  alphanum onlyText', 'id'=> 'observations','placeholder'=>__('Observations'), 'maxlength'=>'50', 'disabled'=>true ]) }}
                                        {!!Form::label('observations', __('Observations'), ['class' => 'title'])!!}
                                    </div>
                                </div>
                            </div>
                             <div class="col-5 mx-auto">  
                                {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'save_detailed', 'type' => 'submit']) }}
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var token         = "{{csrf_token()}}";
var cont_boxs     = 0;
$(document).ready(function () {
    $('#masive_searh').on('click',function(){   
        if($('#boxes').val() != ''){        
            $('#table1').dataTable().fnClearTable();
            loadingWait();
            $.get("{{route('pos_adaptation.search')}}/"+$('#boxes').val(),function(data){
                swal.close();
                if(data != ''){
                    for (var i = 0; i < data.length; i++) {

                        let id_box = '<input type="hidden" name="boxes['+cont_boxs+'][id]" value="'+data[i].id+'" />';

                        let row_table = [    
                            data[i].model+id_box,
                            data[i].number_box,
                            data[i].serial_end,
                            data[i].quantity_pos,
                            '<select name="boxes['+cont_boxs+'][adequacy]" class ="form-control required"><option value="1" selected>'+ "{{__('Adecuated')}}" +'</option><option value="0">'+ "{{__('Non-Adecuated')}}" +'</option></select>'
                            ];
                        $('#table1').dataTable().fnAddData(row_table);     
                        cont_boxs++;
                    }
                }else{
                    toastr.info('{{ __('No data Found') }}');
                }
            },'json').fail(function(){
                swal.close();
                toastr.error('{{ __('Your request could not be processed') }}');
            }); 
        }else{
            toastr.error('{{ __('Please write a box number') }}');
        }
     });
    $('#detailed_searh').on('click',function(){
        if($('#serial').val() != '' && $('#id').val() != ''){
            loadingWait();
            $.get("PO006.serial_search/"+$('#id').val(),function(data){
                swal.close();
                if(data.status != 0){
                    var response = data.data;
                    $('#model').val(response.model);
                    $('#adequacy').val(response.adequacy).trigger('change');
                    $('#observations').val(response.observations);
                    $('#adequacy').attr('disabled', false);
                    $('#observations').attr('disabled', false);
                }else{
                    toastr[data.type_message](data.message, data.tittle,
                    { "progressBar"  : true,
                      "onclick": null,
                      "positionClass": "toast-bottom-center"
                    });
                }
            },'json').fail(function(){
                swal.close();
                toastr.error('{{ __('Your request could not be processed') }}');
            });
        }else{
            toastr.info('{{ __('Serial Empty') }}','{{ __('POS Adequacy') }}');
        }
    });
    $('#serial').autocomplete({
        source: function( request, response) {
                    $.ajax({
                        url: "{{route('pos_adaptation.show_serial')}}/"+$('#serial').val(),
                        dataType: "json",
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
        minLength: 3,
        select: function( event, ui ) {
            $('#id').val(ui.item.id);
        }
    });
});
</script>