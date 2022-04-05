<div class="content-table"> 
    <h3>{{ __('Client Data') }}</h3>
    <div class="content-space"> 
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav1-tab" data-bs-toggle="tab" data-bs-target="#nav1" type="button" role="tab" aria-controls="nav1" aria-selected="true">{{ __('Client data') }}</button>
            <button class="nav-link" id="nav2-tab" data-bs-toggle="tab" data-bs-target="#nav2" type="button" role="tab" aria-controls="nav2" aria-selected="false">{{ __('Address') }}</button>
            <button class="nav-link" id="nav3-tab" data-bs-toggle="tab" data-bs-target="#nav3" type="button" role="tab" aria-controls="nav3" aria-selected="false">{{ __('Economic Activity') }}</button>
            <button class="nav-link" id="nav4-tab" data-bs-toggle="tab" data-bs-target="#nav4" type="button" role="tab" aria-controls="nav4" aria-selected="false">{{ __('Miscellaneous') }}</button>
          </div>
        </nav>
        <div id="bodytable">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav1" role="tabpanel" aria-labelledby="nav1-tab">
                    {{ Form::open(['id'=>'frmNatural1','autocomplete'=>'Off','class' => 'validate' ]) }}
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{Form::text('client', $client['rif'] . ' / ' .$client['name_client'], ['class' => 'form-control', 'id'=> 'client','placeholder' => __('Client'), 'readonly'=>'readonly']) }}
                                {{Form::label('client', __('Client'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{  Form::text('expiration_date', $client['person']['expiration_year'] . ' - ' . $client['person']['expiration_month'], ['id'=>'expiration_date','class'=>'form-control', 'readonly'=>'readonly' ,'required'=>'required', 'placeholder' => __('Expiration date'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('expiration_date', __('Expiration date'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('date_birth', $client['person']['date_birth'], ['id'=>'date_birth','class'=>'form-control', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Date Birth'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('date_birth', __('Date Birth'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('nationality', $client['person']['name_nationality']['name_nationality'], ['id'=>'nationality','class'=>'form-control', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Nationality'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('nationality', __('Nationality'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('gender', $client['person']['name_gender']['name_gender'], ['id'=>'gender','class'=>'form-control', 'readonly'=>'readonly' , 'required'=>'required', 'placeholder' => __('Gender'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('gender', __('Gender'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                      
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('local_telephone', $client['person']['name_telephone_operator_house']['code'] . ' - ' . $client['person']['phone_house'], ['id'=>'local_telephone','class'=>'form-control', 'required'=>'required', 'placeholder' => __('Local telephone'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('local_telephone', __('Local telephone'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                <div class="form-group floating-label">
                                    {{Form::text('cell_telephone',  $client['person']['name_telephone_operator_cell']['code'] .' - '.$client['person']['phone_cell'], ['id'=>'cell_telephone','class'=>'form-control', 'required'=>'required', 'placeholder' => __('Cell telephone'), 'readonly'=>'readonly' ]) }}
                                    {{Form::label('cell_telephone', __('Cell telephone'), ['class' => 'title'])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('email', $client['person']['email'], ['class' => 'form-control', 'id'=> 'email','required'=>'required', 'placeholder' => __('Email'), 'readonly'=>'readonly']) }} 
                                    {{Form::label('email', __('Email'), ['class' => 'title'])}}
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div> 
                <div class="tab-pane fade" id="nav2" role="tabpanel" aria-labelledby="nav2-tab">
                    {{ Form::open(['id'=>'frmNatural2','autocomplete'=>'Off','class' => 'validate' ]) }}
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
                    {{ Form::open(['id'=>'frmNatural3','autocomplete'=>'Off','class' => 'validate' ]) }}
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
                <div class="tab-pane fade" id="nav4" role="tabpanel" aria-labelledby="nav4-tab">
                    {{ Form::open(['id'=>'frmNatural4','autocomplete'=>'Off','class' => 'validate' ]) }}
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
 
                
