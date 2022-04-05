<?php
if(isset($is_excel))
	$header = 'excel-header';
else
	$header = 'header';

$isShareHolder = Auth::user()->isAdmin == STAFF_LEVEL_SHAREHOLDER ? true : false;
$shipList = explode(',', Auth::user()->shipList);
?>
@extends('layout.' . $header)

@section('scripts')
    <script>
        $('#ship_list').on('change', function(e) {
            location.href = '/shipManage/shipinfo?id=' + $(this).val();
        });
    </script>
@endsection

@section('content')
    @if(!isset($is_excel))
        <div class="main-content">
            <div class="page-content">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <h4><b>船舶规范</b></h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-1">
                        <select class="custom-select" id="ship_list">
                            @foreach($list as $key => $item)
                                <option value="{{ $item->id }}" {{ isset($id) && $id == $item->id ? 'selected' : '' }}>{{ empty($item->NickName) ? $item->shipName_En : $item->NickName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-5 for-pc">
                        <div class="btn-group f-right">
                            <a href="exportShipInfo?id={{ $id }}" class="btn btn-warning btn-sm" id="excel-general">
                                <i class="icon-table"></i>{{ trans('common.label.excel') }}
                            </a>
                            <a href="javascript: shipInfoExcel()" class="btn btn-warning btn-sm d-none" id="excel-formA">
                                <i class="icon-table"></i>{{ trans('common.label.excel') }}
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6"></div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <ul class="nav nav-tabs ship-register for-pc">
                            <li class="active" >
                                <a data-toggle="tab" href="#general" onclick="changeTab('general')">
                                    规范
                                </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#form_a" onclick="changeTab('formA')">
                                    FORM A
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="general" class="tab-pane active">
    @else
        @include('layout.excel-style')
    @endif
                                <table class="table table-bordered excel-output sp-left-align" id="excel-output">
                                    <thead>
                                    <tr>
                                        <th class="title" colspan="2" style="font-size: 16px;">SHIP PARTICULARS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="{{ isset($shipInfo['shipName_En']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">SHIP NAME</td>
                                        <td style="text-align: left">@if(isset($shipInfo['shipName_En'])){{$shipInfo['shipName_En']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['IMO_No']) ? '' : 'sp-tr-none' }}">
                                        <td  style="background-color: #f8f8f8;" class="font-bold">IMO NO</td>
                                        <td style="text-align: left">@if(isset($shipInfo['IMO_No'])){{$shipInfo['IMO_No']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['Class']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">CLASS</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Class'])){{$shipInfo['Class']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['CallSign']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">CALL SIGN</td>
                                        <td style="text-align: left">@if(isset($shipInfo['CallSign'])){{$shipInfo['CallSign']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['MMSI']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">MMSI NO</td>
                                        <td style="text-align: left">@if(isset($shipInfo['MMSI'])){{$shipInfo['MMSI']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['INMARSAT']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">INMARSAT Number (1/2)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['INMARSAT'])){{$shipInfo['INMARSAT']}}@endif</td>
                                    </tr>



                                    <tr class="{{ isset($shipInfo['OriginalShipName']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">ORIGINAL NAME</td>
                                        <td style="text-align: left">@if(isset($shipInfo['OriginalShipName'])){{$shipInfo['OriginalShipName']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['FormerShipName']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">FORMER NAME</td>
                                        <td style="text-align: left">@if(isset($shipInfo['FormerShipName'])){{$shipInfo['FormerShipName']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['Flag']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">FLAG</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Flag'])){{$shipInfo['Flag']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['MMSI']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">REGISTRY PORT</td>
                                        <td style="text-align: left">@if(isset($shipInfo['PortOfRegistry'])){{$shipInfo['PortOfRegistry']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['Owner_Cn']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">OWNER</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Owner_Cn'])){{$shipInfo['Owner_Cn']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['ISM_Cn']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">ISM COMPANY</td>
                                        <td style="text-align: left">@if(isset($shipInfo['ISM_Cn'])){{$shipInfo['ISM_Cn']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['ShipType']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">SHIP TYPE</td>
                                        <td style="text-align: left">@if(isset($shipInfo['ShipType'])){{$shipInfo['ShipType']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['ShipBuilder']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">SHIP BUILDER</td>
                                        <td style="text-align: left">@if(isset($shipInfo['ShipBuilder'])){{$shipInfo['ShipBuilder']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['BuildPlace_Cn']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">BUILD DATE/PLACE</td>
                                        <td style="text-align: left">@if(isset($shipInfo['BuildPlace_Cn'])){{$shipInfo['BuildPlace_Cn']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['GrossTon']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">GT</td>
                                        <td style="text-align: left">@if(isset($shipInfo['GrossTon'])){{$shipInfo['GrossTon']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['NetTon']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">NT</td>
                                        <td style="text-align: left">@if(isset($shipInfo['NetTon'])){{$shipInfo['NetTon']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['Deadweight']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">DWT (MT)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Deadweight'])){{$shipInfo['Deadweight']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['Displacement']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">LDT (MT)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Displacement'])){{$shipInfo['Displacement']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['LOA']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">LOA (m)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['LOA'])){{$shipInfo['LOA']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['BM']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">BM (m)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['BM'])){{$shipInfo['BM']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['DM']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">DM (m)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['DM'])){{$shipInfo['DM']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['Draught']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">SUMMER DRAFT (m)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Draught'])){{$shipInfo['Draught']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['DeckErection_F']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">TPC (MT/cm)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['DeckErection_F'])){{$shipInfo['DeckErection_F']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($freeBoard['new_free_fw']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">FW_Allowance (m)</td>
                                        <td style="text-align: left">{{ isset($freeBoard['new_free_fw']) ? $freeBoard['new_free_fw'] : '' }}</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['No_TypeOfEngine']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">M/E NO_TYPE</td>
                                        <td style="text-align: left">{{ isset($shipInfo['No_TypeOfEngine']) ? $shipInfo['No_TypeOfEngine'] : '' }}</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['Power']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">POWER (Kw)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Power'])){{$shipInfo['Power']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['rpm']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">RPM (r/min)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['rpm'])){{$shipInfo['rpm']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['EngineDate']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">MADE YEAR</td>
                                        <td style="text-align: left">@if(isset($shipInfo['EngineDate'])){{$shipInfo['EngineDate']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['Speed']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">SERVICE SPEED (Kn)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Speed'])){{$shipInfo['Speed']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['AddressEngMaker']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">PROPELLER DIA/PITCH (mm)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Speed'])){{$shipInfo['AddressEngMaker']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['PrimeMover']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">GENERATOR SET</td>
                                        <td style="text-align: left">{{ isset($shipInfo['PrimeMover']) ? $shipInfo['PrimeMover'] : '' }}</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['GeneratorOutput']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">OUTPUT</td>
                                        <td style="text-align: left">{{ isset($shipInfo['GeneratorOutput']) ? $shipInfo['GeneratorOutput'] : '' }}</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['Boiler']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">BOILER NO_TYPE</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Boiler'])){{$shipInfo['Boiler']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['BoilerManufacturer']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">BOILER MAKER</td>
                                        <td style="text-align: left">@if(isset($shipInfo['BoilerManufacturer'])){{$shipInfo['BoilerManufacturer']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['BoilerPressure']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">PRESSURE</td>
                                        <td style="text-align: left">{{ isset($shipInfo['BoilerPressure']) ? $shipInfo['BoilerPressure'] : ''}}</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['FOSailCons_S']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">FO CONSUMPTION (mt/day)</td>
                                        <td style="text-align: left">@if(isset($is_excel)){{ '="' }}@endif @if(isset($shipInfo['FOSailCons_S'])){{$shipInfo['FOSailCons_S']}}@endif/@if(isset($shipInfo['FOL/DCons_S'])){{$shipInfo['FOL/DCons_S']}}@endif/@if(isset($shipInfo['FOIdleCons_S'])){{$shipInfo['FOIdleCons_S']}}@endif @if(isset($is_excel)){{ '"' }}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['DOSailCons_S']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">MDO CONSUMPTION (mt/day)</td>
                                        <td style="text-align: left">@if(isset($is_excel)){{ '="' }}@endif @if(isset($shipInfo['DOSailCons_S'])){{$shipInfo['DOSailCons_S']}}@endif/@if(isset($shipInfo['DOL/DCons_S'])){{$shipInfo['DOL/DCons_S']}}@endif/@if(isset($shipInfo['DOIdleCons_S'])){{$shipInfo['DOIdleCons_S']}}@endif @if(isset($is_excel)){{ '"' }}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['FuelBunker']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">FO/DO TK CAPACITY (㎥)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['FuelBunker'])){{$shipInfo['FuelBunker']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['Ballast']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">BALLAST TK CAPACITY (㎥)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Ballast'])){{$shipInfo['Ballast']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['NumberOfHolds']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">HOLDS/HATCHES NO</td>
                                        <td style="text-align: left">@if(isset($is_excel)){{ '="' }}@endif @if(isset($shipInfo['NumberOfHolds'])){{$shipInfo['NumberOfHolds']}}@endif / @if(isset($shipInfo['NumberOfHatchways'])){{$shipInfo['NumberOfHatchways']}}@endif @if(isset($is_excel)){{ '"' }}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['CapacityOfHoldsG']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">HOLD CAPACITY(G/B)㎥</td>
                                        <td style="text-align: left">@if(isset($is_excel)){{ '="' }}@endif @if(isset($shipInfo['CapacityOfHoldsG'])){{$shipInfo['CapacityOfHoldsG']}}@endif / @if(isset($shipInfo['CapacityOfHoldsB'])){{$shipInfo['CapacityOfHoldsB']}}@endif @if(isset($is_excel)){{ '"' }}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['SizeOfHatchways']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">HATCH COVER SIZE/TYPE</td>
                                        <td style="text-align: left">{{ isset($shipInfo['SizeOfHatchways']) ? $shipInfo['SizeOfHatchways'] : '' }}</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['HoldsDetail']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">HOLD SIZE</td>
                                        <td style="text-align: left">@if(isset($shipInfo['HoldsDetail'])){{$shipInfo['HoldsDetail']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['LiftingDevice']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">CARGO GEAR</td>
                                        <td style="text-align: left">@if(isset($shipInfo['LiftingDevice'])){{$shipInfo['LiftingDevice']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['DeckErection_H']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">HEIGHT FM KEEL TO MAST (m)</td>
                                        <td style="text-align: left">@if(isset($shipInfo['DeckErection_H'])){{$shipInfo['DeckErection_H']}}@endif</td>
                                    </tr>
                                    <tr class="{{ isset($shipInfo['TK_TOP']) ? '' : 'sp-tr-none' }}">
                                        <td style="background-color: #f8f8f8;">MAX PERMISSBLE LOAD(TANK TOP/ON DECK/HATCH COVER)</td>
                                        <td style="text-align: left">@if(isset($is_excel)){{ '="' }}@endif @if(isset($shipInfo['TK_TOP'])){{ $shipInfo['TK_TOP'] . '/' }}@endif  @if(isset($shipInfo['ON_DECK'])){{ $shipInfo['ON_DECK'] . '/' }}@endif @if(isset($shipInfo['H_COVER'])){{$shipInfo['H_COVER']}}@endif @if(isset($is_excel)){{ '"' }}@endif</td>
                                    </tr>
                                    </tbody>
                                </table>
                                @if(!isset($is_excel))
                            </div>
                            <div id="form_a" class="tab-pane">
                                <table class="table table-bordered excel-output" id="formA-table">
                                    <thead>
                                    <tr>
                                        <th class="title" colspan="2" style="font-size: 16px;">SHIP PARTICULARS (A)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">SHIP NAME</td>
                                        <td style="text-align: left">@if(isset($shipInfo['shipName_En'])){{$shipInfo['shipName_En']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">FLAG</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Flag'])){{$shipInfo['Flag']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">BUILD DATE/PLACE</td>
                                        <td style="text-align: left">@if(isset($shipInfo['BuildPlace_Cn'])){{$shipInfo['BuildPlace_Cn']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">SHIP TYPE</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Owner_Cn'])){{$shipInfo['ShipType']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td  style="background-color: #f8f8f8;">IMO NO</td>
                                        <td style="text-align: left">@if(isset($shipInfo['IMO_No'])){{$shipInfo['IMO_No']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">GT</td>
                                        <td style="text-align: left">@if(isset($shipInfo['GrossTon'])){{$shipInfo['GrossTon']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">NT</td>
                                        <td style="text-align: left">@if(isset($shipInfo['NetTon'])){{$shipInfo['NetTon']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8; font-weight: bold;">DWT</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Deadweight'])){{$shipInfo['Deadweight']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">CALL SIGN</td>
                                        <td style="text-align: left">@if(isset($shipInfo['CallSign'])){{$shipInfo['CallSign']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">LOA</td>
                                        <td style="text-align: left">@if(isset($shipInfo['LOA'])){{$shipInfo['LOA']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">BM</td>
                                        <td style="text-align: left">@if(isset($shipInfo['BM'])){{$shipInfo['BM']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">DM</td>
                                        <td style="text-align: left">@if(isset($shipInfo['DM'])){{$shipInfo['DM']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">HEIGHT FM KEEL TO MAST</td>
                                        <td style="text-align: left">@if(isset($shipInfo['DeckErection_H'])){{$shipInfo['DeckErection_H']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">SUMMER DRAFT</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Draught'])){{$shipInfo['Draught']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">FW_Allowance</td>
                                        <td style="text-align: left">{{ isset($freeBoard['new_free_fw']) ? $freeBoard['new_free_fw'] : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">POWER</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Power'])){{$shipInfo['Power']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">REGISTRY PORT</td>
                                        <td style="text-align: left">@if(isset($shipInfo['PortOfRegistry'])){{$shipInfo['PortOfRegistry']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f8f8;">OWNER</td>
                                        <td style="text-align: left">@if(isset($shipInfo['Owner_Cn'])){{$shipInfo['Owner_Cn']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #d9f8fb; height: 35px; vertical-align: middle;">SHIP'S CERTIFICATES</td>
                                        <td style="vertical-align: middle;background-color: #d9f8fb;">DATE ISSUED</td>
                                        <td style="vertical-align: middle;background-color: #d9f8fb;">DATE VALID</td>
                                    </tr>
                                    @foreach($elseInfo['cert'] as $key => $item)
                                        <tr>
                                            <td style="background-color: #f8f8f8;">{{ $key }}</td>
                                            <td style="text-align: left">{{ $item['issue_date'] }}</td>
                                            <td style="text-align: left">{{ $item['expire_date'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td style="background-color: #d9f8fb; height: 35px; vertical-align: middle;">CERTIFICATES OF COMPETENCY FOR SEAFARERS</td>
                                        <td style="vertical-align: middle;background-color: #d9f8fb;">NO OF COC</td>
                                        <td style="vertical-align: middle;background-color: #d9f8fb;">VALID UNTIL</td>
                                    </tr>
                                    @foreach($memberCertXls['COC'] as $key => $item)
                                        <tr>
                                            <td style="background-color: #f8f8f8;">{{ $item[1] }}</td>
                                            @if(isset($elseInfo['member'][$item[0]]))
                                            <td style="text-align: left">{{ $elseInfo['member'][$item[0]]['ItemNo'] }}</td>
                                            <td style="text-align: left">{{ $elseInfo['member'][$item[0]]['COC_ExpiryDate'] }}</td>
                                            @else
                                                <td></td>
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    @foreach($memberCertXls['GOC'] as $key => $item)
                                        <tr>
                                            <td style="background-color: #f8f8f8;">{{ $item[1] }}</td>
                                            @if(isset($elseInfo['member'][$item[0]]))
                                                <td style="text-align: left">{{ $elseInfo['member'][$item[0]]['ItemNo'] }}</td>
                                                <td style="text-align: left">{{ $elseInfo['member'][$item[0]]['COC_ExpiryDate'] }}</td>
                                            @else
                                                <td></td>
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="space-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="excel-output" class="d-none"></div>
    @endif

    <script>
        var tab = '';
        var tab_text = '';
		var shipName = '{!! $shipName !!}';
        function shipInfoExcel() {
            tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            tab = document.getElementById('formA-table').cloneNode(true);
            for(var j = 0 ; j < tab.rows.length ; j++) {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        if (i == 0) {
                            tab.rows[j].cells[0].style.width = '300px';
                        }
                        else if (i == 1) {
                            tab.rows[j].cells[0].style.width = '300px';
                        }
                        else if (i == 2) {
                            tab.rows[j].cells[0].style.width = '300px';
                        }
                    }
                }
            }

            tab_text += tab.innerHTML;
            tab_text += "</table>";

            // $('#excel-output tr td').css({'width': '300px', 'border-left' : '1px solid #666666', 'border-bottom' : '1px solid #666666'});
            exportExcel(tab_text, shipName + '_' + 'FORM A', 'Sheet');

        }

		function changeTab(type) {
			
			if(type == 'general') {
				$('#excel-general').removeClass('d-none');
				$('#excel-formA').addClass('d-none');
			} else {
				$('#excel-general').addClass('d-none');
				$('#excel-formA').removeClass('d-none');
			}
		}
    </script>
@endsection
