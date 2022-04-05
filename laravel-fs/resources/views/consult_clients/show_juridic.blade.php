<div class="content-table"> 
    <h3>{{ __('Commerce Data') }}</h3>
    <div class="content-space"> 
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav1-tab" data-bs-toggle="tab" data-bs-target="#nav1" type="button" role="tab" aria-controls="nav1" aria-selected="true">{{ __('Commerce Data') }}</button>
            <button class="nav-link" id="nav2-tab" data-bs-toggle="tab" data-bs-target="#nav2" type="button" role="tab" aria-controls="nav2" aria-selected="false">{{ __('Address') }}</button>
            <button class="nav-link" id="nav3-tab" data-bs-toggle="tab" data-bs-target="#nav3" type="button" role="tab" aria-controls="nav3" aria-selected="false">{{ __('Representative Legal') }}</button>
            <button class="nav-link" id="nav4-tab" data-bs-toggle="tab" data-bs-target="#nav4" type="button" role="tab" aria-controls="nav4" aria-selected="false">{{ __('Commerce Representative') }}</button>
            <button class="nav-link" id="nav5-tab" data-bs-toggle="tab" data-bs-target="#nav5" type="button" role="tab" aria-controls="nav5" aria-selected="false">{{ __('Economic Activity') }}</button>
            <button class="nav-link" id="nav6-tab" data-bs-toggle="tab" data-bs-target="#nav6" type="button" role="tab" aria-controls="nav6" aria-selected="false">{{ __('Miscellaneous') }}</button>
          </div>
        </nav>
        <div id="bodytable">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav1" role="tabpanel" aria-labelledby="nav1-tab">
                    {{ Form::open(['id'=>'frmJuridic1','autocomplete'=>'Off','class' => 'validate' ]) }}
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{Form::text('commerce', $client['rif'] . ' / ' .$client['name_client'], ['class' => 'form-control', 'id'=> 'commerce','placeholder' => __('Commerce'), 'readonly'=>'readonly']) }}
                                {{Form::label('commerce', __('Commerce'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{  Form::text('fantasy_name', $client['get_commerce']['trade_name'], ['id'=>'fantasy_name','class'=>'form-control', 'readonly'=>'readonly' ,'required'=>'required', 'placeholder' => __('Fantasy name'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('fantasy_name', __('Fantasy name'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('local_telephone', $client['get_commerce']['get_telephone_operator']['code'] . ' - ' . $client['get_commerce']['phone'], ['id'=>'local_telephone','class'=>'form-control', 'required'=>'required', 'placeholder' => __('Local telephone'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('local_telephone', __('Local telephone'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('email', $client['get_commerce']['email'], ['class' => 'form-control', 'id'=> 'email','required'=>'required', 'placeholder' => __('Email'), 'readonly'=>'readonly']) }} 
                                    {{Form::label('email', __('Email'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('franchise', $client['get_commerce']['name_franchise']['name_franchise'], ['class' => 'form-control', 'id'=> 'franchise','required'=>'required', 'placeholder' => __('Franchise'), 'readonly'=>'readonly']) }} 
                                    {{Form::label('franchise', __('Franchise'), ['class' => 'title'])}}
                                </div>
                            </div>

                        </div>
                    {{ Form::close() }}
                </div> 
                <div class="tab-pane fade" id="nav2" role="tabpanel" aria-labelledby="nav2-tab">
                    {{ Form::open(['id'=>'frmJuridic2','autocomplete'=>'Off','class' => 'validate' ]) }}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">                                                 
                                    {{ Form::text('address', $client['client_address']['name_country'] .' - '. $client['client_address']['name_state'] .' - '. $client['client_address']['name_municipality'] .' - '. $client['client_address']['name_city'], ['class' => 'form-control', 'id'=> 'address','required'=>'required', 'placeholder' => __('Address'), 'readonly'=>'readonly']) }} 
                                    {{Form::label('address', __('Address'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('postal_code', $client['client_address']['postal_code'], ['class' => 'form-control', 'id'=> 'postal_code','required'=>'required', 'placeholder' => __('Postal code'), 'readonly'=>'readonly']) }} 
                                    {{Form::label('postal_code', __('Postal Code'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('edif_qta_torre', $client['client_address']['edf_qta_tow'], ['class' => 'form-control', 'id'=> 'edif_qta_torre', 'maxlength'=>'200','required'=>'required', 'placeholder' => __('Edif/Qta/Torre'), 'readonly'=>'readonly'])}}
                                    {{Form::label('edif_qta_torre', __('Edif/Qta/Torre'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('nro_floor', $client['client_address']['nro_floor'], ['class' => 'form-control', 'id'=> 'nro_floor', 'maxlength'=>'80','required'=>'required', 'placeholder' => __('Floor'), 'readonly'=>'readonly'])}}
                                    {{Form::label('nro_floor', __('Floor'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('apto_offic_loc_casa', $client['client_address']['apto_offic_loc_house'], ['class' => 'form-control', 'id'=> 'apto_offic_loc_casa', 'maxlength'=>'80', 'required'=>'required','placeholder' => __('apto/offic/loc/casa'), 'readonly'=>'readonly'])}}
                                    {{Form::label('apto_offic_loc_casa', __('apto/offic/loc/casa'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('urbanization', $client['client_address']['urbanization'], ['class' => 'form-control', 'id'=> 'urbanization', 'maxlength'=>'80','required'=>'required','placeholder' => __('Urbanization'), 'readonly'=>'readonly'])}}
                                    {{Form::label('urbanization', __('Urbanization'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('reference', $client['client_address']['reference_point'], ['class' => 'form-control', 'id'=> 'reference', 'maxlength'=>'255','required'=>'required', 'placeholder' => __('Reference'), 'readonly'=>'readonly'])}}
                                {{Form::label('reference', __('Reference'), ['class' => 'title'])}}
                            </div>
                        </div>
                    {{ Form::close() }}
                </div> 
                <div class="tab-pane fade" id="nav3" role="tabpanel" aria-labelledby="nav3-tab">
                    {{ Form::open(['id'=>'frmJuridic3','autocomplete'=>'Off','class' => 'validate' ]) }}
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{Form::text('legal_representative_info', $client['client_representative_legal']['representative']['rif'] .' / '.$client['client_representative_legal']['representative']['first_name'].' '.$client['client_representative_legal']['representative']['second_name'].' '.$client['client_representative_legal']['representative']['first_surname'].' '.$client['client_representative_legal']['representative']['second_surname'], ['class' => 'form-control', 'id'=> 'legal_representative_info','placeholder' => __('Legal representative'), 'readonly'=>'readonly']) }}
                                {{Form::label('legal_representative_info', __('Legal representative'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{  Form::text('expiration_date', $client['client_representative_legal']['representative']['expiration_year'].' - '.$client['client_representative_legal']['representative']['expiration_month'], ['id'=>'expiration_date','class'=>'form-control', 'readonly'=>'readonly' ,'required'=>'required', 'placeholder' => __('Expiration date'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('expiration_date', __('Expiration date'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('date_birth', $client['client_representative_legal']['representative']['date_birth'], ['id'=>'date_birth','class'=>'form-control', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Date Birth'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('date_birth', __('Date Birth'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('gender', $client['client_representative_legal']['representative']['name_gender']['name_gender'], ['id'=>'gender','class'=>'form-control', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Gender'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('gender', __('Gender'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('charge', $client['client_representative_legal']['position'], ['id'=>'charge','class'=>'form-control', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Nationality'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('charge', __('Nationality'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                           <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('local_telephone',  $client['client_representative_legal']['representative']['phone_id'] , ['id'=>'local_telephone','class'=>'form-control', 'required'=>'required', 'placeholder' => __('Local telephone'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('local_telephone', __('Local telephone'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('email', $client['client_representative_legal']['representative']['email'], ['class' => 'form-control', 'id'=> 'email','required'=>'required', 'placeholder' => __('Email'), 'readonly'=>'readonly']) }} 
                                    {{Form::label('email', __('Email'), ['class' => 'title'])}}
                                </div>
                            </div>

                        </div>
                    {{ Form::close() }}
                </div> 
                <div class="tab-pane fade" id="nav4" role="tabpanel" aria-labelledby="nav4-tab">
                    {{ Form::open(['id'=>'frmJuridic4','autocomplete'=>'Off','class' => 'validate' ]) }}
                                             <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{Form::text('legal_representative_info', $client['client_representative_commerce']['representative']['rif'] .' / '.$client['client_representative_commerce']['representative']['first_name'].' '.$client['client_representative_commerce']['representative']['second_name'].' '.$client['client_representative_commerce']['representative']['first_surname'].' '.$client['client_representative_commerce']['representative']['second_surname'], ['class' => 'form-control', 'id'=> 'legal_representative_info','placeholder' => __('Legal representative'), 'readonly'=>'readonly']) }}
                                {{Form::label('legal_representative_info', __('Trade representative'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{  Form::text('expiration_date', $client['client_representative_commerce']['representative']['expiration_year'].' - '.$client['client_representative_commerce']['representative']['expiration_month'], ['id'=>'expiration_date','class'=>'form-control', 'readonly'=>'readonly' ,'required'=>'required', 'placeholder' => __('Expiration date'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('expiration_date', __('Expiration date'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('date_birth', $client['client_representative_commerce']['representative']['date_birth'], ['id'=>'date_birth','class'=>'form-control', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Date Birth'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('date_birth', __('Date Birth'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('gender', $client['client_representative_commerce']['representative']['name_gender']['name_gender'], ['id'=>'gender','class'=>'form-control', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Gender'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('gender', __('Gender'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('charge', $client['client_representative_commerce']['position'], ['id'=>'charge','class'=>'form-control', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Nationality'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('charge', __('Nationality'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                           <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('local_telephone',  $client['client_representative_commerce']['representative']['phone_id'] , ['id'=>'local_telephone','class'=>'form-control', 'required'=>'required', 'placeholder' => __('Local telephone'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('local_telephone', __('Local telephone'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('email', $client['client_representative_commerce']['representative']['email'], ['class' => 'form-control', 'id'=> 'email','required'=>'required', 'placeholder' => __('Email'), 'readonly'=>'readonly']) }} 
                                    {{Form::label('email', __('Email'), ['class' => 'title'])}}
                                </div>
                            </div>

                        </div>
                    {{ Form::close() }}
                </div> 
                 <div class="tab-pane fade" id="nav5" role="tabpanel" aria-labelledby="nav5-tab">
                    {{ Form::open(['id'=>'frmJuridic5','autocomplete'=>'Off','class' => 'validate' ]) }}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('economic_sector', $client['economic_activity']['name_economic_sector'], ['class' => 'form-control', 'id'=> 'economic_sector', 'maxlength'=>'255','required'=>'required', 'placeholder' => __('Economic sector'), 'readonly'=>'readonly'])}}
                                    {{Form::label('economic_sector', __('Economic Sector'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('economic_activity', $client['economic_activity']['name_activity'], ['class' => 'form-control', 'id'=> 'economic_activity', 'maxlength'=>'255','required'=>'required', 'placeholder' => __('Economic Activity'), 'readonly'=>'readonly'])}}
                                    {{Form::label('economic_activity', __('Economic Activity'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('modality', $client['economic_activity']['name_modality'], ['class' => 'form-control', 'id'=> 'modality', 'maxlength'=>'255','required'=>'required', 'placeholder' => __('Modality'), 'readonly'=>'readonly'])}}
                                    {{Form::label('modality', __('Modality'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('product', $client['economic_activity']['name_product'], ['class' => 'form-control', 'id'=> 'product', 'maxlength'=>'255','required'=>'required', 'placeholder' => __('Product'), 'readonly'=>'readonly'])}}
                                    {{Form::label('product', __('Product'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div> 
                <div class="tab-pane fade" id="nav6" role="tabpanel" aria-labelledby="nav6-tab">
                    {{ Form::open(['id'=>'frmNatural6','autocomplete'=>'Off','class' => 'validate' ]) }}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('twitter', $client['miscellaneous'][0]['name_miscelaneous'], ['class' => 'form-control','maxlength'=>'80', 'id'=> 'twitter', 'placeholder' => __('Twitter'), 'readonly'=>'readonly']) }}
                                    {{Form::label('twitter', __('Twitter'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('facebook', $client['miscellaneous'][1]['name_miscelaneous'], ['class' => 'form-control', 'maxlength'=>'80','id'=> 'facebook', 'placeholder' => __('Facebook'), 'readonly'=>'readonly']) }}
                                    {{Form::label('facebook', __('Facebook'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('instagram', $client['miscellaneous'][2]['name_miscelaneous'], ['class' => 'form-control','maxlength'=>'80','id'=> 'instagram',  'placeholder' => __('Instagram'), 'readonly'=>'readonly']) }}
                                    {{Form::label('instagram', __('Instagram'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div> 
            </div>
        </div>
    </div>
</div>
 
                
