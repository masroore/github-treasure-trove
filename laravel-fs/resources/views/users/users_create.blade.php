<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-user"></i>{{ __('Create User') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['route'=>'users.store','id'=>'frmStore','autocomplete'=>'Off','class' => 'validate' ]) }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">
                            {{ Form::label('avatar', __('Avatar'), ['class' => '']) }}
                            <div id="avatars">
                                @foreach($AVATARS as $value)
                                    <img data-value="{{$value}}" style="max-width:50px" alt="avatar" class="img-avatar img-fluid img-thumbnail ma-0" src="{{asset('avatar/'.$value)}}"/>
                                @endforeach
                            </div>
                            {{ Form::hidden('avatar', null, ['id'=> 'avatar'])}}
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::select('document_type', $document_type, null, ['class' => 'form-select required', 'id'=> 'document_type','placeholder'=> __('Select...'), 'required' => 'required' ]) }}

                                {!!Form::label('document_type', __('Type Document'), ['class' => 'title'])!!}
                            </div>
                        </div>    
                        <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                            <div class="form-group floating-label">
                                {{ Form::text('document', null, ['class' => 'form-control  number required', 'id'=> 'document', 'minlength'=>'6', 'maxlength'=>'8', 'placeholder'=>__('Document'), 'required' => 'required' ]) }}
                                {!!Form::label('document', __('Document'), ['class' => 'title'])!!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('name_user', null, ['class' => 'form-control alpha required', 'id'=> 'name_user','placeholder'=>__('Name'), 'required' => 'required' ]) }}
                                {!!Form::label('name_user', __('Name'), ['class' => 'title'])!!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('surname_user', null, ['class' => 'form-control alpha required', 'id'=> 'surname_user','placeholder'=>__('Surname'), 'required' => 'required' ]) }}  
                                {!!Form::label('surname_user', __('Surname'), ['class' => 'title'])!!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                            <div class="form-group floating-label">
                                {!!Form::label('operator', __('Operator'), ['class' => 'selec2label'])!!}
                                {{ Form::select('operator', $defaultCodeOperatorCountries, null, ['class' => 'form-control select2 required', 'id'=> 'operator','placeholder'=> __('Select...'), 'required' => 'required' ]) }} 
                            </div>
                        </div>    
                        <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                            <div class="form-group floating-label">
                                {{ Form::text('phone', null, ['class' => 'form-control  number required', 'id'=> 'phone','minlength'=>'7','maxlength'=>'7','placeholder'=> __('Phone'), 'required' => 'required' ]) }}
                                {!!Form::label('phone', __('Phone'), ['class' => 'title'])!!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">
                            <div class="form-group floating-label">
                                {{ Form::text('email', null, ['class' => 'form-control email required', 'id'=> 'email','placeholder'=> __('Email'), 'required' => 'required' ]) }} 
                                {!!Form::label('email', __('Email'), ['class' => 'title'])!!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::select('profile', $profile, null, ['class' => 'form-select required', 'id'=> 'profile','placeholder'=> __('Select...'), 'required' => 'required' ]) }}
                                {!!Form::label('profile', __('Profile'), ['class' => 'title'])!!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4 ">
                            <div class="form-group floating-label">
                                {{Form::select('storage[]', $storage , '', ["multiple"=>"multiple", 'id'=>'storage', 'class'=>'form-control select2 required', 'required'=>'required'])}}
                                {{Form::label('storage', __('Storage'), ['class' => 'selec2label'])}}
                            </div>
                        </div>
                        @if($Special_Permission_user == 1)
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                                <div class="form-group floating-label">                                    
                                    {{ Form::text('time_inactivity', $timer->timer, ['class' => 'form-control number required', 'id'=> 'time_inactivity','placeholder'=> __('Time Inactivity'), 'minlength'=>'3', 'maxlength'=>'10', 'required' => 'required' ]) }}
                                    {{ Form::label('time_inactivity', __('Time Inactivity'), ['class' => 'title']) }}
                                </div>
                            </div>
							<div class="col-xs-12 col-sm-12 col-md-12 mb-4">
								<div class="note-footer"><i class="fa fa-exclamation"></i>
									{{__('The field is in seconds. The minimum is 180 seconds which is equivalent to 3 minutes.')}}
								</div>
							</div>

                        @endif
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    {{ Form::checkbox('special_permission', 1, false, ['class' => 'form-check-input', 'id'=> 'special_permission']) }}
                                    {{Form::label('special_permission', __('Special Permission'), ['class' => 'form-check-label'])}}  
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                {{ Form::checkbox('sensitive_info', 1, false, ['class' => 'form-check-input', 'id'=> 'sensitive_info']) }} 
                                {{Form::label('sensitive_info', __('Sensitive Info'), ['class' => 'form-check-label'])}} 
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('users')}}">{{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>    
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $('.img-avatar').on('click', function(){
        $('.img-avatar').removeClass('img-avatar-border');
        $(this).addClass('img-avatar-border');
        $('#avatar').val($(this).attr('data-value'));
    });
    $('#avatars').find('img')[0].click();
});
</script>
