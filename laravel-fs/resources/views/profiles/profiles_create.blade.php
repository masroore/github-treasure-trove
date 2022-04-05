<div class="content-table">  

    <div class="row">

        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-user"></i>{{ __('Create Profile') }}</h3> 
        </div>

        <div class="col-md-9">

            <div class="content-space te-0">  

                {{ Form::open(['route'=>'profiles.store','id'=>'frm_profiles_create','autocomplete'=>'Off', 'class' => 'validate' ]) }}
                    <div class="row"> 
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">

                            <div class="form-group floating-label">


                                {{ Form::hidden('status', 1)}}
                                {{ Form::text('name_profile', null, ['class' => 'form-control alphanum required', 'id'=> 'name_profile', 'placeholder'=>__('Profile'), 'required' => 'required','maxlength'=>'50']) }}
                                
                                {{ Form::label('name_profile', __('Profile'), ['class' => 'title'])}}
                               

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">

                            <div class="form-group floating-label">

                                {{ Form::text('description', null, ['class' => 'form-control alphanum required', 'id'=> 'description', 'placeholder'=>__('Description'), 'required' => 'required', 'maxlength'=>'200']) }}

                                {{ Form::label('description', __('Description'), ['class' => 'title'])}}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">

                            <div class="form-group floating-label">

                                {{ Form::text('code', $Code, ['class' => 'form-control number required', 'id'=> 'code', 'placeholder'=>__('code'),'minlength'=>'4', 'maxlength'=>'4', 'required' => 'required', 'readonly'=> true]) }}

                                {{ Form::label('code', __('code'), ['class' => 'title'])}}

                            </div>

                        </div>
                            
                    </div>    

                    <div class="col-5 mx-auto">
                            
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType="html" href="{{route('profiles')}}">{{ __('Back') }} </a>

                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'type' => 'submit']) }}

                    </div>

                {{ Form::close() }}

           </div>

        </div>

    </div>

</div> 