<div class="content-table">
    <h3>{{ __('Assign Access Profile') }}</h3>

    <div class="content-space">

        <ul class="nav nav-tabs nav-justified" id="pills-tab" role="tablist">
            @foreach($menu as $key => $value)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{($key==0 ? 'active':'' )}}" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#menu{{$value['id']}}" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{__('menu.'.$value['name_menu'])}}</button>
                </li>
           @endforeach
        </ul>

        <div class="bodytable">
            {!! Form::open(array('action'=>'ProfileProcessController@store', 'method'=>'post', "class"=>"validate")) !!}
                {{ Form::hidden('profile_id', $profile_id) }}
            <div class="tab-content body-size" id="pills-tabContent">
                @foreach($menu as $key => $value)
                    <div class="tab-pane fade show {{($key==0 ? 'active':'' )}}" id="menu{{$value['id']}}" role="tabpanel" aria-labelledby="pills-home-tab">
                        <table class="">
                            <thead>
                               <tr>
                                    <th scope='col'>{{__('Select')}}</th>
                                    <th scope='col'>{{__('Name')}}</th>
                                    <th scope='col'>{{__('Description')}}</th>
                               </tr>
                            </thead>
                            <tbody>
                                @foreach($value['process'] as $key2 => $value2)
                                    <tr>                                            
                                        <td>{{ Form::checkbox('special_permission[]', $value2['id'], (in_array($profile_id, $value2['profile_array'])) , ['class' => 'form-check-input']) }} </td>
                                        <td>{{textUpper(__('menu.'.$value2['name_process']))}}</td>
                                        <td>{{textUpper(__('menu.'.$value2['description']))}}</td>
                                    </tr>
                                @endforeach
                           </tbody>
                        </table>
                   </div>
                @endforeach
                
            </div>
            <div class="col-5 mx-auto">  
                    <a class="btn btn-secondary back link_ajax" data-dataType="html" href="{{route('profiles')}}"> {{ __('Back') }} </a>
		    {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'type' => 'submit']) }}
                </div>
            {!! Form::close() !!}

        </div> 

    </div>


</div>
 




