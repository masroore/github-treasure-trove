<div class="content-table">  

    <div class="row">

        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-user"></i>{{ __('Edit Profil') }}</h3> 
        </div>

        <div class="col-md-9">

            <div class="content-space te-0">  

                {{ Form::open(['route'=>'profiles.update','id'=>'frm_profiles_update','autocomplete'=>'Off', 'class' => 'validate' ]) }}

                    <div class="row"> 

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">

                            <div class="form-group floating-label">


                                {{ Form::hidden('id', (isset($item['crypt_id']))?$item['crypt_id']:"")}}
                                {{ Form::text('name_profile_edit', (isset($item['name_profile']))?$item['name_profile']:"", ['class' => 'form-control alphanum required', 'id'=> 'name_profile_edit', 'placeholder'=>__('Profile'), 'required' => 'required','maxlength'=>'200']) }}   
                                
                                {{ Form::label('name_profile_edit', __('Profile'), ['class' => 'title'])}}
                               

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">

                            <div class="form-group floating-label">
                            
                                {{ Form::text('description_edit', (isset($item['description']))?$item['description']:"", ['class' => 'form-control onlyText required', 'id'=> 'description_edit', 'placeholder'=>__('Description'), 'required' => 'required','maxlength'=>'50']) }}

                                {{ Form::label('description_edit', __('Description'), ['class' => 'title'])}}
                        
                            </div>

                        </div>

                         <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">

                            <div class="form-group floating-label">


                                {{ Form::select('status', [0=>__('Inactive'), 1=>__('Active')], $item['status'], ['class' => 'form-select required', 'id'=> 'status', 'required' => 'required']) }}   
                                
                                {{ Form::label('status', __('status'), ['class' => 'title'])}}
                               

                            </div>

                        </div>

                    </div>

                    <div class="col-5 mx-auto">
                         
                        <a class="btn btn-secondary back link_ajax" data-dataType="html" href="{{route('profiles')}}">{{ __('Back') }} </a>

                        {{ Form::button(__('update'), ['class' => 'btn btn-primary save', 'type' => 'submit']) }}

                    </div>

                {{ Form::close() }} 

           </div>

        </div>

    </div>

</div> 