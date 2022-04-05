<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-university"></i>{{ __('Register Client') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                <div class="container-form">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            {{ Form::open(['route'=>'client.store_person_juridic','id'=>'msform','autocomplete'=>'Off','class'=>'validate', 'data-dataType'=>'json']) }}
                                <!-- progressbar -->
                                <ul id="progressbar" class="fivestep">
                                    <li class="active current" id="date" data-target="#fieldset-1"><i class="fas fa-address-card"></i><strong>{{__('Commercial Dates')}}</strong></li>
                                    <li id="address" data-target="#fieldset-2"><i class="fas fa-map-marked"></i><strong>{{__('Address')}}</strong></li>
                                    <li id="legal" data-target="#fieldset-3"><i class="fas fa-male"></i><strong>{{__('Legal Representative')}}</strong></li>
                                    <li id="commerce" data-target="#fieldset-4"><i class="fas fa-male"></i><strong>{{__('Commerce Representative')}}</strong></li>
                                    <li id="activity" data-target="#fieldset-5"><i class="fas fa-male"></i><strong>{{__('Economic Activity')}}</strong></li>
                                    <li id="miselaneus" data-target="#fieldset-6"><i class="fas fa-user-plus"></i><strong>{{__('Miselaneus')}}</strong></li>
                                </ul>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> <br> 
                                <!-- fieldsets -->
                                <fieldset id="fieldset-1">
                                <legend></legend>
                                    <div class="form-card" id="uno">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{__('Commerce Data')}}</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{__('Step 1 - 6')}}</h2>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('document_des',(isset($document_des))?$document_des:"" , ['readonly'=>'readonly', 'class' => 'form-control', 'id'=> 'document_des', 'maxlength'=>'12', 'placeholder'=> __('Document')]) }}
                                                        {{Form::label('document_des', __('Document'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                {{ Form::hidden('storage', (isset($storage_client))?$storage_client:"")}}
                                                {{ Form::hidden('operative', (isset($operative_client))?$operative_client:"")}}
                                               
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('razon_social', null, ['class' => 'form-control alphanum required', 'id'=> 'razon_social','maxlength'=>'100', 'required'=>'required', 'placeholder'=> __('Business Name')]) }}
                                                        {{Form::label('razon_social', __('Business Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('fantasy_name', null, ['class' => 'form-control alphanum required', 'id'=> 'fantasy_name', 'maxlength'=>'100','required'=>'required', 'placeholder'=> __('Fantasy Name')]) }}
                                                        {{Form::label('fantasy_name', __('Fantasy Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('telephone_operators', __('Local Operator'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('telephone_operators',$defaultCodeOperatorCountries , '',  ['class' => 'form-control select2 required', 'id'=> 'telephone_operators', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('phone', null, ['class' => 'form-control numeric number required', 'id'=> 'phone', 'required'=>'required', 'maxlength'=>'7','placeholder' => __('Phone Number')])}}
                                                        {{Form::label('phone', __('Phone Number'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('email', null, ['class' => 'form-control email required', 'id'=> 'email','required'=>'required', 'maxlength'=>'50' ,'placeholder' => __('Email')]) }} 
                                                        {{Form::label('email', __('Email'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('franchises', __('franchise'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('franchises', $franchise , '',  ['class' => 'form-control select2 ', 'id'=> 'franchises', 'placeholder' => __('Select...')]) }}
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>    
                                    </div> 
                                    {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-2']) }}
                                    <a class="btn btn-secondary back link_ajax " href="{{route('client')}}" data-dataType="html"> {{ __('Back') }} </a>
                                </fieldset>
                                <fieldset id="fieldset-2">
                                <legend></legend>
                                    <div class="form-card" id="dos">
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
                                                        {{ Form::select('country', $country , $defaultCountry,  ['class' => 'form-control select2 required', 'id'=> 'country', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('state', __('State'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('state', $defaultStateFromCountry , '',  ['class' => 'form-control select2 required', 'id'=> 'state', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('municipality', __('Municipality'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('municipality', [] , '',  ['class' => 'form-control select2 required', 'id'=> 'municipality', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('city', __('City'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('city', [] , '',  ['class' => 'form-control select2 required', 'id'=> 'city', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('postal_code', __('Postal Code'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('postal_code', [] , '',  ['class' => 'form-control select2 required', 'id'=> 'postal_code', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        
                                                        {{ Form::text('edif_qta_torre', null, ['class' => 'form-control required', 'id'=> 'edif_qta_torre', 'required'=>'required', "maxlength"=>"50" ,'placeholder' => __('Edif/Qta/Torre')])}}
                                                        {{Form::label('edif_qta_torre', __('Edif/Qta/Torre'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('floor', null, ['class' => 'form-control  required', 'id'=> 'floor', "maxlength"=>"8"  , 'required'=>'required', 'placeholder' => __('Floor')])}}
                                                        {{Form::label('floor', __('Floor'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('apto_offic_loc_casa', null, ['class' => 'form-control required', 'id'=> 'apto_offic_loc_casa',  "maxlength"=>"50",  'required'=>'required', 'placeholder' => __('apto/offic/loc/casa')])}}
                                                        {{Form::label('apto_offic_loc_casa', __('apto/offic/loc/casa'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('urbanization', null, ['class' => 'form-control required', 'id'=> 'urbanization', "maxlength"=>"50" ,  'required'=>'required', 'placeholder' =>__('Urbanization')])}}
                                                        {{Form::label('urbanization', __('Urbanization'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('reference', null, ['class' => 'form-control required', "maxlength"=>"200" , 'id'=> 'reference','required'=>'required',  'placeholder' =>__('Reference')])}}
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
                                <legend></legend>
                                    <div class="form-card" id="tres">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{__('Representative Legal')}}</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{__('Step 3 - 6')}}</h2>
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('documentlabe', __('Tipo de documento'), ['class' => 'selec2label'])}}
                                                        {{Form::select('type_document_legal', $type_document , null, ['id'=>'type_document_legal', 'class'=>'form-control select2 required', 'placeholder' =>  __('Select...')])}}
														{{Form::hidden('legal_id', '' ,['id'=>'legal_id'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-8 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('document_legal','', ['class' => 'form-control required  number numeric required', 'id'=> 'document_legal', 'required'=>'required', 'maxlength'=>'9', 'placeholder' => __('RIF')]) }}
                                                         {{Form::label('documentl', __('RIF'), ['class' => 'title'])}} 
                                                    </div>   
                                                </div>
                                                <div class="col-xs-1 col-sm-1 col-md-1 mb-4">
                                                    {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary ', 'id' => 'search_representative_legal']) }}
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('first_name_legal', null, ["disabled"=>"disabled", 'class' => 'form-control required three', 'id'=> 'first_name_legal','required'=>'required', 'placeholder' => __('First Name')]) }}
                                                        {{Form::label('first_name_legal', __('First Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('second_name_legal', null, ["disabled"=>"disabled", 'class' => 'form-control required three', 'id'=> 'second_name_legal','required'=>'required', 'placeholder' => __('Second Name')]) }}
                                                        {{Form::label('second_name_legal', __('Second Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('first_surname_legal', null, ["disabled"=>"disabled", 'class' => 'form-control required three', 'id'=> 'first_surname_legal','required'=>'required', 'placeholder' => __('First Surname')])}}
                                                        {{Form::label('first_surname_legal', __('First Surname'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('second_surname_legal', null, ["disabled"=>"disabled", 'class' => 'form-control required three', 'id'=> 'second_surname_legal','required'=>'required', 'placeholder' => __('Second Surname')])}}
                                                        {{Form::label('second_surname_legal', __('Second Surname'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('date_birth_legal', null, ["disabled"=>"disabled", 'class' => 'form-control date_in required three', 'id'=> 'date_birth_legal','required'=>'required', 'placeholder' => __('Date Birth'), 'readonly'=>'readonly']) }}
                                                         {{Form::label('date_birth_legal', __('Date Birth'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('month_legal', null, ["disabled"=>"disabled", 'class' => 'form-control month required three', 'id'=> 'month_legal', 'maxlength'=>'9','required'=>'required', 'placeholder' => __('Ced month ven'), 'readonly'=>'readonly']) }}
                                                        {{Form::label('month_legal', __('Ced month ven'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('year_legal', null, ["disabled"=>"disabled", 'class' => 'form-control year required three', 'id'=> 'year_legal', 'maxlength'=>'9','required'=>'required', 'placeholder' => __('Ced year ven'), 'readonly'=>'readonly']) }}
                                                        {{Form::label('year_legal', __('Ced year ven'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('gender_legal', __('Gender'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('gender_legal', $gender , null,  ["disabled"=>"disabled", 'class' => 'form-control select2 required three', 'id'=> 'gender_legal', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                 <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('position_legal', null, ["disabled"=>"disabled", 'class' => 'form-control required three', 'id'=> 'position_legal', 'required'=>'required',  'maxlength'=>'80', 'placeholder' => __('Position')])}}
                                                        {{Form::label('position_legal', __('Position'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('telephone_operator_legal', __('Local Operator'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('telephone_operator_legal', $defaultCodeOperatorCountries , null,  ["disabled"=>"disabled", 'class' => 'three form-control select2 required', 'id'=> 'telephone_operator_legal', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('phone_legal', null, ["disabled"=>"disabled", 'class' => 'form-control numeric number required three', 'id'=> 'phone_legal', 'maxlength'=>'7','required'=>'required', 'placeholder' => __('Phone Number')])}}
                                                         {{Form::label('phone_legal', __('Phone Number'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('email_legal', null, ["disabled"=>"disabled", 'class' => 'form-control email required three', 'id'=> 'email_legal','required'=>'required', 'placeholder' => __('Email')]) }} 
                                                        {{Form::label('email_legal', __('Email'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    {{ Form::button(__('Next'), ['id'=>'sameD', 'class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-4']) }}
                                    {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-2'])}}
                                </fieldset>
                                <fieldset id="fieldset-4">
                                <legend></legend>
                                    <div class="form-card" id="cuatro">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{__('Commerce Representative')}}</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{__('Step 4 - 6')}}</h2>
                                                </div>
                                                <div class="col-xs-1 col-sm-1 col-md-1 lo mb-4">
                                                    <div class="form-check">
                                                            {{ Form::checkbox('repeat_data', 1, true, ['class' => 'form-check-input', 'checked'=> 'checked','id'=> 'repeat_data'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-11 col-sm-11 col-md-11 mb-4">
                                                    <div class="input-group-text">
                                                            {{Form::label('labelcode', __('Repeat Data Of The Legal Representative'), ['class' => 'title'])}}
                                                    </div>  
                                                </div>  

                                               
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('documentlabe', __('Document Type'), ['class' => 'selec2label'])}}
                                                        {{Form::select('type_document_commerce', $type_document , null, ['id'=>'type_document_commerce', 'class'=>'form-control select2 required' ,'placeholder' => __('Select...')])}}
														{{Form::hidden('commerce_id', '' ,['id'=>'commerce_id'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-8 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('document_commerce','', ['class' => 'form-control required number', 'id'=> 'document_commerce', 'required'=>'required', 'maxlength'=>'9', 'placeholder' => __('RIF')]) }}   
                                                        {{Form::label('documentl', __('RIF'), ['class' => 'title'])}} 
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 col-sm-1 col-md-1 mb-4">
                                                    {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary ', 'id' => 'search_representative_commerce', 'disabled' => 'disabled']) }}
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('first_name_commerce', null, ["disabled"=>"disabled", 'class' => 'form-control alphanum four required', 'id'=> 'first_name_commerce','required'=>'required', 'placeholder' => __('First Name')]) }}
                                                        {{Form::label('first_name_commerce', __('First Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('second_name_commerce', null, ["disabled"=>"disabled", 'class' => 'form-control required four', 'id'=> 'second_name_commerce','required'=>'required', 'placeholder' => __('First Name')]) }}
                                                        {{Form::label('second_name_commerce', __('Second Name'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('first_surname_commerce', null, ["disabled"=>"disabled", 'class' => 'form-control required four', 'id'=> 'first_surname_commerce','required'=>'required', 'placeholder' => __('First Name')]) }}
                                                        {{Form::label('first_surname_commerce', __('First Surname'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('second_surname_commerce', null, ["disabled"=>"disabled", 'class' => 'form-control required four', 'id'=> 'second_surname_commerce','required'=>'required', 'placeholder' => __('First Name')]) }}
                                                        {{Form::label('second_surname_commerce', __('Second Surname'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 mb-6">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('month_commerce', null, ["disabled"=>"disabled", 'class' => 'form-control month required four', 'id'=> 'month_commerce', "readonly"=>"readonly", 'maxlength'=>'9','required'=>'required', 'placeholder' => __('Ced month ven'), 'disabled'=> true]) }}
                                                        {{Form::label('month_commerce', __('Ced month ven'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('year_commerce', null, ["disabled"=>"disabled", 'class' => 'form-control year required four', 'id'=> 'year_commerce', "readonly"=>"readonly",  'maxlength'=>'9','required'=>'required', 'placeholder' => __('Ced year ven')]) }}
                                                        {{Form::label('year_commerce', __('Ced year ven'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('date_birth_commerce', null, ["disabled"=>"disabled", 'class' => 'form-control date_in required four', 'id'=> 'date_birth_commerce','required'=>'required',"readonly"=>"readonly" ,'placeholder' => __('Date Birth')]) }}
                                                        {{Form::label('date_birth_commerce', __('Date Birth'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('gender_commerce', __('Gender'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('gender_commerce', $gender , null,  ["disabled"=>"disabled", 'class' => 'form-control select2 four required', 'id'=> 'gender_commerce', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('telephone_operator_commerce', __('Local Operator'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('telephone_operator_commerce', $defaultCodeOperatorCountries , '',  ["disabled"=>"disabled", 'class' => 'four form-control select2 required', 'id'=> 'telephone_operator_commerce', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('phone_commerce', null, ["disabled"=>"disabled", 'class' => 'form-control four number required', 'id'=> 'phone_commerce', 'maxlength'=>'7','required'=>'required', 'placeholder' => __('Phone Number')])}}
                                                        {{Form::label('phone_commerce', __('Phone Number'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('position_commerce', null, ["disabled"=>"disabled", 'class' => 'form-control required four', 'id'=> 'position_commerce', 'maxlength'=>'80','required'=>'required', 'placeholder' => __('Position')])}}
                                                        {{Form::label('position_commerce', __('Position'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('email_commerce', null, ["disabled"=>"disabled", 'class' => 'form-control email required four', 'id'=> 'email_commerce','required'=>'required', 'placeholder' => __('Email')]) }} 
                                                        {{Form::label('email_commerce', __('Email'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-5']) }}
                                    {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-3'])}}
                                </fieldset>
                                <fieldset id="fieldset-5">
                                <legend></legend>
                                    <div class="form-card" id="cinco">
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
                                                        {{ Form::select('economic_sector', $economic_sector , 0,  ['class' => 'form-control select2 required', 'id'=> 'economic_sector', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('economic_activity', __('Economic Activity'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('economic_activity', $activity , 0,  ['class' => 'form-control select2 required', 'id'=> 'economic_activity', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('modality', __('Modality'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('modality', $modality , 0,  ['class' => 'form-control select2 required', 'id'=> 'modality', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('product', __('Product'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('product', $product , 0,  ['class' => 'form-control select2 required', 'id'=> 'product', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>    
                                    </div> 
                                    {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-6']) }}
                                    {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-4'])}}
                                </fieldset>
                                <fieldset id="fieldset-6">
                                <legend></legend>
                                    <div class="form-card">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{__('Miselaneous')}}</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{__('Step 6 - 6')}}</h2>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('twitter', null, ['class' => 'form-control', 'id'=> 'twitter',  'placeholder' => __('Twitter')]) }}
                                                        {{Form::label('twitter', __('Twitter'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('facebook', null, ['class' => 'form-control', 'id'=> 'facebook', 'maxlength'=>'255',  'placeholder' => __('Facebook')]) }}
                                                        {{Form::label('facebook', __('Facebook'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('instagram', null, ['class' => 'form-control', 'id'=> 'instagram',  'placeholder' => __('Instagram')]) }}
                                                        {{Form::label('instagram', __('Instagram'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>    
                                    </div> 
                                    {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'save1', 'type' => 'submit']) }}
                                    {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-5'])}}
                                </fieldset>
                                {{ Form::hidden('type', $type)}}
                                {{ Form::hidden('document', $document)}}
                                {{ Form::hidden('where_legal', null,['id'=>'where_legal'])}}
                                {{ Form::hidden('where_commerce', null,['id'=>'where_commerce'])}}
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
		
		
		$("#repeat_data").on("click", function (){
			if (  $(this).is(":checked")  ){
				resp = true;
				sameData();
			}else{
				resp = false;
				 clearData();
			}
			$('#type_document_commerce, #document_commerce, #search_representative_commerce').prop('disabled', resp);
		});
		
		$("#sameD").on("click", function (){
			$("#repeat_data").prop('checked', true);
			sameData();
			
		});
		
		
		
		
		
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
		
        $('#search_representative_legal').on('click', function(){
            if ( $('#type_document_legal, #document_legal').valid()  ){
                    $('#search_representative_legal').html('<i class="fa fa-spinner fa-pulse" ></i>');
                    $.get("{{url('CL001.search_representatives')}}/"+$('#type_document_legal').val()+'/'+$('#document_legal').val(),function(response){
                   
						if (response.data.id==""){
							toastr['info']("{{__('Data Not Found, Register it')}}");
						}
						$(".three").prop('disabled', false)
						
						$('#where_legal').val(response.where);
						$('#legal_id').val(response.data.id);
						$('#first_name_legal').val(response.data.first_name);
						$('#second_name_legal').val(response.data.second_name);
						$('#first_surname_legal').val(response.data.first_surname);
						$('#second_surname_legal').val(response.data.second_surname);
						$('#month_legal').val(response.data.expiration_month);
						$('#year_legal').val(response.data.expiration_year);
						$('#date_birth_legal').val(response.data.date_birth);
						$('#telephone_operator_legal').val(response.data.telephone_operator_id).trigger('change');
						$('#phone_legal').val(response.data.phone);
						$('#email_legal').val(response.data.email);
						$('#gender_legal').val(response.data.gender);
						
						
						$('#search_representative_legal').html('<i class="fa fa-search"></i>');

                  
            
                },'json');
            } 
        });
        $('#search_representative_commerce').on('click', function(){
			if ( $('#type_document_commerce, #document_commerce').valid()  ){
				$('#search_representative_commerce').html('<i class="fa fa-spinner fa-pulse" ></i>');
				$.get("{{url('CL001.search_representatives')}}/"+$('#type_document_commerce').val()+'/'+$('#document_commerce').val(),function(response){
					
					if (response.data.id==""){
						toastr['info']("{{__('Data Not Found, Register it')}}");
					}
					
					$('.four').prop('disabled', false);
					
					$('#where_commerce').val(response.where);
					$('#commerce_id').val(response.data.id);
					$('#first_name_commerce').val(response.data.first_name);
					$('#second_name_commerce').val(response.data.second_name);
					$('#first_surname_commerce').val(response.data.first_surname);
					$('#second_surname_commerce').val(response.data.second_surname);
					$('#month_commerce').val(response.data.expiration_month);
					$('#year_commerce').val(response.data.expiration_year);
					$('#date_birth_commerce').val(response.data.date_birth);
					$('#telephone_operator_commerce').val(response.data.telephone_operator_id).trigger('change');
					$('#phone_commerce').val(response.data.phone);
					$('#email_commerce').val(response.data.email);
					$('#gender_commerce').val(response.data.gender).trigger('change');

					$('#search_representative_commerce').html('<i class="fa fa-search"></i>');
				},'json');
			}
        });
    });
    
	
	
	function sameData(){
		$('#commerce_id').val($('#legal_id').val());
		
		$('#type_document_commerce').val($('#type_document_legal').val()).trigger('change');
		$('#document_commerce').val($('#document_legal').val());
		
		$('#first_name_commerce').val($('#first_name_legal').val());
		$('#second_name_commerce').val($('#second_name_legal').val());
		$('#first_surname_commerce').val($('#first_surname_legal').val());
		$('#second_surname_commerce').val($('#second_surname_legal').val());
		$('#month_commerce').val($('#month_legal').val());
		$('#year_commerce').val($('#year_legal').val());
		$('#date_birth_commerce').val($('#date_birth_legal').val());
		$('#telephone_operator_commerce').val($('#telephone_operator_legal').val()).trigger('change');
		$('#phone_commerce').val($('#phone_legal').val());
		$('#position_commerce').val($('#position_legal').val());
		$('#email_commerce').val($('#email_legal').val());
		$('#gender_commerce').val($('#gender_legal').val()).trigger('change');
		
		
	}
	
	function clearData(){
		$('#commerce_id').val("");
		
		$('#document_commerce, #first_name_commerce, #second_name_commerce, #first_surname_commerce').val("");
		$('#second_surname_commerce, #month_commerce, #year_commerce, #date_birth_commerce').val("");
		$('#phone_commerce, #position_commerce, #email_commerce').val("");
		$('#type_document_commerce, #telephone_operator_commerce, #gender_commerce').val("").trigger('change');
		
		
		
	}
	
	
	
</script>