<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-building"></i>{{ __('Create Trade Marks') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['class'=>'validate','id' => 'frmTradeMarksCreate','route' => 'trade_marks.create', 'autocomplete' => 'Off']) }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('name_trade_mark','', ['class' => 'form-control alphanum  required', 'id'=> 'name_trade_mark', 'placeholder' => __('Trade Marks Name'), 'required' => 'required','maxlength'=>'200' ]) }}
                                {{Form::label('labelname', __('Trade Marks Name'), ['class' => 'title'])}}
                            </div>
                        </div>                       
                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('trade_marks')}}"> {{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>