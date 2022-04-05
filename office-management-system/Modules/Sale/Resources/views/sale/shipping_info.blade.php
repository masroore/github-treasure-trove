@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('sale.Pos Invoice')}}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center" id="printablePos">
        <div class="col-8">
            <div class="white-box mt-2">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <ul>
                            <li><b>{{__('sale.Shipping Name')}} :</b>{{$shipping->shipping_name}}</li>
                            <li><b>{{__('sale.Shipping Reference No')}} :</b>{{$shipping->shipping_ref}}</li>
                            <li><b>{{__('sale.Date')}} :</b>{{$shipping->date}}</li>
                            <li><b>{{__('sale.Received By')}} :</b>{{$shipping->received_by}}</li>
                            <li><b>{{__('sale.Received Date')}} :</b>{{$shipping->received_date}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push("scripts")
        <script type="text/javascript">
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    @endpush
@endsection
