@extends('layout.excel-header')

@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @include('layout.excel-style')
    <style>
        table tr td {
            text-align: center;
        }
        table thead tr th {
            background: #d9f8fb;
        }
    </style>
    <table style="border: 1px solid #333333;">
        <thead>
        <tr>
            <th class="center" style="width:60px;word-break: break-all;">{!! trans('shipManage.shipCertlist.No') !!}</th>
            <th class="center" style="width:60px;word-break: break-all;">{{ trans('shipManage.shipCertlist.Code') }}</th>
            <th class="center" style="width:280px;word-break: break-all;">{{ trans('shipManage.shipCertlist.name of certificates') }}</th>
            <th class="center" style="width:120px;word-break: break-all;">{{ trans('shipManage.shipCertlist.issue_date') }}</th>
            <th class="center" style="width:120px;word-break: break-all;">{{ trans('shipManage.shipCertlist.expire_date') }}</th>
            <th class="center" style="width:120px;word-break: break-all;">{!! trans('shipManage.shipCertlist.due_endorse') !!}</th>
            <th class="center" style="width:80px;word-break: break-all;">{{ trans('shipManage.shipCertlist.issuer') }}</th>
            <th class="center" style="width:200px;word-break: break-all;">{{ trans('shipManage.shipCertlist.remark') }}</th>
        </tr>
        </thead>
        <tbody>
        <?php $index = 0;?>
            @foreach($list as $key => $item)
                <tr>
                    <td class="center" style="background: {{ $index % 2 == 0 ? '#ebf1de' : '#ffffff' }}">{{ $item->order_no }}</td>
                    <td class="center" style="background: {{ $index % 2 == 0 ? '#ebf1de' : '#ffffff' }}">{{ $item->code }}</td>
                    <td style="background: {{ $index % 2 == 0 ? '#ebf1de' : '#ffffff' }}">{{ $item->cert_name }}</td>
                    <td class="center" style="background: {{ $index % 2 == 0 ? '#ebf1de' : '#ffffff' }}"><span>{{ $item->issue_date }}</span></td>
                    <td class="center" style="background: {{ $index % 2 == 0 ? '#ebf1de' : '#ffffff' }}"><span>{{ $item->expire_date }}</span></td>
                    <td class="center" style="background: {{ $index % 2 == 0 ? '#ebf1de' : '#ffffff' }}"><span>{{ $item->due_endorse }}</span></td>
                    <td class="center" style="background: {{ $index % 2 == 0 ? '#ebf1de' : '#ffffff' }}"><span>{{ g_enum('IssuerTypeData')[$item->issuer] }}</span></td>
                    <td style="background: {{ $index % 2 == 0 ? '#ebf1de' : '#ffffff' }}"><span>{{ $item->remark }}</span></td>
                </tr>
                <?php $index ++;?>
            @endforeach
        </tbody>
    </table>
@endsection