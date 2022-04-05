<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-building"></i>{{ __('Franchise creation') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['class'=>'validate','id' => 'franchisefrm','route' => 'franchise.store', 'autocomplete' => 'Off', 'method' => 'post']) }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{Form::text('name_franchise','', ['class' => 'form-control alphanum  required', 'id'=> 'name_franchise', 'placeholder' => __('Franchise Name'), 'required' => 'required']) }}
                                {{Form::label('name_franchise', __('Franchise Name'), ['class' => 'title'])}}
                            </div>
                        </div>           
                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('franchise')}}"> {{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>