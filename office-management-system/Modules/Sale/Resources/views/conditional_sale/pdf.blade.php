<!DOCTYPE html>
<html>
<head>

    <title>Invoice</title>

    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="stylesheet" href="{{asset('backEnd/')}}/css/rtl/bootstrap.min.css"/>

    <style>
        .lg-border {
            border-bottom: 3px solid #0b0b0b;
        }

        .left_width_50 {
            width: 50%;
        }

        .width_30 {
            width: 30%;
            float: left;
        }
        .width_40 {
            width: 40%;
            float: left;
        }
        .width_100{
            width: 100%;
            float: left;
        }
    </style>
</head>
<body>
<div class="container-fluid p-0">
    <div class="row pb-30 border-bottom">
        <div class="left_width_50">
            <img src="{{asset('uploads/settings/infix.png')}}" width="100px" alt="">
        </div>
        <div class="left_width_50 text-right">
            <h4>{{$setting->invoice_prefix}}{{$data->invoice_no}}</h4>
        </div>
    </div>
    <div class="row pt-30">
        <div class="width_30">
            <table class="table-borderless">
                <tr>
                    <td>Date</td>
                    <td>{{$data->created_at}}</td>
                </tr>
                <tr>
                    <td>Reference No</td>
                    <td>{{$data->ref_no}}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{$data->status == 1 ? 'Paid' : 'Unpaid'}}</td>
                </tr>
                <tr>
                    <td>Warehouse</td>
                    <td>{{@$data->warehouse->name}}</td>
                </tr>
            </table>
        </div>
        <div class="width_40">
        </div>

        <div class="width_30">
            <table class="table-borderless">
                <tr>
                    <td><b>Company</b></td>
                </tr>
                <tr>
                    <td>Company</td>
                    <td>{{$setting->company_name}}</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td><a href="tel:{{$setting->phone}}">{{$setting->phone}}</a></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><a href="mailto:{{$setting->email}}">{{$setting->email}}</a></td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td><a href="#">infix.pos.com</a></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="width_100">
            <table class="table-borderless">
                <tr>
                    <td><b>Billed To</b></td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td>{{@$data->customer->name}}</td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>
                        <a href="tel:{{@$data->customer->mobile}}">{{@$data->customer->mobile}}</a>
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>
                        <a href="mailto:{{@$data->customer->email}}">{{@$data->customer->email}}</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row mt-10">
        <div class="col-12">
            <table class="table table-bordered">
                <tr class="m-0">
                    <th>Product</th>
                    <th>Category</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Tax</th>
                    <th>Discount</th>
                    <th>Subtotal</th>
                </tr>

                @foreach($data->items as $item)
                    <tr>
                        <td class="p-2">{{@$item->product->product_name}}</td>
                        <td class="p-2">{{@$item->product->category->name}}</td>
                        <td class="p-2">{{@$item->color}}</td>
                        <td class="p-2">{{@$item->size}}</td>
                        <td class="p-2">{{@$item->price}}</td>
                        <td class="p-2">{{@$item->quantity}}</td>
                        <td class="p-2">{{@$item->tax}}</td>
                        <td class="p-2">{{@$item->discount}}</td>
                        <td class="p-2">{{@$item->sub_total}}</td>
                    </tr>
                @endforeach
                <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right">Total Products</td>
                    <td class="p-2">{{$data->items->sum('quantity')}}</td>
                    <td colspan="3" style="text-align: right">
                        <ul>
                            <li>SubTotal : {{$data->items->sum('sub_total')}}</li>
                            <li>Tax : {{$data->items->sum('tax')}}%</li>
                            <li>Discount : {{$data->items->sum('discount')}}</li>
                            @php
                                $tax = ($data->items->sum('sub_total') * $data->items->sum('tax'))/100;
                                $total = ($data->items->sum('sub_total') + $tax) - $data->items->sum('discount');
                            @endphp
                            <li class="border-top-0"></li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>

            <div class="col-12 mt-10">
                <h3>Purchase Note</h3>
                <p>{!! $data->notes !!}</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>


