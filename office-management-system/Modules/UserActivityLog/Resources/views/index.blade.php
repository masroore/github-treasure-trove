@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.Activity Logs') }}</h3>
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
                                <th width="25%" scope="col">{{ __('common.Description') }}</th>
                                <th scope="col">{{ __('common.Type') }}</th>
                                <th scope="col">{{ __('setting.URL') }}</th>
                                <th scope="col">{{ __('setting.IP') }}</th>
                                <th width="25%" scope="col">{{ __('setting.Agent') }}</th>
                                <th scope="col">{{ __('common.Attempted At') }}</th>
                                <th scope="col">{{ __('common.User') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $key => $activity)
                            <tr>
                                <th>{{ $key+1 }}</th>
                                <td>{{ $activity->subject }}</td>
                                <td>
                                    @if ($activity->type == 0)
                                        <span class="badge_4">Error</span>
                                    @elseif ($activity->type == 1)
                                        <span class="badge_1">Success</span>
                                    @elseif ($activity->type == 2)
                                        <span class="badge_3">Warning</span>
                                    @else
                                        <span class="badge_2">Info</span>
                                    @endif
                                </td>
                                <td>{{ $activity->url }}</td>
                                <td>{{ $activity->ip }}</td>
                                <td>{{ $activity->agent }}</td>
                                <td>{{ $activity->updated_at }}</td>
                                <td>{{ userName($activity->user_id) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
