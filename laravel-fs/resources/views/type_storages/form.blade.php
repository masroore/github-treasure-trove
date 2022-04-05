<div class="content-table">  

    <div class="row">

        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-building"></i>{{ $modo }} {{__('Storage')}} </h3> 
        </div>

        <div class="col-md-9">

            <div class="content-space te-0">  

                <div class="row">   

                    @if(count($errors)>0)

                        <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li> {{ $error }} </li>
                        @endforeach
                    </ul>
                        </div>
                    @endif
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">  
                        <div class="form-group floating-label">
                            {!!Form::label('type_storages', __('Description'), ['class' => 'selec2label'])!!}
                            {!!Form::text('description', $value = isset($typeStorages[0]['description'])? $typeStorages[0]['description']:'', ['class' => 'form-control required', 'required' => 'required', 'maxlength'=>'50']) !!}
                            {{ Form::hidden('id', (isset($typeStorages[0]['crypt_id']))?$typeStorages[0]['crypt_id']:"")}}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                        <div class="form-group floating-label">
                            {{ Form::select('bank', $bank, (isset($typeStorages[0]['bank_id']))?$typeStorages[0]['bank_id']:"", ['class' => 'form-select required', 'id'=> 'bank','placeholder'=>__('Select...')]) }} 
                            {!!Form::label('bank', __('Bank'), ['class' => 'title'])!!}
                        </div>
                    </div>
                </div>
                <div class="col-5 mx-auto">
                    <a class="btn btn-secondary back link_ajax" href="{{url('M0002')}}" data-dataType="html">{{__('Back')}}</a>
                    {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'type' => 'submit']) }}
                </div>
            </div>
        </div>
    </div>
</div>

