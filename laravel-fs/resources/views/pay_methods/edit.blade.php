<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-money-check-alt"></i>{{ __('Edit Method Pay') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['id' => 'frmMethodPayUpdate', 'class' => 'validate', 'route' => 'pay_methods.edit', 'autocomplete' => 'Off']) }}
                    {{ Form::hidden('id', $item['crypt_id'])}}
                    <div class="row">              
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('name_pay_method', $item['name_pay_method'], ['class' => 'form-control alphanum  required', 'id'=> 'name_pay_method', 'placeholder' => __('Method Pay'), 'required' => 'required','maxlength'=>'200']) }}
                                {{ Form::label('labeldescription', __('Method Pay'), ['class' => 'title'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('pay_methods')}}">{{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
 