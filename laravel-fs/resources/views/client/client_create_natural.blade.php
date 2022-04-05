<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-university"></i>{{ __('Register Client') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                <div class="container-form">
                    <div class="container-fluid">
                        <div class="row">
                            {{ Form::open(['route'=>'client.store_person_natural','id'=>'msform','autocomplete'=>'Off','class'=>'validate', 'data-dataType'=>'json']) }}
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
                               <legend></legend>
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

                                                    {{ Form::text('document',(isset($document_des))?$document_des:"" , ['class' => 'form-control', 'id'=> 'document','placeholder' => __('Document'), 'readonly'=>'readonly']) }}

                                                    {{Form::label('document', __('Document'), ['class' => 'title'])}}                                                    </div>

                                            </div>
                                            {{ Form::hidden('storage', (isset($storage_person))?$storage_person:"")}}
                                            {{ Form::hidden('operative', (isset($operative_person))?$operative_person:"")}}

                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('first_name', (isset($person['first_name']))?$person['first_name']:"" , ['maxlength'=>'50', 'class' => 'form-control alphanum required', 'id'=> 'first_name','required'=>'required', 'placeholder' => __('First Name')]) }}
                                                    {{Form::label('first_name', __('First Name'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label"> 
                                                    {{ Form::text('last_name',(isset($person['second_name']))?$person['second_name']:"" , ['maxlength'=>'50', 'class' => 'form-control alphanum required', 'id'=> 'last_name','required'=>'required', 'placeholder' => __('Second Name')]) }}
                                                    {{Form::label('last_name', __('Second Name'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('first_surname', (isset($person['first_surname']))?$person['first_surname']:"", ['maxlength'=>'50', 'class' => 'form-control alphanum required', 'id'=> 'first_surname','required'=>'required', 'placeholder' => __('First Surname')]) }}
                                                    {{Form::label('first_surname', __('First Surname'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('last_surname', (isset($person['second_surname']))?$person['second_surname']:"", ['maxlength'=>'50', 'class' => 'form-control alphanum required', 'id'=> 'last_surname','required'=>'required', 'placeholder' => __('Second Surname')]) }}
                                                    {{Form::label('last_surname', __('Second Surname'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{  Form::text('month', null, ['id'=>'month','class'=>'form-control required month', 'readonly'=>'readonly' ,'required'=>'required', 'placeholder' => __('Ced month ven'), 'readonly'=>'readonly' ]) }}
                                                    {{Form::label('month', __('Ced month ven'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{  Form::text('year', null, ['id'=>'year','class'=>'form-control required year', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Ced year ven'), 'readonly'=>'readonly' ]) }}
                                                    {{Form::label('year', __('Ced year ven'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                <div class="form-group floating-label">
                                                    {{  Form::text('date_birth', null, ['id'=>'date_birth','class'=>'form-control required date_in', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Date Birth'), 'readonly'=>'readonly' ]) }}
                                                    {{Form::label('date_birth', __('Date Birth'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('nationality', __('Nationality'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('nationality', $nationality , 1,  ['class' => 'form-control select2 required', 'id'=> 'nationality', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('gender', __('Gender'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('gender', $gender , 0,  ['class' => 'form-control select2 required', 'id'=> 'gender', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('telephone_operators', __('Local Operator house'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('telephone_operators_house', $defaultCodeOperatorCellHouseCountries , '',  ['class' => 'form-control select2 required', 'id'=> 'telephone_operators_house', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('phone_house', null, ['class' => 'form-control numeric number required', 'id'=> 'phone_house', 'required'=>'required', 'maxlength'=>'7', 'placeholder' => __('Phone Number')])}}
                                                    {{Form::label('phone_house', __('Phone Number'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('telephone_operators', __('Local Operator cell'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('telephone_operators_cell', $defaultCodeOperatorCellPhoneCountries , '',  ['class' => 'form-control select2 required', 'id'=> 'telephone_operators_cell', 'placeholder' => __('Select...'),'required'=>'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('phone_cell', null, ['class' => 'form-control numeric number required', 'id'=> 'phone_cell', 'required'=>'required', 'maxlength'=>'7', 'placeholder' =>__('Phone Number')])}}
                                                    {{Form::label('phone_cell', __('Phone Number'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('email', null, ['maxlength'=>'50', 'class' => 'form-control email required', 'id'=> 'email','required'=>'required', 'placeholder' => __('Email')]) }} 
                                                    {{Form::label('email', __('Email'), ['class' => 'title'])}}
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
                                                    {{ Form::select('country', $country , $defaultCountry,  ['class' => 'form-control select2 required', 'id'=> 'country', 'placeholder' => __('Select...'),'required'=>'required']) }}

                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('state', __('State'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('state', $defaultStateFromCountry , '',  [ 'class' => 'form-control select2 required ', 'id'=> 'state', 'placeholder' => __('Select...'),'required'=>'required']) }}
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
                                                    {{ Form::text('edif_qta_torre', null, ['class' => 'form-control required', 'id'=> 'edif_qta_torre', 'maxlength'=>'50','required'=>'required', 'placeholder' => __('Edif/Qta/Torre')])}}
                                                    {{Form::label('edif_qta_torre', __('Edif/Qta/Torre'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('floor', null, ['class' => 'form-control required', 'id'=> 'floor', 'maxlength'=>'8','required'=>'required', 'placeholder' => __('Floor')])}}
                                                    {{Form::label('floor', __('Floor'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('apto_offic_loc_casa', null, ['class' => 'form-control required', 'id'=> 'apto_offic_loc_casa', 'maxlength'=>'50', 'required'=>'required','placeholder' => __('apto/offic/loc/casa')])}}
                                                    {{Form::label('apto_offic_loc_casa', __('apto/offic/loc/casa'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('urbanization', null, ['class' => 'form-control  required', 'id'=> 'urbanization', 'maxlength'=>'50','required'=>'required','placeholder' => __('Urbanization')])}}
                                                    {{Form::label('urbanization', __('Urbanization'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('reference', null, ['class' => 'form-control required', 'id'=> 'reference', 'maxlength'=>'200','required'=>'required', 'placeholder' => __('Reference')])}}
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
                                <legend></legend>
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
                                {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-4']) }}
                                {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-2'])}}
                            </fieldset>
                            <fieldset id="fieldset-4">
                                <legend></legend>
                                <div class="form-card" id="step-4">
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">{{__('Miselaneous')}}</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">{{__('Step 4 - 4')}}</h2>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('twitter', null, ['class' => 'form-control', 'id'=> 'twitter', 'placeholder' => __('Twitter')]) }}
                                                    {{Form::label('twitter', __('Twitter'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('facebook', null, ['class' => 'form-control ', 'id'=> 'facebook', 'placeholder' => __('Facebook')]) }}
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
                                {{ Form::button(__('Save'), ['class' => 'btn btn-primary save','data-step-valid'=>'#step-4', 'id' => 'save1', 'type' => 'submit']) }}
                                {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-3'])}}
                            </fieldset>
                            {{ Form::hidden('person_doc', $document)}}
                            {{ Form::hidden('person_type', $type)}}
                            {{ Form::close() }} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function (){
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
