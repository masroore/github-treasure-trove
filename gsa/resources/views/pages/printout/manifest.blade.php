<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>MANIFEST</title>
        <link href="{{asset('assets/gsa/css/boots_a4.css')}}" rel="stylesheet" />
        <link href="" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('assets/gsa/fa/css/font-awesome.min.css')}}">
        <script type="text/javascript" src="{{asset('assets/gsa/js/jquery.min.js')}}"></script>
        <style>
            @font-face {
                font-family: JUDUL__S;
                /*src: url('font/save/Caviar_Dreams_Bold.otf');  */
                src: url('{{asset('assets/gsa/css/Roboto2DRAFTCondensed-Light.ttf')}}');  

            }
              th, td {
                border: 1px solid black;
            }
            .showonprint{
                display: none;
            }
            @page {
                size: 210mm 280mm;
                margin: 0;
            }
            @media print {
                
                /* div   { page-break-inside:avoid !important; }
                span   { page-break-inside:avoid !important; } */
                .no-print,
                .no-print * {
                    display: none !important;
                } 
                /* table.print-friendly tr td, table.print-friendly tr th {
                        page-break-inside: avoid !important;
                    } */
                  tr ,td ,th,thead{
                    page-break-inside: avoid !important;
                }
                 
                th, td {
                    border: 1px dashed black;
                    border-width: 1px;
                }
                html,
                body {
                    width: 210mm;
                    height: 280mm;
                }
                .showonprint{
                    display: block !important;
                }
                .hideprint{display: none !important;}
                /* tr.page-break  { display: block !important; page-break-after: always !important; } */
                .page {
                    margin: 0px !important;
                    border: 0px !important;
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    height: auto !important;
                    box-shadow: initial;
                    background: initial;
                    page-break-after: always !important;
                    width:100% !important;
                }
            } 
            body {
                font-family:JUDUL__S;
                background-color: #000;
            }

            .padding {
                padding: 2rem !important;
            }

            .card {
                margin-bottom: 30px;
                border: none; 
                    padding-top:10px !important;
            }

            .card-header {
                background-color: #fff;
                border-bottom: 1px solid #e6e6f2;
            }

            h3 {
                font-size: 20px;
            }

            h5 {
                font-size: 15px;
                line-height: 26px;
                color: #3d405c;
                margin: 0px 0px 15px 0px;
                font-family: "Circular Std Medium";
            }

            .text-dark {
                color: #3d405c !important;
            }
            .page {
                width: 210mm;
                min-height: auto;
                height: auto;
                padding: 5mm;
                page-break-after: always;
                margin: 10mm auto;
                border: 1px #D3D3D3 solid;
                border-radius: 5px;
                background: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                box-shadow: 8px 17px 38px -13px rgba(0,0,0,0.75);
                -webkit-box-shadow: 8px 17px 38px -13px rgba(0,0,0,0.75);
                -moz-box-shadow: 8px 17px 38px -13px rgba(0,0,0,0.75);
            }
        </style>
    </head>
    <body oncontextmenu="return false" class="snippet-body" style="background-color:white;">
        <div class="printcontainer hideprint" onclick="window.print()">  <i class="fa fa-print" aria-hidden="true"></i>&nbsp;PRINT 
        </div>
            <div class="card page"> 
                <div class="card"> 
                    <div class="">
                        <table class="print-friendly" style="font-size:0.4cm;width:100%;"> 
                            <thead>
                                <tr>
                                    <th colspan="9" style="border:0px !important; ">
                                        <div class="card-header row" style="padding:0px !important; "> 
                                            <div class="col-12 text-center font-weight-bold">
                                                DAFTAR BARANG<br> 
                                            </div>
                                            <div class="col-3 text-center"  >
                                                <img src='{{asset('assets/gsa/logo.jpg')}}' style="width:1.3cm;" class="col-">
                                                <p class="col-12 font-weight-bold" style="font-size:0.25cm;padding:0px; margin:0px;">GLOBAL SERVICE ASIA</p>
                                                <p class="col-12" style="font-size:0.18cm;padding:0px; margin:0px;">Komplek Ruko Pasar Wisata Bandara Juanda C 10 -11</p>
                                                <p class="col-12" style="font-size:0.18cm;padding:0px; margin:0px;">Pabean - Sedati Sidoarjo, Telp. 031-8680799 / Fax. 031-8680599
                                                </p>
                                                @if ($manifest->status=='checked')
                                                    <h2><button type="button" class=" hideprint btn btn-default">{{$manifest->status}}</button></h2>                        
                                                @elseif ($manifest->status=='delivering')
                                                    <h2><button type="button" class=" hideprint btn btn-primary">{{$manifest->status}}</button></h2>                        
                                                @elseif ($manifest->status=='arrived')
                                                    <h2><button type="button" class=" hideprint btn btn-success">{{$manifest->status}}</button></h2>
                                                @endif
                                                
                                            </div> 
                                            <div class="col-sm-3" style="padding:0px;">
                                                <table  class=" col-12 "  style="font-size:0.33cm; margin-top:0.4cm; border-right:0px !important; width:98%;">
                                                    <tr>
                                                        <td >NO.</td>
                                                        <td style="letter-spacing: 0.02cm;font-size:0.38cm;">&nbsp;{{$manifest->kode}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td >Asal </td>
                                                        <td>&nbsp;{{$manifest->namakotaasal}}-({{$manifest->kodekotaasal}})</td>
                                                    </tr>
                                                    <tr>
                                                        <td >Tujuan </td>
                                                        <td>&nbsp;{{$manifest->namakotatujuan}}-({{$manifest->kodekotatujuan}})</td>
                                                    </tr>  
                                                </table>
                                            </div>
                                            <div class="col-sm-4" style="padding:0px;">
                                                <table  class=" col-12 "  style="font-size:0.33cm; margin-top:0.4cm;">
                                                    <tr>
                                                        <td style="width:3cm;">Tgl </td>
                                                        <td>&nbsp;{{$manifest->tanggal_manifest}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:3cm;">Dicetak Oleh </td>
                                                        <td>&nbsp;{{ Auth::user()->nama }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:3cm;">Supir</td>
                                                        <td>&nbsp;{{$manifest->supir}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:3cm;">Diterima agen</td>
                                                        <td>&nbsp;{{$manifest->discan_diterima_oleh_nama}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-2" style="padding:10px; padding-top:15px;">
                                                {!! QrCode::size(87)->generate(url('/t/'.$manifest->kode)); !!}
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="width:0.5cm;padding:0.1cm;font-weight:normal;">NO</th> 
                                    <th rowspan="2" style="width:1cm;padding:0.1cm;font-weight:normal;">AWB</th> 
                                    <th rowspan="2" style="width:2cm;padding:0.1cm;font-weight:normal;">PENGIRIM</th> 
                                    <th rowspan="2" style="width:1cm;padding:0.1cm;font-weight:normal;">PENERIMA</th> 
                                    <th rowspan="2" style="width:1cm;padding:0.1cm;font-weight:normal;">TUJUAN</th> 
                                    <th  style="width:0.5cm;padding:0.1cm;font-weight:normal;">KL</th> 
                                    <th  style="width:0.5cm;padding:0.1cm;font-weight:normal;">KG</th> 
                                    <th  style="width:0.5cm;padding:0.1cm;font-weight:normal;">Doc</th> 
                                    {{-- <th rowspan="2" style="width:1cm;padding:0.1cm;font-weight:normal;">NM.PENERIMA</th>   --}}
                                    <th rowspan="2" style="width:2cm;padding:0.1cm;font-weight:normal;">Harga</th> 
                                </tr>
                                <tr>
                                    <td class="text-center">{{$manifest->jumlah_koli}}</td>
                                    <td class="text-center">{{$manifest->jumlah_kg}}</td>
                                    <td class="text-center">{{$manifest->jumlah_doc}}</td>
                                </tr> 
                            </thead>
                            <tbody> 
                                @foreach ($awb as $item)
                                <?php
                                    $qty_umum = $item->qty;
                                    if($item->qty_kecil > 0 || $item->qty_sedang > 0 || $item->qty_besar > 0 || $item->qty_besarbanget > 0){
                                        $qty_umum = $item->qty_kecil + $item->qty_sedang + $item->qty_besar + $item->qty_besarbanget;
                                    }
                                    if($item->qty_kg > 0){
                                        $qty_umum = ($item->jumlah_koli == 0) ? 1 : $item->jumlah_koli;
                                    }
                                    if($item->qty_doc > 0){
                                        $qty_umum = $item->qty_doc;
                                    }
                                ?>
                                <tr style="padding:0px;">
                                    <td class='text-center' style="padding:2px;">{{ $loop->index+1 }}</td>   
                                    <td style="padding:2px;">
                                        <a href="{{ url('t/'.$item['noawb'].'/t/0')}}" target="_blank" class=" ">{{$item->noawb}}</a>  
                                    </td> 
                                    <td style="padding:2px;" class='text-left'>{{$item->namacust}}</td> 
                                    <td style="padding:2px;" class='text-left'>{{$item->nama_penerima}}</td> 
                                    <td style="padding:2px;">{{$item->kotatujuan}}</td> 
                                    <td style="padding:2px;" class='text-center'>
                                        @if(($item->qty_kecil == 0 && $item->qty_sedang == 0 && $item->qty_besar == 0 && $item->qty_besarbanget==0 && $item->qty_kg==0 && $item->qty_doc==0) && $item->qty>0)
                                            {{((int)$item->qty > 0) ? $item->qty : ''}}
                                        @else
                                            {{((int)$item->qtykoli > 0) ? $item->qtykoli : ''}}   
                                        @endif

                                        @if((int)$item->jumlah_koli > 1)
                                            {{$item->jumlah_koli}}
                                        
                                        @endif
                                    </td> 
                                    <td style="padding:2px;" class='text-center'>
                                        @if((int)$item->id_customer==26 &&(int)$item->jumlah_koli > 1)
                                            
                                        @else 
                                            {{((int)$item->qty_kg > 0)  ? $item->qty_kg : ''}}
                                        @endif
                                    </td> 
                                    <td style="padding:2px;" class='text-center'>{{((int)$item->qty_doc > 0)  ? $item->qty_doc : ''}}</td> 
                                    {{-- <td style="padding:2px;">{{$item->nama_penerima}} </td>   --}}
                                    <td style="padding:2px;position:relative !important;">
                                        @if( (int)$item->id_kota_transit>0)
                                            Rp.{{number_format($item->total_harga, 0)}} 
                                        @endif
                                        
                                            <div class="hideprint totalbarangmasuk" 
                                                @if ($qty_umum - $item->qtyloaded <= 0)                                            
                                                    style="background-color: #27ae60;"
                                                @else
                                                    style="background-color: #d02626;"
                                                @endif
                                                >
                                                 masuk ke truck {{$item->qtyloaded}} dari {{ $qty_umum}} barang
                                            </div>
                                    </td> 
                                </tr>   
                                @endforeach    
                            </tbody>
                        </table>
                        <table class="col-12" style="border:0px !important; "  >
                            <thead  style="border:0px !important; " >
                                <tr style="border:0px !important;"> 
                                    <td class='text-left' style="font-size:0.35cm;padding:0.1cm; border:0px !important;">
                                        <span style=" ;">Keterangan</span><br>
                                        {{$manifest->keterangan}}
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div> 
                </div> 
            </div>
        <script type="text/javascript" src="{{asset('assets/gsa/js/bootstrap.bundle.min.js')}}"></script>
        <script type="text/javascript"></script>
    </body>
</html>
