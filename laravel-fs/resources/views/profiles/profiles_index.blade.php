<div class="content-table">
    <h3>{{ __('Profiles') }}</h3>

    <a href="{{route('profiles.create')}}" class="btn btn-primary title new link_ajax" data-dataType="html">{{ __('New') }}</a>

    <table class="dataTable table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th scope='col'>{{__('Profile')}}</th>
                <th scope='col'>{{__('Description')}}</th>
                <th scope='col'>{{__('Code')}}</th>
                <th scope='col'>{{__('Actions')}}</th>
                <th scope='col'>{{__('Permissions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($profile as $key => $value)
            <tr>
                <td>{{textUpper($value['name_profile'])}}</td>
                <td>{{textUpper($value['description'])}}</td>
                <td>{{FullSerial($value['code'],4)}}</td>
                 @if($value['status'] == 1)
                <td> 
                    <a class="btn btn-moderation edit link_ajax" href="{{route('profiles.edit',$value['crypt_id'])}}" data-dataType="html"><i class="fa fa-pen"></i> {{ __('Edit') }} </a>
                    <a class="btn btn-moderation delete link_ajax" href="{{route('profiles.delete',$value['crypt_id'])}}" data-dataType="json"><i class="fa fa-trash"></i> {{ __('Delete') }} </a>
                </td>            
                @else
                <td> 
                    <a class="btn btn-moderation active link_ajax" href="{{route('profiles.reactivate',$value['crypt_id'])}}" data-dataType="json"><i class="fa fa-check"></i> {{ __('Activate') }} </a>
                </td>
                @endif 
                <td> <a class="btn btn-moderation edit link_ajax" href="{{route('profiles.process',$value['crypt_id'])}}" data-dataType="html"><i class="fa fa-pen"></i> {{ __('Assign Access Profile') }} </a> 
                </td>          
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


        