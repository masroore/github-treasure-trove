@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
?>

@section('styles')
    <!--link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet"/-->

    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/-->
@endsection

@section('scripts')
    <script>
        var HOLDER = '{!! STAFF_LEVEL_SHAREHOLDER !!}';
        var CAPTAIN = '{!! STAFF_LEVEL_CAPTAIN !!}';
        var IS_HOLDER = '{!! $userinfo['pos'] !!}';
    </script>
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="page-header">
                <div class="col-md-3">
                    <h4><b>{{trans("orgManage.title.MemberInfo")}}</b>
                    </h4>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger alert-light alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="zmdi zmdi-close"></i></button>
                    @foreach ($errors->all() as $error)
                        <strong><i class="zmdi zmdi-alert-triangle"></i> {{ $error }}</strong><br/>
                    @endforeach
                </div>
            @endif
            <div class="row col-md-12" style="margin-bottom: 4px;">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <div class="btn-group f-right">
                        <a id="btnPrev" class="btn btn-sm btn-primary btn-add" style="width: 80px" href="/org/userInfoListView">
                            <i class=""></i>< {{trans("orgManage.captions.prevPage")}}
                        </a>
                        @if(isset($userid)>0)
                            <a id="btnDelete" class="btn btn-sm btn-danger" style="width: 80px" onclick="javascript:deleteMember('{{ $userid }}')">
                                <i class="icon-remove"></i>{{ trans('common.label.delete') }}
                            </a>
                        @endif
                        <a id="btnSave" type="button" class="btn btn-sm btn-success" style="width: 80px">
                            <i class="icon-save"></i>{{ trans('common.label.save') }}
                        </a>
                    </div>
                </div>
            </div>

            @if(isset($userid)>0)
                <form id="validation-form" action="memberupdate" role="form" method="POST" enctype="multipart/form-data">
            @else
                <form id="validation-form" action="memberadder" role="form" method="POST" enctype="multipart/form-data">
            @endif
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="userid" id="userid" value="@if(isset($userid)){{$userid}} @endif">

                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.name")}}<span class="require">*</span>:</div>
                                <div class="profile-info-value">
                                    <input type="text" class="form-control no-border" name="name" id="name" value="{{ isset($userinfo) ? $userinfo['realname'] : old('name') }}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.loginID")}}<span class="require">*</span>:</div>
                                <div class="profile-info-value">
                                    <input type="text" class="form-control no-border" name="account" id="account" {{ isset($userinfo) ? 'readonly' : '' }} value="{{ isset($userinfo) ? $userinfo['account'] : old('account') }}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.officePosition")}}<span class="require">*</span>:</div>
                                <div class="profile-info-value">
                                    <select class="form-control no-border" id="pos" name="pos">
                                        <option value="0"></option>
                                        @foreach(g_enum('StaffLevelData') as $key => $item)
                                            <option value="{{ $key }}" {{ (isset($userinfo) && ($userinfo['pos']==$key)) || old('pos') == $key ? 'selected' : '' }} >{{ $item[0] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.phoneNumber")}}:</div>
                                <div class="profile-info-value">
                                    <div class="input-group">
                                        <input type="tel" id="rantel" name="phone" class="form-control no-border" value="{{ isset($userinfo) ? trim($userinfo['phone']) : old('phone') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.enterDate")}}:</div>
                                <div class="profile-info-value">
                                    <input class="form-control no-border date-picker" name="enterdate" type="text" data-date-format="yyyy-mm-dd" value="{{ isset($userinfo) ? $userinfo['entryDate'] : old('enterdate') }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.missDate")}}:</div>
                                <div class="profile-info-value">
                                    <div class="input-group">
                                        <input class="form-control no-border date-picker" style="text-align: left!important;" name="releaseDate" type="text" data-date-format="yyyy-mm-dd" value="{{ isset($userinfo) ? $userinfo['releaseDate'] : old('releaseDate') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">{{trans("orgManage.captions.remark")}}:</div>
                                <div class="profile-info-value">
                                    <input type="text" class="form-control no-border" name="remark" id="remark" value="{{ isset($userinfo) ? $userinfo['remark'] : old('remark') }}" required autocomplete="off">
                                </div>
                            </div>
                            @if(isset($userinfo))
                                <div class="profile-info-row">
                                    <div class="profile-info-name">{{trans("orgManage.captions.resetPass")}}:</div>
                                    <div class="profile-info-value">
                                        <div class="input-group">
                                            <input type="checkbox" class="form-control no-border" style="width: fit-content; margin-right: 10px; margin-left: 10px;margin-bottom:5px;" name="password_reset" id="password_reset">
                                            <span>* 使用密码初始化功能，可将该职员的密码改为 {{ DEFAULT_PASS }}。</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-20" id="menu-list">
                    <div class="col-lg-12">
                        <h4>职员权限</h4>
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>
                            <?php $index = 0; $cflag = false; ?>
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
                                        <td class="custom-td-text" style="width: 3%; text-align: center">
                                            <input type="checkbox" onclick="check({{$index}})" id="{{'group'.$index}}" name="{{'group'.$index}}">
                                            <input type="checkbox" id="{{$pmenu['id']}}" name="{{$pmenu['id']}}" style="display: none">
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
                <div class="row mt-20" id="ship-list">
                    <div class="col-lg-12">
                        <h4>SHIP SELECTION</h4>
                        <?php $registerList = explode(',', $userinfo['shipList']);?>
                        <select multiple="multiple" class="chosen-select form-control width-100" id="select-ship-list" name="shipList[]" data-placeholder="选择船舶...">
                            @foreach($shipList as $key => $item)
                                <option value="{{ $item['IMO_No'] }}" {{ in_array($item['IMO_No'], $registerList) ? 'selected' : '' }}>{{ $item['NickName'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script type="text/javascript">
        var menuId = 10;
        function submit() {
            if ($('#name').val() == '') {
                $('#name').focus();
                return;
            }

            if ($('#account').val() == '') {
                $('#account').focus();
                return;
            }

            if ($('#pos').val() <= 0) {
                alert("Please select position!");
                return;
            }

            if(IS_HOLDER == HOLDER || IS_HOLDER == CAPTAIN)
            {
                var ship_list = $('#select-ship-list').val();
                if (ship_list == null) {
                    alert("Please select a ship!");
                    $('#select-ship-list').focus();
                    return;
                } else {
                    if (ship_list.length != 1) {
                        alert("It's allowed to select only one ship!");
                        $('#select-ship-list').focus();
                        return;
                    }
                }
            }

            submitted = true;
            $('#validation-form').submit();
        }

        function alertAudio() {
            document.getElementById('warning-audio').play();
        }

        function deleteMember(userid) {
            alertAudio();
            bootbox.confirm("Are you sure you want to delete?", function (result) {
                if (result) {
                    $.ajax({
                        url: BASE_URL + 'org/memberInfo/delete',
                        type: 'post',
                        data: {
                            userid: userid,
                        },
                        success: function(result, status, xhr) {
                            console.log(result);
                            if(result == 1) {
                                location.href = BASE_URL + "org/userInfoListView?menuId=" + menuId;
                            } else {

                            }
                        }
                    })
                }
            });
        }
        function goBackPage() {
            location.href="userInfoListView";
        }

        var submitted = false;
        $("#btnSave").on('click', function() {
            submit();
        });

        $(function() {
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
            } else if (IS_HOLDER == CAPTAIN) {
                $('#menu-list').show();
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
            } else if($(this).val() == CAPTAIN) {
                $('#menu-list').show();
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

        var $form = $('form');
        var origForm = $form.serialize();
        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                + 'If you leave before saving, your changes will be lost.';
            var newForm = $form.serialize();
            if ((newForm !== origForm) && !submitted) {
                (e || window.event).returnValue = confirmationMessage;
            }
            return confirmationMessage;
        });
    </script>
@endsection
