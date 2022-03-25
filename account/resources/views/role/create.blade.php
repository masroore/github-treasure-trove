<div class="card bg-none card-box">
    {{Form::open(array('url'=>'roles','method'=>'post'))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-control-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Role Name')))}}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                @if(!empty($permissions))
                    <h6 class="my-3">{{__('Assign Permission to Roles')}}</h6>
                    <table class="table table-striped mb-0" id="dataTable-1">
                        <thead>
                        <tr>
                            <th>{{__('Module')}} </th>
                            <th>{{__('Permissions')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $modules=['dashboard','user','role','proposal','invoice','bill','revenue','payment','proposal product','invoice product','bill product','goal','credit note','debit note','bank account','transfer','transaction','product & service','customer','vender','plan','constant tax','constant category','constant unit','constant custom field','company settings','assets','chart of account','journal entry','report'];
                           if(\Auth::user()->type == 'super admin'){
                               $modules[] = 'language';
                               $modules[] = 'permission';
                           }
                        @endphp
                        @foreach($modules as $module)
                            <tr>
                                <td>{{ ucfirst($module) }}</td>
                                <td>
                                    <div class="row ">
                                        @if(in_array('manage '.$module,(array) $permissions))
                                            @if($key = array_search('manage '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Manage',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('create '.$module,(array) $permissions))
                                            @if($key = array_search('create '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Create',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('edit '.$module,(array) $permissions))
                                            @if($key = array_search('edit '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Edit',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('delete '.$module,(array) $permissions))
                                            @if($key = array_search('delete '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Delete',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('show '.$module,(array) $permissions))
                                            @if($key = array_search('show '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Show',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif


                                        @if(in_array('buy '.$module,(array) $permissions))
                                            @if($key = array_search('buy '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Buy',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('send '.$module,(array) $permissions))
                                            @if($key = array_search('send '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Send',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif

                                        @if(in_array('create payment '.$module,(array) $permissions))
                                            @if($key = array_search('create payment '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Create Payment',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('delete payment '.$module,(array) $permissions))
                                            @if($key = array_search('delete payment '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Delete Payment',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('income '.$module,(array) $permissions))
                                            @if($key = array_search('income '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Income',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('expense '.$module,(array) $permissions))
                                            @if($key = array_search('expense '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Expense',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('income vs expense '.$module,(array) $permissions))
                                            @if($key = array_search('income vs expense '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Income VS Expense',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('loss & profit '.$module,(array) $permissions))
                                            @if($key = array_search('loss & profit '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Loss & Profit',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('tax '.$module,(array) $permissions))
                                            @if($key = array_search('tax '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Tax',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif


                                        @if(in_array('invoice '.$module,(array) $permissions))
                                            @if($key = array_search('invoice '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Invoice',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('bill '.$module,(array) $permissions))
                                            @if($key = array_search('bill '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Bill',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('duplicate '.$module,(array) $permissions))
                                            @if($key = array_search('duplicate '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Duplicate',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('balance sheet '.$module,(array) $permissions))
                                            @if($key = array_search('balance sheet '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Balance Sheet',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('ledger '.$module,(array) $permissions))
                                            @if($key = array_search('ledger '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Ledger',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('trial balance '.$module,(array) $permissions))
                                            @if($key = array_search('trial balance '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Trial Balance',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>
