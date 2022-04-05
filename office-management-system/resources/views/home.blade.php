@extends('backEnd.master')

@section('mainContent')

     <section class="mb-40">
        @if(permissionCheck('widget'))
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="main-title">
                        <h3 class="mb-0">{{__('dashboard.Quick Summery')}}</h3>
                    </div>
                </div>
                <div class="col-md-8 col-lg-8 col-sm-6">
                    <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link filtering" data-type="today"
                                   href="javascript:void(0)">{{__('dashboard.Today')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link filtering" data-type="week"
                                   href="javascript:void(0)">{{__('dashboard.This Week')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link filtering" data-type="month"
                                   href="javascript:void(0)">{{__('dashboard.This Month')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link filtering" data-type="year"
                                   href="javascript:void(0)">{{__('dashboard.This Financial Year')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (permissionCheck('widget.total_purchase'))
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <div class="white-box single-summery">
                            <div class="d-block mt-10">
                                <h3>{{ __('dashboard.Total Purchase') }}</h3>
                                <img class="demo_wait" height="60px" style="display: none"
                                     src="{{asset('public/backEnd/img/loader.gif')}}" alt="">
                                 <h1 class="gradient-color2 total_purchase">{{single_price($purchase_payments->sum('payable_amount'))}}</h1>
                            </div>
                        </div>
                    </div>
                @endif
                @if (permissionCheck('widget.total_sale'))
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <div class="white-box single-summery">
                            <div class="d-block mt-10">
                                <div>
                                    <h3>{{ __('dashboard.Total Sale') }}</h3>
                                </div>
                                <img class="demo_wait" height="60px" style="display: none"
                                     src="{{asset('public/backEnd/img/loader.gif')}}" alt="">
                                <h1 class="gradient-color2 total_sale">{{single_price($salesTotalAmount - $sale_payments->sum('return_amount'))}}</h1>
                            </div>
                        </div>
                    </div>
                @endif

                @if (permissionCheck('widget.expense'))
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <div class="white-box single-summery">
                            <div class="d-block mt-10">
                                <div>
                                    <h3>{{ __('dashboard.Expenses') }}</h3>
                                </div>
                                <img class="demo_wait" height="60px" style="display: none"
                                     src="{{asset('public/backEnd/img/loader.gif')}}" alt="">
                                <h1 class="gradient-color2 expenses">{{single_price($expenses)}}</h1>
                            </div>
                        </div>
                    </div>
                @endif

                @if (permissionCheck('widget.purchase_due'))
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <div class="white-box single-summery">
                            <div class="d-block mt-10">
                                <div>
                                    <h3>{{ __('dashboard.Purchase due') }}</h3>
                                </div>
                                <img class="demo_wait" height="60px" style="display: none"
                                     src="{{asset('public/backEnd/img/loader.gif')}}" alt="">
                                <h1 class="gradient-color2 purchase_due">{{single_price( $purchase_payments->sum('payable_amount') - $purchase_due->sum('amount')) }}</h1>
                            </div>
                        </div>
                    </div>
                @endif

                @if (permissionCheck('widget.invoice_due'))
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <div class="white-box single-summery">
                            <div class="d-block mt-10">
                                <div>
                                    <h3>{{ __('dashboard.Invoice due') }}</h3>
                                </div>
                                <img class="demo_wait" height="60px" style="display: none"
                                     src="{{asset('public/backEnd/img/loader.gif')}}" alt="">
                                <h1 class="gradient-color2 invoice_due">{{single_price($salesTotalAmount - $sale_due->sum('amount') + $sale_due->sum('return_amount'))}}</h1>
                            </div>
                        </div>
                    </div>
                @endif

                @if (permissionCheck('widget.total_in_bank'))
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <div class="white-box single-summery">
                            <div class="d-block mt-10">
                                <div>
                                    <h3>{{ __('dashboard.Total In Bank') }}</h3>
                                </div>
                                <img class="demo_wait" height="60px" style="display: none"
                                     src="{{asset('public/backEnd/img/loader.gif')}}" alt="">
                                <h1 class="gradient-color2 total_bank">{{single_price($bank)}}</h1>
                            </div>
                        </div>
                    </div>
                @endif

                @if (permissionCheck('widget.total_in_cash'))
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <div class="white-box single-summery">
                            <div class="d-block mt-10">
                                <div>
                                    <h3>{{ __('dashboard.Total In Cash') }}</h3>
                                </div>
                                <img class="demo_wait" height="60px" style="display: none"
                                     src="{{asset('public/backEnd/img/loader.gif')}}" alt="">
                                <h1 class="gradient-color2">{{single_price($cash)}}</h1>
                            </div>
                        </div>
                    </div>
                @endif

                @if (permissionCheck('widget.net_profit'))
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <div class="white-box single-summery">
                            <div class="d-block mt-10">
                                <div>
                                    <h3>{{ __('dashboard.Net Profit') }}</h3>
                                </div>
                                <img class="demo_wait" height="60px" style="display: none"
                                     src="{{asset('public/backEnd/img/loader.gif')}}" alt="">
                                <h1 class="gradient-color2 total_income">{{single_price($income)}}</h1>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif
        <div class="row mt-30">
            @if (permissionCheck('sale_statistics'))
                <div class="col-12">
                    <div class="white_box chart_box_1 mb_30">
                        <div class="box_header common_table_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-25">{{__('dashboard.Sale Statistics')}}</h3>
                            </div>
                            <div class="box_header_right">
                                <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link active monthly"
                                               href="javascript:void(0)">{{__('dashboard.Monthly')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link yearly"
                                               href="javascript:void(0)">{{__('dashboard.Yearly')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="monthly">{!! $monthly_sales->container() !!}</div>
                        <div id="yearly">{!! $yearly_sales->container() !!}</div>
                    </div>
                </div>
            @endif
            @if (permissionCheck('profit_statistics'))
                <div class="col-12">
                    <div class="white_box chart_box_1 mb_30">
                        <div class="box_header common_table_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-25">{{__('dashboard.Profit Statistics')}}</h3>
                            </div>
                            <div class="box_header_right">
                                <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link active daily_profit"
                                               href="javascript:void(0)">{{__('dashboard.Daily')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link weekly_profit"
                                               href="javascript:void(0)">{{__('dashboard.Weekly')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link monthly_profit"
                                               href="javascript:void(0)">{{__('dashboard.Monthly')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link yearly_profit"
                                               href="javascript:void(0)">{{__('dashboard.Yearly')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="daily_profit">{!! $daily_profit->container() !!}</div>
                        <div id="weekly_profit">{!! $weekly_profit->container() !!}</div>
                        <div id="monthly_profit">{!! $monthly_profit->container() !!}</div>
                        <div id="yearly_profit">{!! $yearly_profit->container() !!}</div>
                    </div>
                </div>
            @endif
            @if (permissionCheck('recent_activity'))
                <div class="col-xl-6">
                    <div class="white_box_30px mb_30">
                        <div class="box_header common_table_header ">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('dashboard.Recent Activity')}}</h3>
                            </div>
                            <div class="box_header_right">
                                <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link active sale"
                                               href="javascript:void(0)">{{__('sale.Sale')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link purchase"
                                               href="javascript:void(0)">{{__('purchase.Purchase')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="QA_section3 QA_section_heading_custom th_padding_l0 sales_table">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                <div class="table-responsive">
                                    <table class="table  pt-0 shadow_none pb-0 ">
                                        <thead>
                                            <tr>
                                            <th scope="col">{{__('sale.Invoice No')}}</th>
                                            <th scope="col">{{__('sale.Date')}}</th>
                                            <th scope="col">{{__('showroom.Branch')}}</th>
                                            <th scope="col">{{__('sale.Amount')}}</th>
                                            <th scope="col">{{__('sale.Customer')}}</th>
                                            <th scope="col">{{__('common.Status')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sales->take(10) as $sale)
                                            <tr>
                                                <td><a onclick="getDetails({{ $sale->id }})">{{$sale->invoice_no}}</a></td>
                                                <td class="nowrap">{{$sale->date}}</td>
                                                <td>{{$sale->saleable->name}}</td>
                                                <td>{{single_price($sale->payable_amount)}}</td>
                                                <td>{{$sale->customer->name}}</td>
                                                @if ($sale->status == 0)
                                                    <td><a href="javascript:void(0)"
                                                           class="badge_2">{{__('sale.Unpaid')}}</a></td>
                                                @elseif($sale->status == 1)
                                                    <td><a href="javascript:void(0)" class="badge_1">{{__('sale.Paid')}}</a>
                                                    </td>
                                                @elseif($sale->status == 2)
                                                    <td><a href="javascript:void(0)"
                                                           class="badge_2">{{__('sale.Partial')}}</a></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (count($sales) > 10)
                                <div class="row justify-content-center mt-10">
                                    <a href="{{route('sale.index')}}"
                                       class="primary-btn mr-2 fix-gr-bg">{{__('dashboard.See All')}}</a>
                                </div>
                            @endif
                        </div>
                        <div class="QA_section3 QA_section_heading_custom th_padding_l0 purchase_table">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                <div class="table-responsive">
                                    <table class="table  pt-0 shadow_none pb-0 ">
                                        <thead>
                                            <tr>
                                            <th scope="col">{{__('sale.Invoice No')}}</th>
                                            <th scope="col">{{__('sale.Date')}}</th>
                                            <th scope="col">{{__('showroom.Branch')}}</th>
                                            <th scope="col">{{__('sale.Amount')}}</th>
                                            <th scope="col">{{__('report.Supplier')}}</th>
                                            <th scope="col">{{__('common.Status')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($purchases->take(10) as $purchase)
                                            <tr>
                                                <td><a href="#">{{$purchase->invoice_no}}</a></td>
                                                <td class="nowrap">{{$purchase->date}}</td>
                                                <td>{{$purchase->purchasable->name}}</td>
                                                <td>{{single_price($purchase->payable_amount)}}</td>
                                                <td>{{$purchase->supplier->name}}</td>
                                                @if ($purchase->is_paid == 0)
                                                    <td><a href="javascript:void(0)"
                                                           class="badge_2">{{__('sale.Unpaid')}}</a></td>
                                                @elseif($purchase->is_paid == 2)
                                                    <td><a href="javascript:void(0)" class="badge_1">{{__('sale.Paid')}}</a>
                                                    </td>
                                                @elseif($purchase->is_paid == 1)
                                                    <td><a href="javascript:void(0)"
                                                           class="badge_2">{{__('sale.Partial')}}</a></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (count($purchases) > 10)
                                <div class="row justify-content-center mt-10">
                                    <a href="{{route('purchase_order.index')}}"
                                       class="primary-btn mr-2 fix-gr-bg">{{__('dashboard.See All')}}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if (permissionCheck('showroom_wise_product_qty'))
                <div class="col-lg-6 col-xl-6">
                    <div class="white_box_30px mb_30">
                        <div class="box_header common_table_header mb-40 flex-wrap">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('Branch Wise Product Quantity')}}</h3>
                            </div>
                        </div>
                        <div>{!! $product_quantity->container() !!}</div>
                    </div>
                </div>
            @endif
            @if (permissionCheck('payment_due_list'))
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="white_box_30px mb_30">
                        <div class="box_header common_table_header ">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('dashboard.Payment Due List')}}</h3>
                            </div>
                        </div>
                        <div class="QA_section3 QA_section_heading_custom th_padding_l0 ">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                <div class="table-responsive">
                                    <table class="table  pt-0 shadow_none pb-0 ">
                                        <thead>
                                            <tr>
                                            <th scope="col">{{__('sale.Invoice No')}}</th>
                                            <th scope="col">{{__('sale.Date')}}</th>
                                            <th scope="col">{{__('showroom.Branch')}}</th>
                                            <th scope="col">{{__('sale.Payable Amount')}}</th>
                                            <th scope="col">{{__('sale.Customer')}}</th>
                                            <th scope="col">{{__('sale.Due')}}</th>
                                        </tr>
                                        </thead>
                                       <tbody>
                                            @foreach($dues as $sale)
                                            <tr>
                                                <td><a onclick="payment_detail({{ $sale->id }})">{{$sale->invoice_no}}</a></td>
                                                <td class="nowrap">{{$sale->date}}</td>
                                                <td>{{$sale->saleable->name}}</td>
                                                <td>{{single_price($sale->payable_amount)}}</td>
                                                <td>{{$sale->customer->name}}</td>
                                                <td>{{single_price($sale->payable_amount - $sale->payments->sum('amount'))}}</td>
                                            </tr>
                                        @endforeach
                                       </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (count($dues) > 10)
                                <div class="row justify-content-center mt-10">
                                    <a href="{{route('sale.due.list')}}"
                                       class="primary-btn mr-2 fix-gr-bg">{{__('dashboard.See All')}}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if (permissionCheck('stock_alert_list'))
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="white_box_30px mb_30">
                        <div class="box_header common_table_header ">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('dashboard.Stock Alert List')}}</h3>
                            </div>
                        </div>
                        <div class="QA_section3 QA_section_heading_custom th_padding_l0 ">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                <div class="table-responsive">
                                    <table class="table pt-0 shadow_none pb-0 ">
                                        <thead>
                                            <tr>
                                            <td scope="col">{{__('common.Image')}}</td>
                                            <td scope="col">{{__('dashboard.Product Sku')}}</td>
                                            <td scope="col">{{__('showroom.Branch')}}</td>
                                            <td scope="col">{{__('dashboard.Stock')}}</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stock_alerts as $stock)
                                            <tr>
                                                <td>
                                                    <img src="{{asset(@$stock->productSku->product->image_source ?? 'backEnd/img/no_image.png')}}"
                                                         width="50px" alt="{{@$stock->productSku->product->product_name}}">
                                                </td>
                                                <td>{{@$stock->productSku->sku}}</td>
                                                <td>{{@$stock->houseable->name}}</td>
                                                <td>{{$stock->stock}} {{@$stock->productSku->product->unit_type->name}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (count($stock_alerts) > 10)
                                <div class="row justify-content-center mt-10">
                                    <a href="{{route('purchase.suggest')}}"
                                       class="primary-btn mr-2 fix-gr-bg">{{__('dashboard.See All')}}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-{{ permissionCheck('to_do_list') ? 7 : 12 }}">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="main-title">
                            <h3 class="mb-20">{{__('dashboard.Calendar')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="white-box">
                    <div class='common-calendar'>
                    </div>
                </div>
            </div>
            @if (permissionCheck('to_do_list'))
                <div class="col-{{ permissionCheck('to_do_list') ? 5 : 6 }}">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-6">
                            <div class="main-title">
                                <h3 class="mb-30">@lang('todo.to_do_list')</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-6 text-right">
                            <a href="#" data-toggle="modal" class="primary-btn small fix-gr-bg"
                               data-target="#add_to_do"
                               title="Add To Do" data-modal-size="modal-md">
                                <span class="ti-plus pr-2"></span>
                                @lang('event.Add')
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box school-table">
                                <div class="row to-do-list mb-20">
                                    <div class="col-md-12 d-flex justify-content-between">
                                        <button class="primary-btn small fix-gr-bg"
                                                id="toDoList">@lang('todo.incomplete')</button>
                                        <button class="primary-btn small tr-bg"
                                                id="toDoListsCompleted">@lang('todo.completed')</button>
                                    </div>
                                </div>

                                <input type="hidden" id="url" value="{{url('/')}}">


                                <div class="toDoList">
                                    @if(count(@$toDos->where('status',0)) > 0)

                                        @foreach($toDos->where('status',0) as $toDoList)
                                            <div class="single-to-do d-flex justify-content-between toDoList"
                                                 id="to_do_list_div{{@$toDoList->id}}">
                                                <div>
                                                    <input type="checkbox" id="midterm{{@$toDoList->id}}"
                                                           class="common-checkbox complete_task" name="complete_task"
                                                           value="{{@$toDoList->id}}">

                                                    <label for="midterm{{@$toDoList->id}}">

                                                        <input type="hidden" id="id" value="{{@$toDoList->id}}">
                                                        <input type="hidden" id="url" value="{{url('/')}}">
                                                        <h5 class="d-inline">{{@$toDoList->title}}</h5>
                                                        <p class="ml-35">

                                                            {{$toDoList->date }}

                                                        </p>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="single-to-do d-flex justify-content-between">
                                            @lang('todo.no_do_lists_assigned_yet')
                                        </div>

                                    @endif
                                </div>


                                <div class="toDoListsCompleted">
                                    @if(count(@$toDos->where('status',1))>0)

                                        @foreach($toDos->where('status',1) as $toDoListsCompleted)

                                            <div class="single-to-do d-flex justify-content-between"
                                                 id="to_do_list_div{{@$toDoListsCompleted->id}}">
                                                <div>
                                                    <h5 class="d-inline">{{@$toDoListsCompleted->title}}</h5>
                                                    <p class="">

                                                        {{@$toDoListsCompleted->date }}

                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="single-to-do d-flex justify-content-between">
                                            @lang('todo.no_do_lists_assigned_yet')
                                        </div>

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

            <div class="modal fade admin-query" id="add_to_do">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{trans('todo.Add To Do')}}</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="ti-close"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="container-fluid">
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'to_dos.store',
                                'method' => 'POST', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return validateToDoForm()']) }}

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row mt-25">
                                            <div class="col-lg-12" id="sibling_class_div">
                                                <div class="primary_input mb-15">
                                                    <label class="primary_input_label"
                                                           for="">{{__('common.Title')}}*</label>
                                                    <input type="text" class="primary_input_field"
                                                           placeholder="{{__('common.Title')}}" name="title"
                                                           value="{{ old('title') }}">
                                                    <span class="text-danger">{{$errors->first('title')}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-30">
                                            <div class="col-lg-12" id="">
                                                <label class="primary_input_label" for="">{{ __('sale.Date') }} *</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date"
                                                                   class="primary_input_field primary-input date form-control"
                                                                   id="startDate" type="text" name="date"
                                                                   value="{{date('m/d/Y')}}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 text-center">
                                            <div class="mt-40 d-flex justify-content-between">
                                                <button type="button" class="primary-btn tr-bg"
                                                        data-dismiss="modal">{{__('common.Cancel')}}</button>
                                                <input class="primary-btn fix-gr-bg" type="submit" value="save">
                                            </div>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div id="fullCalModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modalTitle" class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="ti-close"></i></span>
                                <span class="sr-only">close</span></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="" alt="There are no image" id="image" height="150" width="auto" style="display: none">
                            <div id="modalBody"></div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="getDetails">

    </div>
@endsection
@push('scripts')
    <script src="{{asset('public/frontend/vendors/chartlist/Chart.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/active_chart.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/js/charts_loader.js') }}"></script>
    @if (permissionCheck('sale_statistics'))
    {!! $monthly_sales->script() !!}
    {!! $yearly_sales->script() !!}
    @endif
    @if (permissionCheck('profit_statistics'))
    {!! $daily_profit->script() !!}
    {!! $weekly_profit->script() !!}
    {!! $monthly_profit->script() !!}
    {!! $yearly_profit->script() !!}
    @endif
    @if (permissionCheck('showroom_wise_product_qty'))
    {!! $product_quantity->script() !!}
    @endif
    <script>

        function getDetails(el){
            $.post('{{ route('get_sale_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#getDetails').html(data);
                $('#sale_info_modal').modal('show');
            });
        }
        function payment_detail(el) {
            $.post('{{ route('sale.get_sale_payment_details') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                $('#getDetails').html(data);
                $('#payments').modal('show');
            });
        }

        $(document).ready(function(){
        	setTimeout(function () {
	            $('#yearly').fadeOut(500);
	            $('#weekly_profit').fadeOut(500);
	            $('#monthly_profit').fadeOut(500);
	            $('#yearly_profit').fadeOut(500);
	            $('.purchase_table').fadeOut(500);
	        }, 1000);
        });

        if ($('.common-calendar').length) {
            $('.common-calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                views: {
                    month: { columnHeaderFormat: 'ddd', displayEventEnd: true, eventLimit: 3 },
                    week: { columnHeaderFormat: 'ddd DD', titleRangeSeparator: ' \u2013 ' },
                    day: { columnHeaderFormat: 'dddd' },
                },
                eventClick: function (event, jsEvent, view) {
                    $('#modalTitle').html(event.title);
                    $('#modalBody').html(event.description);
                    if(event.url){
                        $('#image').show();
                        $('#image').attr('src', event.url);
                    } else{
                        $('#image').hide();
                    }

                    $('#fullCalModal').modal();
                    return false;
                },
                height: 650,
                events: <?php echo json_encode($calendar_events);?> ,
            });
        }

        $(document).on('click', '.monthly', function () {
            $(this).addClass('active');
            $('.yearly').removeClass('active');
            $("#yearly").fadeOut(500);
            $('#monthly').fadeIn(500);
        });
        $(document).on('click', '.yearly', function () {
            $(this).addClass('active');
            $('.monthly').removeClass('active');
            $('#yearly').fadeIn(500);
            $('#monthly').fadeOut(500);
        });
        $(document).on('click', '.daily_profit', function () {
            $(this).addClass('active');
            $('.monthly_profit').removeClass('active');
            $('.weekly_profit').removeClass('active');
            $('.yearly_profit').removeClass('active');

            $('#daily_profit').fadeIn(500);
            $('#weekly_profit').fadeOut(500);
            $('#monthly_profit').fadeOut(500);
            $('#yearly_profit').fadeOut(500);
        });
        $(document).on('click', '.weekly_profit', function () {
            $(this).addClass('active');
            $('.monthly_profit').removeClass('active');
            $('.daily_profit').removeClass('active');
            $('.yearly_profit').removeClass('active');

            $('#daily_profit').fadeOut(500);
            $('#weekly_profit').fadeIn(500);
            $('#monthly_profit').fadeOut(500);
            $('#yearly_profit').fadeOut(500);
        });
        $(document).on('click', '.monthly_profit', function () {
            $(this).addClass('active');
            $('.weekly_profit').removeClass('active');
            $('.daily_profit').removeClass('active');
            $('.yearly_profit').removeClass('active');
            $('#daily_profit').fadeOut(500);
            $('#weekly_profit').fadeOut(500);
            $('#monthly_profit').fadeIn(500);
            $('#yearly_profit').fadeOut(500);
        });
        $(document).on('click', '.yearly_profit', function () {
            $(this).addClass('active');
            $('.weekly_profit').removeClass('active');
            $('.daily_profit').removeClass('active');
            $('.monthly_profit').removeClass('active');
            $('#daily_profit').fadeOut(500);
            $('#weekly_profit').fadeOut(500);
            $('#monthly_profit').fadeOut(500);
            $('#yearly_profit').fadeIn(500);
        });
        $(document).on('click', '.sale', function () {
            $(this).addClass('active');
            $('.purchase').removeClass('active');
            $(".sales_table").fadeIn(500);
            $('.purchase_table').fadeOut(500);
        });
        $(document).on('click', '.purchase', function () {
            $(this).addClass('active');
            $('.sale').removeClass('active');
            $('.purchase_table').fadeIn(500);
            $('.sales_table').fadeOut(500);
        });

        $(document).on('click', '.filtering', function () {
            $('.filtering').removeClass('active');
            $(this).addClass('active');
            let type = $(this).data('type');
            $('.gradient-color2').hide();
            $('.demo_wait').show();
            $.ajax({
                method: "POST",
                url: "{{url('dashboard-cards-info')}}" + "/" + type,
                success: function (data) {
                    $('.total_purchase').text(data.purchase_amount);
                    $('.total_sale').text(data.sale_amount);
                    $('.expenses').text(data.expense);
                    $('.purchase_due').text(data.purchase_due);
                    $('.invoice_due').text(data.sale_due);
                    $('.total_bank').text(data.bank);
                    $('.total_cash').text(data.cash);
                    $('.total_income').text(data.income);
                    $('.gradient-color2').show();
                    $('.demo_wait').hide();
                }
            })
        });
        $(".complete_task").on("click", function() {
        var url = $("#url").val();
        var id = $(this).val();
        var formData = {
            id: $(this).val(),
        };

        console.log(formData);
        // get section for student
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "complete-to-do",
            success: function(data) {
                console.log(data);

                setTimeout(function() {
                    toastr.success(
                        "Operation Success!",
                        "Success Alert", {
                            iconClass: "customer-info",
                        }, {
                            timeOut: 2000,
                        }
                    );
                }, 500);

                $("#to_do_list_div" + id + "").remove();

                $("#toDoListsCompleted").children("div").remove();
            },
            error: function(data) {
                console.log("Error:", data);
            },
        });
    });

    $(document).ready(function() {
        $(".toDoListsCompleted").hide();
    });

    $(document).ready(function() {
        $("#toDoList").on("click", function(e) {
            e.preventDefault();

            if ($(this).hasClass("tr-bg")) {
                $(this).removeClass("tr-bg");
                $(this).addClass("fix-gr-bg");
            }

            if ($("#toDoListsCompleted").hasClass("fix-gr-bg")) {
                $("#toDoListsCompleted").removeClass("fix-gr-bg");
                $("#toDoListsCompleted").addClass("tr-bg");
            }

            $(".toDoList").show();
            $(".toDoListsCompleted").hide();
        });
    });

    $(document).ready(function() {
        $("#toDoListsCompleted").on("click", function(e) {
            e.preventDefault();

            if ($(this).hasClass("tr-bg")) {
                $(this).removeClass("tr-bg");
                $(this).addClass("fix-gr-bg");
            }

            if ($("#toDoList").hasClass("fix-gr-bg")) {
                $("#toDoList").removeClass("fix-gr-bg");
                $("#toDoList").addClass("tr-bg");
            }

            $(".toDoList").hide();
            $(".toDoListsCompleted").show();

            var formData = {
                id: 0,
            };

            var url = $("#url").val();

            $.ajax({
                type: "GET",
                data: formData,
                dataType: "json",
                url: url + "/" + "get-to-do-list",
                success: function(data) {
                    $(".toDoListsCompleted").empty();

                    $.each(data, function(i, value) {
                        var appendRow = "";

                        appendRow +=
                            "<div class='single-to-do d-flex justify-content-between'>";
                        appendRow += "<div>";
                        appendRow += "<h5 class='d-inline'>" + value.title + "</h5>";
                        appendRow += "<p>" + value.date + "</p>";
                        appendRow += "</div>";
                        appendRow += "</div>";

                        $(".toDoListsCompleted").append(appendRow);
                    });
                },
                error: function(data) {
                    console.log("Error:", data);
                },
            });
        });
    });
    </script>
@endpush
