<div id="edit_person_n" class="content-space ma-1">    
    <div class="content-table inside ">
       <h3 class="pos mb-2">{{__('Edit Client Person Natural')}} </h3>
            <div class="content-space">          
                <div class="container-form">
                    <div class="container-fluid">
                        <div class="row">
                            {{ Form::open(['route'=>'client.update_person_natural','id'=>'msform','autocomplete'=>'Off','class'=>'validate', 'data-dataType'=>'json']) }}
                            {{ Form::hidden('id', $client['crypt_id'])}}

                            <!-- progressbar -->
                            <ul id="progressbar" class="fourstep">
                                <li class="active current" id="dates" data-target="#fieldset-1"><i class="fas fa-university"></i><strong>{{__('Personal Dates')}}</strong></li>
                                <li id="address" data-target="#fieldset-2"><i class="fas fa-map-marked"></i><strong>{{__('Address')}}</strong></li>
                                <li id="economic_activity" data-target="#fieldset-3"><i class="fas fa-donate"></i><strong>{{__('Economic Activity')}}</strong></li>
                                <li id="miselaneus" data-target="#fieldset-4"><i class="fa fa-user-plus"></i><strong>{{__('Miselaneous')}}</strong></li>
                            </ul>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> <br> 
                            <!-- fieldsets -->
                            <fieldset id="fieldset-1">
                                <div class="form-card" id="step-1">
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">{{__('Person Data')}}</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">{{__('Step 1 - 4')}}</h2>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('document',$client['rif'], ['class' => 'form-control', 'id'=> 'document','placeholder' => __('Document'), 'readonly'=>'readonly']) }}
                                                    {{Form::label('document', __('Document'), ['class' => 'title'])}}
                                                </div>
                                            </div>                                
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('first_name', $client['person']['first_name'], ['class' => 'form-control alpha required', 'id'=> 'first_name','required'=>'required', 'placeholder' => __('First Name')]) }}
                                                    {{Form::label('first_name', __('First Name'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label"> 
                                                    {{ Form::text('last_name',$client['person']['second_name'], ['class' => 'form-control alpha required', 'id'=> 'last_name','required'=>'required', 'placeholder' => __('Second Name')]) }}
                                                    {{Form::label('last_name', __('Second Name'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('first_surname', $client['person']['first_surname'], ['class' => 'form-control alpha required', 'id'=> 'first_surname','required'=>'required', 'placeholder' => __('First Surname')]) }}
                                                    {{Form::label('first_surname', __('First Surname'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('last_surname', $client['person']['second_surname'], ['class' => 'form-control alpha required', 'id'=> 'last_surname','required'=>'required', 'placeholder' => __('Second Surname')]) }}
                                                    {{Form::label('last_surname', __('Second Surname'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{  Form::text('month', $client['person']['expiration_month'], ['id'=>'month','class'=>'form-control required month','required'=>'required', 'placeholder' => __('Ced month ven'), 'readonly'=>'readonly']) }}
                                                    {{Form::label('month', __('Ced month ven'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{  Form::text('year',$client['person']['expiration_year'], ['id'=>'year','class'=>'form-control required year', 'required'=>'required', 'placeholder' => __('Ced year ven'), 'readonly'=>'readonly' ]) }}
                                                    {{Form::label('year', __('Ced year ven'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                <div class="form-group floating-label">
                                                    {{  Form::text('date_birth',show_date($client['person']['date_birth']), ['id'=>'date_birth','class'=>'form-control required date_in', 'required'=>'required', 'placeholder' => __('Date Birth'), 'readonly'=>'readonly' ]) }}
                                                    {{Form::label('date_birth', __('Date Birth'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('nationality', __('Nationality'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('nationality', $nationality , $client['person']['nationality_id'],  ['class' => 'form-control select2 required', 'id'=> 'nationality', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('gender', __('Gender'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('gender', $gender ,$client['person']['gender_id'],  ['class' => 'form-control select2 required', 'id'=> 'gender', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('telephone_operators', __('Local Operator house'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('telephone_operators_house', $defaultCodeOperatorCellHouseCountries , $client['person']['telephone_house_operator_id'],  ['class' => 'form-control select2 required', 'id'=> 'telephone_operators_house', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('phone_house',$client['person']['phone_house'], ['class' => 'form-control numeric number required', 'id'=> 'phone_house', 'required'=>'required', 'maxlength'=>'7', 'placeholder' => __('Phone Number')])}}
                                                    {{Form::label('phone_house', __('Phone Number'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('telephone_operators', __('Local Operator cell'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('telephone_operators_cell', $defaultCodeOperatorCellPhoneCountries , $client['person']['telephone_cell_operator_id'],  ['class' => 'form-control select2 required', 'id'=> 'telephone_operators_cell', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('phone_cell', $client['person']['phone_cell'], ['class' => 'form-control numeric number required', 'id'=> 'phone_cell', 'required'=>'required', 'maxlength'=>'7', 'placeholder' =>__('Phone Number')])}}
                                                    {{Form::label('phone_cell', __('Phone Number'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::email('email', $client['person']['email'], ['class' => 'form-control email required', 'id'=> 'email','required'=>'required', 'placeholder' => __('Email')]) }} 
                                                    {{Form::label('email', __('Email'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                        </div>  
                                    </div>    
                                </div> 
                                {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-2']) }}
                            </fieldset>
                            <fieldset id="fieldset-2">
                                <div class="form-card" id="step-2">
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">{{__('Address')}}</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">{{__('Step 2 - 4')}}</h2>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">                                                 
                                                    {{Form::label('country', __('Country'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('country', $country , $client['client_address']['country_id'],  ['class' => 'form-control select2 required', 'id'=> 'country', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('state', __('State'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('state', $defaultStateFromCountry, $client['client_address']['state_id'],   [ 'class' => 'form-control select2 required ', 'id'=> 'state', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('municipality', __('Municipality'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('municipality', $municipality ,$client['client_address']['municipality_id'],  ['class' => 'form-control select2 required', 'id'=> 'municipality', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('city', __('City'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('city', $city ,$client['client_address']['city_id'],  ['class' => 'form-control select2 required', 'id'=> 'city', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('postal_code', __('Postal Code'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('postal_code', $postal_code , $client['client_address']['postal_code_id'],  ['class' => 'form-control select2 required', 'id'=> 'postal_code', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('edif_qta_torre', $client['client_address']['edf_qta_tow'], ['class' => 'form-control required', 'id'=> 'edif_qta_torre', 'maxlength'=>'200','required'=>'required', 'placeholder' => __('Edif/Qta/Torre')])}}
                                                    {{Form::label('edif_qta_torre', __('Edif/Qta/Torre'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('nro_floor', $client['client_address']['nro_floor'], ['class' => 'form-control required', 'id'=> 'nro_floor', 'maxlength'=>'80','required'=>'required', 'placeholder' => __('Floor')])}}
                                                    {{Form::label('nro_floor', __('Floor'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('apto_offic_loc_casa', $client['client_address']['apto_offic_loc_house'], ['class' => 'form-control required', 'id'=> 'apto_offic_loc_casa', 'maxlength'=>'80', 'required'=>'required','placeholder' => __('apto/offic/loc/casa')])}}
                                                    {{Form::label('apto_offic_loc_casa', __('apto/offic/loc/casa'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('urbanization', $client['client_address']['urbanization'], ['class' => 'form-control  required', 'id'=> 'urbanization', 'maxlength'=>'80','required'=>'required','placeholder' => __('Urbanization')])}}
                                                    {{Form::label('urbanization', __('Urbanization'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('reference', $client['client_address']['reference_point'], ['class' => 'form-control required', 'id'=> 'reference', 'maxlength'=>'255','required'=>'required', 'placeholder' => __('Reference')])}}
                                                    {{Form::label('reference', __('Reference'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-3']) }}
                                {{ Form::button(__('Previous'), ['class' => 'previous-step  btn btn-secondary back', 'data-step'=>'#fieldset-1'])}}
                            </fieldset>
                            <fieldset id="fieldset-3">
                                <div class="form-card" id="step-3">  
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">{{__('Economic Activity')}}</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">{{__('Step 3 - 4')}}</h2>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('economic_sector', __('Economic Sector'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('economic_sector', $economic_sector , $client['economic_activity']['economic_sector_id'],  ['class' => 'form-control select2 required', 'id'=> 'economic_sector', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('economic_activity', __('Economic Activity'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('economic_activity', $activity , $client['economic_activity']['activity_id'],  ['class' => 'form-control select2 required', 'id'=> 'economic_activity', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('modality', __('Modality'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('modality', $modality ,  $client['economic_activity']['modality_id'],  ['class' => 'form-control select2 required', 'id'=> 'modality', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('product', __('Product'), ['class' => 'selec2label'])}}
                                                    {{Form::select('product', $product , $client['economic_activity']['product_id'],  ['class' => 'form-control select2 required', 'id'=> 'product', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                        </div>  
                                    </div>    
                                </div> 
                                {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-4']) }}
                                {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-2'])}}
                            </fieldset>
                            <fieldset id="fieldset-4">
                                <div class="form-card" id="step-4">
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">{{__('Miselaneous')}}</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">{{__('Step 4 - 4')}}</h2>
                                            </div>
                                           @foreach($client['miscellaneous'] as $value)
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text($value['name_social'],  $value['name_miscelaneous']  , ['class' => 'form-control','maxlength'=>'80', 'id' => $value['name_social'],'placeholder' => $value['name_social']  ]) }}
                                                        {{Form::label('social', $value['name_social'] , ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>  
                                    </div>    
                                </div> 
                                {{ Form::button(__('Save'), ['class' => 'btn btn-primary save','data-step-valid'=>'#step-4', 'id' => 'saveNatural', 'type' => 'submit']) }}
                                {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-3'])}}
                            </fieldset>

                        {{ Form::close() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function (){
        applyFormats();
        ajaxForm("#edit_person_n");
        $("#state").on('change', function (){
            $.get('{{url("get_dependents")}}/'+this.value, function (response){
                for(i in response){
                    $("#"+i).children().not('[value=""]').remove();
                    children = "";
                    for(j in response[i]){
                        children += '<option value="'+j+'">'+response[i][j]+'</option>';        
                    }
                    $("#"+i).append(children);
                }
            }, 'json');
        });
    });
</script>
