 @extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.User') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <table class="table Crm_table_active3">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('common.ID') }}</th>
                                    <th scope="col">{{ __('common.Type') }}</th>
                                    <th scope="col">{{ __('common.Name') }}</th>
                                    <th scope="col">{{ __('common.Username') }}</th>
                                    <th scope="col">{{ __('common.Email') }}</th>
                                    <th scope="col">{{ __('common.Phone') }}</th>
                                    <th scope="col">{{ __('role.Role') }}</th>
                                    <th scope="col">{{ __('common.Apply Date') }}</th>
                                    <th scope="col">{{ __('common.Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $key => $user)
                                    <tr>
                                        <th>{{ $key+1 }}</th>
                                        <td>{{str_replace('_', ' ', @$user->role->type)}}</td>
                                        <td>{{ @$user->name }}</td>
                                        <td>{{ @$user->username }}</td>
                                        <td><a href="mailto:{{ @$user->email }}">{{ @$user->email }}</a></td>
                                        <td><a href="tel:{{ @$user->staff->phone }}">{{ @$user->staff->phone }}</a></td>
                                        <td>{{ @$user->role->name }}</td>
                                        <td>{{ date(app('general_setting')->dateFormat->format, strtotime($user->created_at)) }}</td>
                                        <td>
                                            <!-- shortby  -->
                                            <div class="dropdown CRM_dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenu2" data-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">
                                                    {{ __('common.Select') }}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                    @if(permissionCheck('staffs.view'))
                                                        <a href="javascript:void(0)" onclick="getDetails({{$user->id}})" class="dropdown-item">{{__('common.View')}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- shortby  -->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="getDetails">
    </div>
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        function getDetails(el){
            $.post('{{ route('user.loan.details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#getDetails').html(data);
                $('#sale_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
