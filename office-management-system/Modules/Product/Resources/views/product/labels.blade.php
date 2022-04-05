@php
    $setting = app('general_setting');
@endphp
<!DOCTYPE html>
@php
    Illuminate\Support\Facades\Cache::remember('language', 3600 , function() {
        return Modules\Localization\Entities\Language::where('code', session()->get('locale', Config::get('app.locale')))->first();
    });
@endphp
<html @if(Illuminate\Support\Facades\Cache::get('language')->rtl == 1) dir="rtl" class="rtl" @endif >
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="icon" href="{{url('/')}}/{{isset($fav)?$fav:''}}" type="image/png"/>
    <title>Admin </title>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    @include('backEnd.partials.style')

    <style>
        .page_break {
            page-break-after: always !important;
        }

        .width_25 {
            width: 25%;
            float: left;
        }

        .width_33 {
            width: 33%;
            float: left;
        }

        .width_50 {
            width: 50%;
            float: left;
        }

        .width_20 {
            width: 20%;
            float: left;
        }

        .width_14 {
            width: 14.28%;
            float: left;
        }
        .width_100 {
            width: 100%;
            float: left;
            margin: auto !important;
        }
        /* A4 Landscape*/
        @page {
            size: A4 landscape;
            /*margin-left: 10%;
            margin-right: 10%;
            margin-bottom: 10%;*/
            margin: 5%;
        }
    </style>
</head>
<body>
@php
    $j =1;
    $border_spacing = 0;

    if($page == 20)
        {
            $loop =2;
        }
    elseif ($page == 30)
    {
        $loop =4;
    }
    elseif ($page == 32)
    {
        $loop =4;
    }
    elseif ($page == 40)
    {
        $loop =5;
    }
    elseif ($page == 50)
    {
        $loop =7;
    }
    elseif ($page == 0)
    {
      $loop =1;
    }


@endphp
<div class="row">
    <div id="printableArea">

        @for ($i = 1; $i <= $label; $i++)
            <div @if ($loop == 5)
                 class="width_20 border text-center"
                 @elseif ($loop == 4)
                 class="width_25 border text-center"
                 @elseif ($loop == 3)
                 class="width_33 border text-center"
                 @elseif ($loop == 3)
                 class="width_33 border text-center"
                 @elseif ($loop == 2)
                 class="width_33 border text-center"
                 @elseif ($loop == 7)
                 class="width_14 border text-center"
                 @elseif ($loop == 1)
                 class="width_100 border text-center"
                @endif>
                @if ($business)
                    <b style="display: block !important; font-size: 10.625px">{{app('general_setting')->company_name}}</b>
                @endif
                @if($name)
                    <span style="display: block !important; font-size: 10.625px">
                            {{$sku->product->product_name}} {{$i}}
                        </span>
                @endif
                @if($variation)
                    <span style="display: block !important; font-size: 10px">
                            {{variantNameFromSku($sku)}}
                        </span>
                @endif
                @if($price > 0)
                    <span style="font-size: 10px">
                        {{__('dashboard.Price')}} : {{single_price($sku->selling_price)}}</span>
                @endif
                <br>
                <div class="barcode">
                    {!! DNS1D::getBarcodeSVG($sku->id, $sku->barcode_type) !!}
                    {{--                    <img src="data:image/png;base64, {{DNS1D::getBarcodePNG($sku->id, $sku->barcode_type)}}" alt="barcode"/>--}}
                </div>
            </div>
            @if ($page != 0 && $i % $page == 0)
                <div class="page_break">
                </div>
            @endif

        @endfor

    </div>
</div>

<div class="row justify-content-center mt-5 mb-5">
    <a href="javascript:void(0)" onclick="printDiv('printableArea')"
       class="primary-btn semi_large2 fix-gr-bg">{{__('pos.Print')}}</a>
    <a class="primary-btn semi_large2 fix-gr-bg ml-2" href="{{route('home')}}">{{__('common.Cancel')}}</a>
</div>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

</script>
</body>
</html>
