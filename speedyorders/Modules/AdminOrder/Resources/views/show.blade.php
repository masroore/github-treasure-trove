@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

    <div class="col-md-12">
        <div class="row">

            <div class="col-md-4">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th>Order Details</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Company Name</span>
                                    </td>
                                    <td>{{ Option::get('company_name') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Order Received</span>
                                    </td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Payment Method</span>
                                    </td>
                                    <td>{{ $order->payment_method }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Comment</span>
                                    </td>
                                    <td>{{ $order->comment }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

                <div class="col-md-4">
                    <div class="hpanel">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Customer Details</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="text-success font-bold">Full Name</span>
                                        </td>
                                        <td>{{ $order->first_name.' '.$order->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-success font-bold">Address</span>
                                        </td>
                                        <td>{{ $order->address_1 }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-success font-bold">Email</span>
                                        </td>
                                        <td>{{ $order->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-success font-bold">Phone</span>
                                        </td>
                                        <td>{{ $order->phone }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>


                    <div class="col-md-4">
                        <div class="hpanel">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Options</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <span class="text-success font-bold">Invoice</span>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('admin.orders.invoices.show', $order->id  ) }}" target="_blank">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-success font-bold">Shipping Details</span>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('admin.orders.shipping.invoices.show', $order->id  ) }}" target="_blank">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="col-md-12">

                               <div class="hpanel">
                                <div class="panel-body">
                                    <div class="table-responsive">
                               <table class="table table-bordered">
                                  <thead>
                                     <tr>
                                        <td colspan="2">Order Details</td>
                                     </tr>
                                  </thead>
                                  <tbody>
                                     <tr>
                                        <td style="width: 50%;">
                                           <address>
                                              <strong>{{ Option::get('company_name') }}</strong><br />
                                              {{ Option::get('company_address') }} <br />
                                           </address>
                                           <b>Telephone</b> {{ Option::get('company_phone') }}<br />
                                           <b>E-Mail</b> {{ Option::get('company_phone') }}</a><br />
                                           <b>Web Site:</b> <a href="{{ Option::get('company_site') }}">{{ Option::get('company_site') }}</a>
                                        </td>
                                        <td style="width: 50%;"><b>Date Added</b> {{ $order->created_at }}<br />
                                           <b>Order ID:</b> {{ $order->invoice_prefix.$order->invoice_number }}<br />
                                           <b>Payment Method</b> {{ $order->payment_method }}<br />
                                           <b>Shipping Method</b> {{ $order->shipping_method }}<br />
                                        </td>
                                     </tr>
                                  </tbody>
                               </table>

                                    </div>
                                </div>
                               </div>

                               <div class="hpanel">
                                <div class="panel-body">
                                    <div class="table-responsive">
                               <table class="table table-bordered">
                                  <thead>
                                     <tr>
                                        <td style="width: 50%;"><b>Payment Address</b></td>
                                        <td style="width: 50%;"><b>Shipping Address</b></td>
                                     </tr>
                                  </thead>
                                  <tbody>
                                     <tr>
                                        <td>
                                           <address>
                                              {{ $order->payment_address_1 }}<br />{{ $order->payment_address_2 }}<br />{{ $order->payment_city }}<br /> {{ $order->payment_state }} <br/> {{ $order->payment_postcode }} <br/> {{ (isset($order->paymentCountry->name)) ? $order->paymentCountry->name : '' }} <br/>
                                           </address>
                                        </td>
                                        <td>
                                           <address>
                                              {{ $order->shipping_first_name.' '.$order->shipping_last_name }}<br />{{ $order->shipping_company }}<br />{{ $order->shipping_address_1 }} <br/> {{ $order->shipping_address_2 }} <br/> {{ $order->shipping_postcode }} <br /> {{ $order->shipping_state }} <br/>  <br />{{ (isset($order->shippingCountry->name)) ? $order->shippingCountry->name : '' }}
                                           </address>
                                        </td>
                                     </tr>
                                  </tbody>
                               </table>
                                    </div>
                                </div>
                               </div>


                               <div class="hpanel">
                                <div class="panel-body">
                                    <div class="table-responsive">
                               <table class="table table-bordered">
                                  <thead>
                                     <tr>
                                        <td><b>Product</b></td>
                                        <td><b>SKU</b></td>
                                        <td class="text-right"><b>Quantity</b></td>
                                        <td class="text-right"><b>Unit Price</b></td>
                                        <td class="text-right"><b>Total</b></td>
                                     </tr>
                                  </thead>
                                  <tbody>
                                       <?php
                                         $subTotal = 0;
                                         $totalTax=0;
                                         $totalShipping=0;
                                         ?>

                                      @forelse($order->orderedProducts as $orderedProduct)
                                      <?php

                                           $individualTotal = $orderedProduct->quantity*$orderedProduct->price;
                                           $subTotal += $individualTotal;
                                           $totalTax += $orderedProduct->tax;
                                           $totalShipping += $orderedProduct->shipping_price;

                                       ?>
                                     <tr>
                                        <td>
                                           {{ $orderedProduct->product->name }}

                                           @if(count($orderedProduct->orderProductOptions)>0)
                                            <p><b>Variant</b></p>
                                           @foreach($orderedProduct->orderProductOptions ??[] as $orderProductOption)

                                                @if(isset($orderProductOption->productOption))
                                                    <p>[{{(isset($orderProductOption->productOption->option) && $orderProductOption->productOption->option->name) }} : {{($orderProductOption->productOption->option->type == "select" && isset($orderProductOption->productOptionValue->optionValue->name))?$orderProductOption->productOptionValue->optionValue->name:$orderProductOption->value}} ]</p>
                                                @endif


                                            @endforeach
                                           @endif
                                        </td>
                                        <td> {{$orderedProduct->product->sku}}</td>
                                        <td class="text-right">{{ $orderedProduct->quantity }}</td>
                                        <td class="text-right">{{ $orderedProduct->price }}</td>
                                        <td class="text-right">{{ $individualTotal }}</td>
                                     </tr>
                                     @empty
                                     <tr>
                                         No data found
                                     </tr>
                                     @endforelse
                                     <tr>
                                        <td class="text-right" colspan="4"><b>Sub Total</b></td>
                                        <td class="text-right">{{ $subTotal }}</td>
                                     </tr>
                                     <tr>
                                        <td class="text-right" colspan="4"><b>Tax</b></td>
                                        <td class="text-right">{{ $totalTax }}</td>
                                     </tr>
                                     <tr>
                                        <td class="text-right" colspan="4"><b>Shipping</b></td>
                                        <td class="text-right">{{ $totalShipping }}</td>
                                     </tr>
                                     <tr>
                                        <td class="text-right" colspan="4"><b>Total</b></td>
                                        <td class="text-right">{{ ($subTotal+$totalTax+$totalShipping) }}</td>
                                     </tr>
                                  </tbody>
                               </table>

                                    </div>
                                </div>
                               </div>

                               <div class="col-md-6 mb-5 ">

                                <h2>Order History</h2>

                                <div class="row">
                                    <form action="{{ route('admin.orders.histories.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Order Status</label>
                                            <select name="status" id="status" class="form-control js-dropdown-select2">
                                                <option value="6" @if(old('status')=='6') selected @endif>Canceled</option>
                                                <option value="7" @if(old('status')=='7') selected @endif>Canceled Reversal</option>
                                                <option value="8" @if(old('status')=='8') selected @endif>Chargeback</option>
                                                <option value="4" @if(old('status')=='4') selected @endif>Complete</option>
                                                <option value="5" @if(old('status')=='5') selected @endif>Delivered</option>
                                                <option value="9" @if(old('status')=='9') selected @endif>Denied</option>
                                                <option value="10" @if(old('status')=='10') selected @endif>Expired</option>
                                                 <option value="11" @if(old('status')=='11') selected @endif>Failed</option>
                                                <option value="1" @if(old('status')=='1') selected @endif>Pending</option>
                                                <option value="3" @if(old('status')=='3') selected @endif>Processed</option>
                                                <option value="2" @if(old('status')=='2') selected @endif>Processing</option>
                                                <option value="12" @if(old('status')=='12') selected @endif>Refunded</option>
                                                <option value="13" @if(old('status')=='13') selected @endif>Reversed</option>
                                                <option value="14" @if(old('status')=='14') selected @endif>Shipped</option>
                                                <option value="15" @if(old('status')=='15') selected @endif>Voided</option>
                                                </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="control-label">Comment</label>
                                        <textarea name="comment" class="form-control" id="" cols="30" rows="3"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                                    <div class="col-md-12 mb-5">
                                        <table class="table table-bordered">
                                            <thead>
                                               <tr>
                                                  <td><b>Date Added</b></td>
                                                  <td><b>Comment</b></td>
                                                  <td><b>Status</b></td>
                                               </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($order->orderHistories as $oHistory)
                                               <tr>
                                                   <td>
                                                       {{ $oHistory->created_at->format('Y-m-d') }}
                                                   </td>
                                                  <td>
                                                    {{ $oHistory->comment }}
                                                  </td>
                                                  <td>
                                                    {{ $oHistory->status }}
                                                  </td>
                                               </tr>
                                               @empty
                                               <tr>
                                                    No data found
                                                </tr>
                                               @endforelse
                                            </tbody>
                                         </table>
                                    </div>

                                </div>

                            </div>
                    </div>
                </div>
            </div>
@endsection

@section('ext_js')

@endsection
