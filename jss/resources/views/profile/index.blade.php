@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
?>

@section('styles')
 
@endsection

@section('scripts')
    <script>
        var HOLDER = '{!! STAFF_LEVEL_SHAREHOLDER !!}';
        var IS_HOLDER = '{!! $userinfo['pos'] !!}';
    </script>
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="page-header">
                <div class="col-md-3">
                    <h4>
                        <b>{{trans("common.label.profile")}}</b>
                    </h4>
                </div>
            </div>
            @if ($errors->any())
                <div class="row">
                    <div class="row col-md-12">
                        <div class="alert alert-danger alert-light alert-dismissible" style="padding-left: 12px;" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="text-danger icon-remove"></i></button>
                            @foreach ($errors->all() as $error)
                                <strong> {{ $error }}</strong><br/>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if (Session('err_msg'))
                <div class="row">
                    <div class="row col-md-12">
                        <div class="alert alert-danger alert-light alert-dismissible" role="alert" style="padding-left: 12px;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="text-danger icon-remove"></i></button>
                            <strong> {{ Session('err_msg') }}</strong><br/>
                        </div>
                    </div>
                </div>
            @endif

            @if(Session('message'))
                <div class="row">
                    <div class="row col-md-12">
                        <div class="alert alert-info" style="padding-left: 12px;">
                            <button class="close" data-dismiss="alert">
                                <i class="text-info icon-remove"></i>
                            </button>
                            <span class="text-info">{{ Session('message') }}</span>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="row col-md-12" style="margin-bottom: 4px;">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <div class="btn-group f-right">
                        <a id="btnSave" type="button" class="btn btn-sm btn-success" style="width: 80px">
                            <i class="icon-save"></i>{{ trans('common.label.save') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <form id="validation-form" action="{{ route('profile.update') }}" role="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $userinfo['id'] }}">

                    <div class="col-xs-12 col-sm-3 center">
                        <div>
                            <label class="profile-picture" style="width: 140px; height: 160px;" for="attachment">
                                <img class="editable img-responsive editable-click editable-empty" id="avatar" style="width: 100%; height: 100%; cursor: pointer;" alt="{{ $userinfo['realname'] }}" src="{{ !isset($userinfo['avatar']) || $userinfo['avatar'] == '' ? cAsset('assets/avatars/user.png') : cAsset($userinfo['avatar']) }}">
                            </label>
                            <input type="file" style="display: none;" id="attachment" name="avatar" accept="image/png, image/jpeg">

                            <div class="space-4"></div>

                            <div class="width-80 label label-{{ g_enum('StaffLevelData')[$userinfo['pos']][1] }} label-xlg arrowed-in arrowed-in-right">
                                <div class="inline position-relative">
                                    <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                        <i class="ace-icon fa fa-circle light-green"></i>
                                        &nbsp;
                                        <span class="white">{{ g_enum('StaffLevelData')[$userinfo['pos']][0] }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-xs-12 col-sm-9">
                        <div class="profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.name")}}</div>
                                <div class="profile-info-value">
                                    <input type="text" class="form-control add-td-input" name="name" id="name" value="{{ isset($userinfo) ? $userinfo['realname'] : old('name') }}" required>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.loginID")}}</div>

                                <div class="profile-info-value">
                                    <input type="text" class="form-control add-td-input" name="account" id="account" value="{{ isset($userinfo) ? $userinfo['account'] : old('account') }}" disabled>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("common.label.old_password")}}</div>
                                <div class="profile-info-value">
                                    <input type="password" name="oldpassword" class="form-control add-td-input" value="{{ old('oldpassword') }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("common.label.password")}}</div>
                                <div class="profile-info-value">
                                    <input type="password" name="password" class="form-control add-td-input" value="{{ old('password') }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("common.label.confirm_password")}}</div>
                                <div class="profile-info-value">
                                    <input type="password" name="password_confirmation" class="form-control add-td-input" value="" autocomplete="off">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.phoneNumber")}}</div>
                                <div class="profile-info-value">
                                    <input type="tel" id="rantel" name="phone" class="form-control add-td-input" value="{{ isset($userinfo) ? trim($userinfo['phone']) : old('phone') }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.enterDate")}}</div>

                                <div class="profile-info-value">
                                    <input class="form-control date-picker add-td-input" style="text-align: left!important;" name="enterdate" type="text" data-date-format="yyyy-mm-dd" value="{{ isset($userinfo) ? $userinfo['entryDate'] : old('enterdate') }}" disabled autocomplete="off">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.missDate")}}</div>

                                <div class="profile-info-value">
                                    <input class="form-control date-picker add-td-input" style="text-align: left!important;" name="releaseDate" type="text" data-date-format="yyyy-mm-dd" value="{{ isset($userinfo) ? $userinfo['releaseDate'] : old('releaseDate') }}" disabled autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.remark")}}</div>

                                <div class="profile-info-value">
                                    <input type="text" class="form-control add-td-input" name="remark" id="remark" value="{{ isset($userinfo) ? $userinfo['remark'] : old('remark') }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:8px;" class="d-none">
                        <div class="col-md-12">
                            <div class="row" style="margin-top:20px;" id="menu-list">
                                <h4>权限</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                        <?php $index = 0; $cflag = true; ?>
                                        @foreach($pmenus as $pmenu)
                                            @if(isset($userid))
                                                @if(in_array($pmenu['id'], explode(',', $userinfo['menu'])))
                                                    <?php $cflag = true; ?>
                                                @else
                                                    <?php $cflag = false; ?>
                                                @endif

                                                <tr id="{{'row'.$index}}">
                                                    @if($pmenu['parentId'] == 0)
                                                        <td class="custom-td-label">
                                                            {{$pmenu['title']}}
                                                        </td>
                                                    @endif
                                                    <td class="custom-td-text" style="width: 3%; text-align: center">
                                                        <input type="checkbox" onclick="check({{$index}})" id="{{'group'.$index}}" name="{{'group'.$index}}" @if ($cflag==true) checked="checked" @endif>
                                                        <input type="checkbox" id="{{$pmenu['id']}}" name="{{$pmenu['id']}}" style="display: none" @if ($cflag==true) checked="checked" @endif>
                                                    </td>
                                            @else
                                                <tr id="{{'row'.$index}}">
                                                    @if($pmenu['parentId']==0)
                                                        <td class="custom-td-label">
                                                            {{$pmenu['title']}}
                                                        </td>
                                                    @endif
                                                    <td class="custom-td-text" style="width: 3%; t ext-align: center">
                                                        <input type="checkbox" onclick="check({{$index}})" id="{{'group'.$index}}" checked="checked" name="{{'group'.$index}}">
                                                        <input type="checkbox" id="{{$pmenu['id']}}" name="{{$pmenu['id']}}" style="display: none" checked>
                                                    </td>
                                            @endif
                                                    <td class="custom-td-text" style="width: 77%">
                                                        <div class="row">
                                                            @foreach($cmenus[$index] as $menu)
                                                                <?php $flag1 = false ?>
                                                                @if(isset($userid))
                                                                    @if(in_array($menu['id'], explode(',',$userinfo['menu'])))
                                                                        <?php $flag1 = true ?>
                                                                    @endif
                                                                @endif
                                                                <div class="col-md-2">&nbsp
                                                                    <input type="checkbox" class="{{'row'.$index}}" onclick="checkchild({{$index}}, this)" id="{{'row'.$menu['id']}}" name="{{'row'.$menu['id']}}" @if(($cflag==true) || ($flag1==true)) checked="checked" @endif>
                                                                    <input type="checkbox" id="{{$menu['id']}}" name="{{$menu['id']}}" style="display: none" @if (($cflag==false) && ($flag1==true)) checked="checked" @endif>
                                                                    <label>&nbsp{{$menu['title']}}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php $index++?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" id="ship-list">
                                <h4>SHIP SELECTION</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td  colspan="3" style="text-align: left!important;">
                                                    <?php $registerList = explode(',', $userinfo['shipList']);?>
                                                    <select multiple="multiple" class="chosen-select form-control width-100" name="shipList[]" data-placeholder="选择船舶...">
                                                        @foreach($shipList as $key => $item)
                                                            <option value="{{ $item['IMO_No'] }}" {{ in_array($item['IMO_No'], $registerList) ? 'selected' : '' }}>{{ $item['NickName'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" style="display: none;" id="submit">
                </form>
            </div>
        </div>
    </div>
    <script>
        var menuId = 10;
        function submit() {
            $('#submit').click();
            // $('#validation-form').submit();
        }

        function goBackPage() {
            location.href="userInfoListView";
        }
    </script>

    <script type="text/javascript">
        var token = '{!! csrf_token() !!}';
        var submitted = false;
        $("#btnSave").on('click', function() {
            submitted = true;
            submit();
        });

        $(function() {
            $('[type="checkbox"]').attr('disabled', true);
            @if(isset($state))
            var state = '{!! $state !!}';
            if(state == 'success') {
                $.gritter.add({
                    title: '成功',
                    text: '职员信息已正确保存。',
                    class_name: 'gritter-success'
                });
            } else {
                $.gritter.add({
                    title: '错误',
                    text: state,
                    class_name: 'gritter-error'
                });
            }
            @endif

            if(IS_HOLDER == HOLDER) {
                $('#menu-list').hide();
                $('#ship-list').show();
            } else {
                $('#menu-list').show();
                $('#ship-list').hide();
            }

        });

        $('body').on('click', function(e) {
            var current = null;
            if ($(event.target).attr('class') == 'form-control dynamic-select-span' || $(event.target).attr('class') == 'dynamic-select__trigger') {
                current = $(event.target).closest('.dynamic-select-wrapper');
            }
            for (const selector of document.querySelectorAll(".dynamic-select-wrapper")) {
                if (current == null || selector != current[0])
                    selector.firstElementChild.classList.remove('open');
            }
        });

        $('[name=pos]').on("change", function() {
            if($(this).val() == HOLDER) {
                $('#menu-list').hide();
                $('#ship-list').show();
            } else {
                $('#menu-list').show();
                $('#ship-list').hide();
            }
        })
        function check(id) {
            var allcheck = document.getElementById('group' + id);
            var checks = document.getElementsByClassName('row' + id);

            for (var i = 0; i < checks.length; i++) {
                if (allcheck.checked == true) {
                    allcheck.nextElementSibling.checked = true;
                    checks[i].checked = true;
                } else {
                    allcheck.nextElementSibling.checked = false;
                    checks[i].checked = false;
                }
                checks[i].nextElementSibling.checked = false;
            }
        }

        function checkchild(id, checkObj) {
            var allcheck = document.getElementById('group' + id);
            var checks = document.getElementsByClassName('row' + id);
            checkObj.nextElementSibling.checked = checkObj.checked;

            var flag = true;
            for (var i = 0; i < checks.length; i++) {
                if (checks[i].checked == true) {
                    continue;
                } else {
                    flag = false;
                    break;
                }
            }
            if (flag == true) {
                allcheck.checked = true;
                allcheck.nextElementSibling.checked = true;
                for (var i = 0; i < checks.length; i++)
                    checks[i].nextElementSibling.checked = false;
            } else {
                allcheck.checked = false;
                allcheck.nextElementSibling.checked = false;
                for (var i = 0; i < checks.length; i++)
                    checks[i].nextElementSibling.checked = checks[i].checked;
            }
        }

        $('#attachment').on('change', function(e) {
            e.preventDefault();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("#avatar").attr('src', e.target.result);
            }

            reader.readAsDataURL(e.target.files[0]);
        });

    </script>

    <script src="{{ asset('/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/js/dycombo.js') }}"></script>
@stop
