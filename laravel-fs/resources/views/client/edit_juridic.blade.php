<div  id="edit_person_j" class="content-space ma-1">    
    <div class="content-table inside ">
       <h3 class="pos mb-2">{{__('Edit Client Person Juridic')}} </h3>
            <div class="content-space">          
                <div class="container-form">
                    <div class="container-fluid">
                        <div class="row">
                            {{ Form::open(['route'=>'client.update_person_juridic','id'=>'msform','autocomplete'=>'Off','class'=>'validate', 'data-dataType'=>'json']) }}
                            {{ Form::hidden('id', $client['crypt_id'])}}

                                <!-- progressbar -->
                                <ul id="progressbar" class="fivestep">
                                    <li class="active current" id="date" data-target="#fieldset-1"><i class="fas fa-address-card"></i><strong>{{__('Commercial Dates')}}</strong></li>
                                    <li id="address" data-target="#fieldset-2"><i class="fas fa-map-marked"></i><strong>{{__('Address')}}</strong></li>
                                    <li id="legal" data-target="#fieldset-3"><i class="fas fa-id-badge"></i><strong>{{__('Legal Representative')}}</strong></li>
                                    <li id="commerce" data-target="#fieldset-4"><i class="fas fa-male"></i><strong>{{__('Commerce Representative')}}</strong></li>
                                    <li id="activity" data-target="#fieldset-5"><i class="fas fa-donate"></i><strong>{{__('Economic Activity')}}</strong></li>
                                    <li id="miselaneus" data-target="#fieldset-6"><i class="fas fa-user-plus"></i><strong>{{__('Miselaneous')}}</strong></li>
                                </ul>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> <br> 
                                <!-- fieldsets -->
                                <fieldset id="fieldset-1">
                                    <div class="form-card" id="step-one">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{__('Commercial Dates')}}</h2>
                                                </div>                                                
                                                <div class="col-5">
                                                    <h2 class="steps">{{__('Step 1 - 6')}}</h2>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('document_des',$client['rif'] , ['readonly'=>'readonly', 'class' => 'form-control', 'id'=> 'document_des', 'maxlength'=>'12', 'placeholder'=> __('Document')]) }}
                                                        {{Form::label('document_des', __('Document'), ['class' => 'title'])}}
                                                    </div>
                                                </div>     
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('business_name', $client['get_commerce']['business_name'], ['class' => 'form-control alphanum required', 'id'=> 'business_name','required'=>'required', 'placeholder'=> __('Business Name')]) }}
                                                        {{Form::label('business_name', __('Business Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('trade_name', $client['get_commerce']['trade_name'], ['class' => 'form-control alphanum required', 'id'=> 'trade_name', 'maxlength'=>'255','required'=>'required', 'placeholder'=> __('Fantasy Name')]) }}
                                                        {{Form::label('trade_name', __('Fantasy Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('telephone_operators', __('Local Operator'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('telephone_operators',$defaultCodeOperatorCountries , $client['get_commerce']['telephone_operator_id'],  ['class' => 'form-control select2 required', 'id'=> 'telephone_operators', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('phone', $client['get_commerce']['phone'], ['class' => 'form-control numeric number required', 'id'=> 'phone', 'required'=>'required', 'maxlength'=>'7','placeholder' => __('Phone Number')])}}
                                                        {{Form::label('phone', __('Phone Number'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::email('email', $client['get_commerce']['email'], ['class' => 'form-control email required', 'id'=> 'email','required'=>'required', 'placeholder' => __('Email')]) }} 
                                                        {{Form::label('email', __('Email'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('franchises', __('franchise'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('franchises', $franchise , $client['get_commerce']['franchise_id'],  ['class' => 'form-control select2 ', 'id'=> 'franchises', 'placeholder' => __('Select...')]) }}
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>    
                                    </div> 
                                    {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-2']) }}
                                </fieldset>
                                <fieldset  id="fieldset-2">
                                    <div class="form-card" id="step-two">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{__('Address')}}</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{__('Step 2 - 6')}}</h2>
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
                                                        {{ Form::select('state', $defaultStateFromCountry ,$client['client_address']['state_id'],  ['class' => 'form-control select2 required', 'id'=> 'state', 'placeholder' => __('Select...'),'required'=>'required']) }}
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
                                                        {{ Form::text('edif_qta_torre', $client['client_address']['edf_qta_tow'], ['class' => 'form-control required', 'id'=> 'edif_qta_torre', 'required'=>'required', 'placeholder' => __('Edif/Qta/Torre')])}}
                                                        {{Form::label('edif_qta_torre', __('Edif/Qta/Torre'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('nro_floor', $client['client_address']['nro_floor'], ['class' => 'form-control  required', 'id'=> 'nro_floor', 'required'=>'required', 'placeholder' => __('Floor')])}}
                                                        {{Form::label('nro_floor', __('Floor'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('apto_offic_loc_casa', $client['client_address']['apto_offic_loc_house'], ['class' => 'form-control required', 'id'=> 'apto_offic_loc_casa','required'=>'required', 'placeholder' => __('apto/offic/loc/casa')])}}
                                                        {{Form::label('apto_offic_loc_casa', __('apto/offic/loc/casa'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('urbanization', $client['client_address']['urbanization'], ['class' => 'form-control required', 'id'=> 'urbanization','required'=>'required', 'placeholder' =>__('Urbanization')])}}
                                                        {{Form::label('urbanization', __('Urbanization'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('reference', $client['client_address']['reference_point'], ['class' => 'form-control required', 'id'=> 'reference','required'=>'required',  'placeholder' =>__('Reference')])}}
                                                         {{Form::label('reference', __('Reference'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-3']) }}
                                    {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-1'])}}
                                </fieldset>
                                <fieldset id="fieldset-3">
                                    <div class="form-card" id="step-three">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{__('Legal Representative')}}</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{__('Step 3 - 6')}}</h2>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">

                                                    <div class="form-group floating-label">
                                                        {{Form::label('documentlabel', __('Tipo de documento'), ['class' => 'selec2label'])}}
                                                        {{Form::select('type_document_legal', $type_document , $client['client_representative_legal']['representative']['type_document_id'], ['id'=>'type_document_legal', 'class'=>'form-control select2 required', 'placeholder' =>  __('Select...')])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-8 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('document_legal',$client['client_representative_legal']['representative']['document'], ['class' => 'form-control required', 'id'=> 'document_legal', 'required'=>'required', 'maxlength'=>'9', 'placeholder' => __('RIF')]) }}
                                                         {{Form::label('documentlegal', __('RIF'), ['class' => 'title'])}} 
                                                    </div>   
                                                </div>
                                                <div class="col-xs-1 col-sm-1 col-md-1 mb-4">
                                                    {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary ', 'id' => 'search_representative_legal']) }}
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('first_name_legal', $client['client_representative_legal']['representative']['first_name'], ['class' => 'form-control alpha required', 'id'=> 'first_name_legal','required'=>'required', 'placeholder' => __('First Name')]) }}
                                                        {{Form::label('first_name_legal', __('First Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('second_name_legal', $client['client_representative_legal']['representative']['second_name'], ['class' => 'form-control alpha required', 'id'=> 'second_name_legal','required'=>'required', 'placeholder' => __('Second Name')]) }}
                                                        {{Form::label('second_name_legal', __('Second Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('first_surname_legal', $client['client_representative_legal']['representative']['first_surname'], ['class' => 'form-control alpha  required', 'id'=> 'first_surname_legal','required'=>'required', 'placeholder' => __('First Surname')]) }}
                                                        {{Form::label('first_surname_legal', __('First Surname'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('second_surname_legal', $client['client_representative_legal']['representative']['second_surname'], ['class' => 'form-control alpha required', 'id'=> 'second_surname_legal','required'=>'required', 'placeholder' => __('Second Surname') ]) }}
                                                        {{Form::label('second_surname_legal', __('Second Surname'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('date_birth_legal', show_date($client['client_representative_legal']['representative']['date_birth']), ['class' => 'form-control date_in required', 'id'=> 'date_birth_legal','required'=>'required', 'placeholder' => __('Date Birth')]) }}
                                                         {{Form::label('date_birth_legal', __('Date Birth'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('month_legal', $client['client_representative_legal']['representative']['expiration_month'], ['class' => 'form-control month required', 'id'=> 'month_legal', 'maxlength'=>'9','required'=>'required', 'placeholder' => __('Ced month ven')]) }}
                                                        {{Form::label('month_legal', __('Ced month ven'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('year_legal', $client['client_representative_legal']['representative']['expiration_year'], ['class' => 'form-control year required', 'id'=> 'year_legal', 'maxlength'=>'9','required'=>'required', 'placeholder' => __('Ced year ven')]) }}
                                                        {{Form::label('year_legal', __('Ced year ven'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('gender_legal', __('Gender'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('gender_legal', $gender , $client['client_representative_legal']['representative']['gender_id'],  ['class' => 'form-control select2 required', 'id'=> 'gender_legal', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                 <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('position_legal', $client['client_representative_legal']['position'], ['class' => 'form-control required', 'id'=> 'position_legal', 'maxlength'=>'80','required'=>'required', 'placeholder' => __('Position')])}}
                                                        {{Form::label('position_legal', __('Position'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('telephone_operator_legal', __('Local Operator'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('telephone_operator_legal', $defaultCodeOperatorCountries , $client['client_representative_legal']['representative']['telephone_operator_id'],  ['class' => 'form-control select2 required', 'id'=> 'telephone_operator_legal', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('phone_legal', $client['client_representative_legal']['representative']['phone'], ['class' => 'form-control numeric number required', 'id'=> 'phone_legal', 'maxlength'=>'7','required'=>'required', 'placeholder' => __('Phone Number')])}}
                                                         {{Form::label('phone_legal', __('Phone Number'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::email('email_legal', $client['client_representative_legal']['representative']['email'], ['class' => 'form-control email required', 'id'=> 'email_legal','required'=>'required', 'placeholder' => __('Email')]) }} 
                                                        {{Form::label('email_legal', __('Email'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  

                                    {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-4']) }}
                                    {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back','data-step'=>'#fieldset-2'])}}
                                </fieldset>
                                <fieldset id="fieldset-4">
                                    <div class="form-card" id="step-four">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{__('Commerce Representative')}}</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{__('Step 4 - 6')}}</h2>
                                                </div>
                                                  <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('documentlabe', __('Tipo de documento'), ['class' => 'selec2label'])}}
                                                        {{Form::select('type_document_commerce', $type_document , $client['client_representative_commerce']['representative']['type_document_id'], ['id'=>'type_document_commerce', 'class'=>'form-control select2 required' ,'placeholder' => __('Select...')])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-8 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('document_commerce',$client['client_representative_commerce']['representative']['document'], ['class' => 'form-control required', 'id'=> 'document_commerce', 'required'=>'required', 'maxlength'=>'9', 'placeholder' => __('RIF')]) }}   
                                                        {{Form::label('documentl', __('RIF'), ['class' => 'title'])}} 
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 col-sm-1 col-md-1 mb-4">
                                                    {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary', 'id' => 'search_representative_commerce']) }}
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('first_name_commerce', $client['client_representative_commerce']['representative']['first_name'], ['class' => 'form-control alphanum required', 'id'=> 'first_name_commerce','required'=>'required', 'placeholder' => __('First Name')]) }}
                                                        {{Form::label('first_name_commerce', __('First Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('second_name_commerce', $client['client_representative_commerce']['representative']['second_name'], ['class' => 'form-control alphanum required', 'id'=> 'second_name_commerce','required'=>'required', 'placeholder' => __('Second Name')]) }}
                                                        {{Form::label('second_name_commerce', __('Second Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('first_surname_commerce', $client['client_representative_commerce']['representative']['first_surname'], ['class' => 'form-control alphanum required', 'id'=> 'first_surname_commerce','required'=>'required', 'placeholder' => __('First Surname')]) }}
                                                        {{Form::label('first_surname_commerce', __('First Surname'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('second_surname_commerce', $client['client_representative_commerce']['representative']['second_surname'], ['class' => 'form-control alphanum required', 'id'=> 'second_surname_commerce','required'=>'required', 'placeholder' => __('Second SurName')]) }}
                                                        {{Form::label('second_surname_commerce', __('Second Surname'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 mb-6">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('month_commerce', $client['client_representative_commerce']['representative']['expiration_month'], ['class' => 'form-control month required', 'id'=> 'month_commerce', 'maxlength'=>'9','required'=>'required', 'placeholder' => __('Ced month ven')]) }}
                                                        {{Form::label('month_commerce', __('Ced month ven'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('year_commerce', $client['client_representative_commerce']['representative']['expiration_year'], ['class' => 'form-control year required', 'id'=> 'year_commerce', 'maxlength'=>'9','required'=>'required', 'placeholder' => __('Ced year ven')]) }}
                                                        {{Form::label('year_commerce', __('Ced year ven'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('date_birth_commerce', show_date($client['client_representative_commerce']['representative']['date_birth']), ['class' => 'form-control date_in required', 'id'=> 'date_birth_commerce','required'=>'required', 'placeholder' => __('Date Birth')]) }}
                                                        {{Form::label('date_birth_commerce', __('Date Birth'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('gender_commerce', __('Gender'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('gender_commerce', $gender , $client['client_representative_commerce']['representative']['gender_id'],  ['class' => 'form-control select2 required', 'id'=> 'gender_commerce', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('telephone_operator_commerce', __('Local Operator'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('telephone_operator_commerce', $defaultCodeOperatorCountries , $client['client_representative_commerce']['representative']['telephone_operator_id'],  ['class' => 'form-control select2 required', 'id'=> 'telephone_operator_commerce', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('phone_commerce', $client['client_representative_commerce']['representative']['phone'], ['class' => 'form-control numeric number required', 'id'=> 'phone_commerce', 'maxlength'=>'7','required'=>'required', 'placeholder' => __('Phone Number')])}}
                                                        {{Form::label('phone_commerce', __('Phone Number'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('position_commerce', $client['client_representative_commerce']['position'], ['class' => 'form-control required', 'id'=> 'position_commerce', 'maxlength'=>'80','required'=>'required', 'placeholder' => __('Position')])}}
                                                        {{Form::label('position_commerce', __('Position'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::email('email_commerce', $client['client_representative_commerce']['representative']['email'], ['class' => 'form-control email required', 'id'=> 'email_commerce','required'=>'required', 'placeholder' => __('Email')]) }} 
                                                        {{Form::label('email_commerce', __('Email'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-5']) }}
                                    {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back','data-step'=>'#fieldset-3'])}}
                                </fieldset>
                                <fieldset id="fieldset-5">
                                    <div class="form-card" id="step-five">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{__('Economic Activity')}}</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{__('Step 5 - 6')}}</h2>
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
                                                        {{ Form::select('product', $product , $client['economic_activity']['product_id'],  ['class' => 'form-control select2 required', 'id'=> 'product', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>    
                                    </div> 
                                    {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-6']) }}
                                    {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-4'])}}
                                </fieldset>
                                <fieldset id="fieldset-6">
                                    <div class="form-card">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{__('Miselaneous')}}</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{__('Step 6 - 6')}}</h2>
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
                                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'saveJuridic', 'type' => 'submit']) }}
                                        {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-5'])}}
                                </fieldset>
                            {{ Form::close() }} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        applyFormats();      
        ajaxForm("#edit_person_j");
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
            $('#type_document_legal').on('input',function(){
              $('#type_document_commerce').val(this.value).trigger('change');
            });
            $('#document_legal').on('input',function(){
              $('#document_commerce').val(this.value);
            });
            $('#first_name_legal').on('input',function(){
              $('#first_name_commerce').val(this.value);
            });
            $('#second_name_legal').on('input',function(){
              $('#second_name_commerce').val(this.value);
            });
            $('#first_surname_legal').on('input',function(){
              $('#first_surname_commerce').val(this.value);
            });
            $('#second_surname_legal').on('input',function(){
              $('#second_surname_commerce').val(this.value);
            });
            $('#date_birth_legal').on('input',function(){
              $('#date_birth_commerce').val(this.value);
            });
            $('#month_legal').on('input',function(){
              $('#month_commerce').val(this.value);
            });
            $('#gender_legal').on('input',function(){
              $('#gender_commerce').val(this.value).trigger('change');
            });
            $('#telephone_operator_legal').on('input',function(){
              $('#telephone_operator_commerce').val(this.value).trigger('change');
            });
            $('#phone_legal').on('input',function(){
              $('#phone_commerce').val(this.value);
            });
            $('#email_legal').on('input',function(){
              $('#email_commerce').val(this.value);
            });
        })
        $('#search_representative_legal').on('click', function(){
            if ( $('#type_document_legal, #document_legal').valid()  ){
                    $('#search_representative_legal').html('<i class="fa fa-spinner fa-pulse" ></i>');
                    $.get("{{url('CL001.search_representatives')}}/"+$('#type_document_legal').val()+'/'+$('#document_legal').val(),function(data){
                    if (data.status == 0){
                        toastr[data['type_message']](data['message'], data['title']);
                        $('#search_representative_legal').html('<i class="fa fa-search"></i>');
                        clean_fields_legal();
                        return false;
                    }
                    $('#where_legal').val(data.where);
                    $('#first_name_legal').val(data.data.first_name);
                    $('#second_name_legal').val(data.data.second_name);
                    $('#first_surname_legal').val(data.data.first_surname);
                    $('#second_surname_legal').val(data.data.second_surname);
                    $('#month_legal').val(data.data.expiration_month);
                    $('#year_legal').val(data.data.expiration_year);
                    $('#date_birth_legal').val(data.data.date_birth);
                    $('#telephone_operator_legal').val(data.data.telephone_operator_id).trigger('change');
                    $('#phone_legal').val(data.data.phone);
                    $('#email_legal').val(data.data.email);
                    $('#gender_legal').val(data.data.gender_id).trigger('change');

                    $('#where_commerce').val(data.where);
                    $('#first_name_commerce').val(data.data.first_name);
                    $('#second_name_commerce').val(data.data.second_name);
                    $('#first_surname_commerce').val(data.data.first_surname);
                    $('#second_surname_commerce').val(data.data.second_surname);
                    $('#month_commerce').val(data.data.expiration_month);
                    $('#year_commerce').val(data.data.expiration_year);
                    $('#date_birth_commerce').val(data.data.date_birth);
                    $('#telephone_operator_commerce').val(data.data.telephone_operator_id).trigger('change');
                    $('#phone_commerce').val(data.data.phone);
                    $('#email_commerce').val(data.data.email);
                    $('#gender_commerce').val(data.data.gender).trigger('change');

                    $('#search_representative_legal').html('<i class="fa fa-search"></i>');
                    applyFormats();      
            
                },'json').fail(function(){
                $('#search_representative_legal').html('<i class="fa fa-search"></i>');
                toastr.error('{{ __('No data found') }}');  
                 });
            } 
        });
        $('#search_representative_commerce').on('click', function(){
            $('#search_representative_commerce').html('<i class="fa fa-spinner fa-pulse" ></i>');
            $.get("{{url('CL001.search_representatives')}}/"+$('#type_document_commerce').val()+'/'+$('#document_commerce').val(),function(data){
                if (data.status == 0){
                    toastr[data['type_message']](data['message'], data['title']);
                    $('#search_representative_legal').html('<i class="fa fa-search"></i>');
                    clean_fields_commerce();
                    return false;
                }
                $('#where_commerce').val(data.where);
                $('#first_name_commerce').val(data.data.first_name);
                $('#second_name_commerce').val(data.data.second_name);
                $('#first_surname_commerce').val(data.data.first_surname);
                $('#second_surname_commerce').val(data.data.second_surname);
                $('#month_commerce').val(data.data.expiration_month);
                $('#year_commerce').val(data.data.expiration_year);
                $('#date_birth_commerce').val(data.data.date_birth);
                $('#telephone_operator_commerce').val(data.data.telephone_operator_id).trigger('change');
                $('#phone_commerce').val(data.data.phone);
                $('#email_commerce').val(data.data.email);
                $('#gender_commerce').val(data.data.gender).trigger('change');

                $('#search_representative_commerce').html('<i class="fa fa-search"></i>');
                applyFormats();      
            },'json').fail(function(){
                $('#search_representative_commerce').html('<i class="fa fa-search"></i>');
                toastr.error('{{ __('No data found') }}');  
            });
        });
    });
    function clean_fields_legal() {
        $('#where_legal').val('');
        $('#first_name_legal').val('');
        $('#second_name_legal').val('');
        $('#first_surname_legal').val('');
        $('#second_surname_legal').val('');
        $('#month_legal').val('');
        $('#year_legal').val('');
        $('#date_birth_legal').val('');
        $('#telephone_operator_legal').val('').trigger('change');
        $('#phone_legal').val('');
        $('#email_legal').val('');
        $('#gender_legal').val('').trigger('change');
        $('#where_commerce').val('');
        $('#position_legal').val('');
        $('#first_name_commerce').val('');
        $('#second_name_commerce').val('');
        $('#first_surname_commerce').val('');
        $('#second_surname_commerce').val('');
        $('#month_commerce').val('');
        $('#year_commerce').val('');
        $('#date_birth_commerce').val('');
        $('#telephone_operator_commerce').val('').trigger('change');
        $('#phone_commerce').val('');
        $('#email_commerce').val('');
        $('#gender_commerce').val('').trigger('change');
        applyFormats();      
    }
    function clean_fields_commerce() {
        $('#where_commerce').val('');
        $('#first_name_commerce').val('');
        $('#second_name_commerce').val('');
        $('#first_surname_commerce').val('');
        $('#second_surname_commerce').val('');
        $('#month_commerce').val('');
        $('#year_commerce').val('');
        $('#position_commerce').val('');
        $('#date_birth_commerce').val('');
        $('#telephone_operator_commerce').val('').trigger('change');
        $('#phone_commerce').val('');
        $('#email_commerce').val('');
        $('#gender_commerce').val('').trigger('change');
        applyFormats();      
    }
</script>