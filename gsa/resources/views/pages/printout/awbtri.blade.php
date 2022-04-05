<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>AWB</title>
        <link href="{{asset('assets/gsa/css/boots.css')}}" rel="stylesheet" />
        <link href="" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('assets/gsa/fa/css/font-awesome.min.css')}}">
        <script type="text/javascript" src="{{asset('assets/gsa/js/jquery.min.js')}}"></script>
        <style>
            @page {
                size: a4;
                margin: 0;
            }
            @media print {
                .no-print,
                .no-print * {
                    display: none !important;
                }  
                html, body {
                    width: 210mm;
                    height: 290mm !important; 
                    margin-top:0px !important;
                    /* background-color: red !important; */
                }
                .page { 
                    margin: 0px !important;
                    /* background-color: green; */
                    border: 0px !important;
                    height: 210mm !important; 
                    border-radius: initial;
                    box-shadow: initial;
                    background: initial;
                    page-break-after: always;
                    width:100% !important;
                    /* background-color: blue; */
                }
                .height33{ 
                    margin:0px !important;
                    margin-top:1mm !important;
                    height:93mm !important;
                    border:1px solid black !important; 
                    /* background-color:hotpink; */
                }
                .card{ 
                }
            } 
            
            body {
                background-color: #000;
            } 
            .card {
                /* margin-bottom: 30px; */
                border: none; 
            }

            .card-header {
                background-color: #fff;
                border-bottom: 1px solid #e6e6f2;
            }
 
            .height33{
                height:33% ;
                border:1px solid black;
            }
            .page {
                width: 210mm; 
                height: 297mm;
                padding: 1mm;
                margin: 10mm auto;
                border: 1px #D3D3D3 solid;
                border-radius: 5px; 
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                box-shadow: 8px 17px 38px -13px rgba(0,0,0,0.75);
                -webkit-box-shadow: 8px 17px 38px -13px rgba(0,0,0,0.75);
                -moz-box-shadow: 8px 17px 38px -13px rgba(0,0,0,0.75);
            }
        </style>
    </head>
    <body  class="snippet-body" style="background-color:white;">
        <div class="printcontainer d-print-none" 
            @if($awb[0]->status_tracking==='booked')
                onclick="updatetomanifest()"
            @else
                onclick="window.print()"                
            @endif    
        >
            <i class="fa fa-print" aria-hidden="true"></i>&nbsp;PRINT 
        </div>
        <div class="statuscontainer d-print-none" > Status =
            {{$awb[0]->status_tracking}}
        </div> 
        </div>
            <div  class="d-print-none" style="position:fixed; top:5px; left:5px;border:1px solid black;padding:5px;border-radius:5px;background-color:rgb(205, 255, 104);">
                Isi nama marketing : <input type="text" id='marketingchange'>
            </div>
            <div class="card page">
                @for ($i = 0; $i < 3; $i++)
                <div class="height33">                        
                    <div class="card-header  " style="padding-top:0.1cm !important; display: flex;">  
                        <div class="col-5 row text-center" style=" padding:1px;margin:0px;">
                            <img src='{{asset('assets/gsa/logo.jpg')}}'   style='width:1.1cm;height:1.3cm;' class="col-3">
                            <p class="col-8 font-weight-bold text-left" style="font-size:0.25cm;padding:0px; margin:0px;">GLOBAL SERVICE ASIA<br>Komplek Ruko Pasar Wisata Bandara Juanda C 10 -11 (Pabean - Sedati Sidoarjo, Telp. 031-8680799 / Fax. 031-8680599)</p>                        
                            <table  class=" col-12 table-bordered"  style="font-size:0.27cm; border-right:0px !important;">
                                <tr style="padding:0px;">
                                    <td style="font-size:0.5cm;line-height:0.4cm;" colspan='2'><b>No. </b>{{ $awb[0]->noawb }}</td> 
                                </tr>
                                <tr>
                                    <td style="width:2.4cm;line-height:0.2cm;"><b>PICKUP BY </b></td>
                                    <td style="width:2.4cm;line-height:0.2cm;"><b>TANGGAL</b></td> 
                                </tr>
                                <tr>
                                    <td style="line-height:0.2cm;">Driver</td>
                                    <td style="line-height:0.2cm;">{{ date('d-F-Y',strtotime($awb[0]->tanggal_awb)) }}</td>
                                </tr> 
                            </table>
                        </div>  
                        <div class="col-2 text-center" style=" ">
                            <table class=" table-bordered" style="font-size:0.3cm; width:100%; ">
                                <tr>
                                    <td style="width:25%; height:1.3cm;font-size:1cm;line-height:0cm;position:relative;">
                                        <span class="font-weight-bold" style="position:absolute; top:0.1cm;right:1px;font-size:0.22cm;">KOTA ASAL</span>
                                        {{ $awb[0]->kota_asal_kode }}<br>
                                    </td> 
                                </tr>
                                <tr>
                                    <td style="width:25%; height:1.3cm;font-size:1cm;line-height:0cm;position:relative;">
                                        <span class="font-weight-bold" style="position:absolute; top:0.1cm;right:1px;font-size:0.22cm;">KOTA TUJUAN</span>
                                        {{ $awb[0]->kota_tujuan_kode }}<br>
                                    </td>  
                                </tr>
                            </table>
                        </div>
                        <div class="col-2 text-center" >
                            {!! QrCode::size(95)->generate(url('/t/'.$awb[0]->noawb.'/t/notforscan')); !!}  
                        </div>
                        <table class="table-striped table-bordered col-3"  >
                            <thead>
                                @if ($awb[0]->ada_faktur == 1)                                            
                                <tr> 
                                    <td class='text-left' style="font-size:0.24cm; height:0.3cm;text-align:center !important; border:0px ;">
                                        <span class="badge badge-success" style="font-size:0.5cm;width:100%;">ADA FAKTUR</span><br>
                                    </td>
                                </tr>
                                @endif 
                                <tr> 
                                    <td class='text-left' style="font-size:0.24cm;"> 
                                        <span style="font-weight:bold;">Keterangan</span><br>
                                        {{ $awb[0]->keterangan }}
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class=" " style="margin-top:0cm; padding-top:0cm; padding-bottom:1cm;"> 
                        <div class=" " style="display:flex; relative;margin:0px; padding-bottom:10px;"> 
                            <div class="col-6 " style="padding:0px;">
                                <table class="table-striped table-bordered" style="font-size:0.25cm; width:100%;">
                                    <thead>
                                        <tr>
                                            <th style="width:50%;">SHIPPER</th>  
                                            <th style="width:50%;">CONSIGNEE</th>  
                                        </tr>
                                        <tr style="height: 3cm; font-size:0.25cm;">
                                            <td style="width:50%;">
                                                <span class="font-weight-bold" style="font-size:0.22cm;">NAMA PENGIRIM:</span><br>
                                                    <span style="font-size:0.35cm;">{{ $awb[0]->nama_pengirim }}<br></span>
                                                <span class="font-weight-bold" style="font-size:0.22cm;">ALAMAT:</span><br>
                                                    <span style="font-size:0.35cm;">{{ $awb[0]->alamat_pengirim }}<br></span>
                                                <span class="font-weight-bold" style="font-size:0.22cm;">KODEPOS:</span><br>
                                                    <span style="font-size:0.35cm;">{{ $awb[0]->kodepos_pengirim }}<br></span>
                                                <span class="font-weight-bold" style="font-size:0.22cm;">NO HP:</span><br>
                                                    <span style="font-size:0.35cm;">{{ $awb[0]->notelp_pengirim }} </span>
                                                    
                                                
                                            </td>   
                                            <td style="width:50%;">
                                                <span class="font-weight-bold" style="font-size:0.22cm;">NAMA PENERIMA:</span><br>
                                                    <span style="font-size:0.35cm;">{{ $awb[0]->nama_penerima }}<br></span>
                                                <span class="font-weight-bold" style="font-size:0.22cm;">ALAMAT:</span><br>
                                                    <span style="font-size:0.35cm;">{{ $awb[0]->alamat_tujuan }}<br></span>
                                                <span class="font-weight-bold" style="font-size:0.22cm;">KODEPOS:</span><br>
                                                    <span style="font-size:0.35cm;">{{ $awb[0]->kodepos_penerima }}<br></span>
                                                <span class="font-weight-bold" style="font-size:0.22cm;">NO HP:</span><br>
                                                    <span style="font-size:0.35cm;">{{ $awb[0]->notelp_penerima }} </span>
                                            </td>    
                                        </tr>
                                    </thead> 
                                </table> 
                                @if((int)$awb[0]->id_customer==26 || (int)$awb[0]->id_kota_transit>0)
                                    @if($i == 0)
                                        @if($awb[0]->harga_gsa == 0)
                                            <b style="padding-left:5px;">Total Harga : Rp.{{number_format($awb[0]->total_harga, 0)}}</b>
                                        @else
                                            <b style="padding-left:5px;">Total Harga : Rp.{{number_format($awb[0]->harga_gsa, 0)}}</b>
                                        @endif
                                    @else
                                    <b style="padding-left:5px;">Total Harga : Rp.{{number_format($awb[0]->total_harga, 0)}}</b>
                                    @endif
                                @endif
                            </div>
                            
                            <div class="col-6" style="padding:0px;">
                                <table  class="col-12 table-bordered"  style="font-size:0.35cm; border-right:0px !important;">
                                    <tr>
                                        <th colspan='6' style="font-style:italic;font-weight:bold;text-align:center;">
                                            ** QR CODE TIDAK UNTUK DISCAN MERUBAH STATUS**
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan='6' style="font-style:italic;font-weight:bold;text-align:center;
                                            @if ($i==0)
                                                background-color:#c5ffe1;
                                                @elseif ($i==1)
                                                background-color:#feffc5;
                                                @elseif ($i==2)
                                                background-color:#ffc5c5;
                                            @endif
                                            ">
                                            **
                                            @if ($i==0)
                                                Untuk Penagihan
                                            @elseif ($i==1)
                                                Untuk POD Balik
                                            @elseif ($i==2)
                                                Arsip GSA
                                            @endif
                                            **
                                        </th>
                                    </tr>
                                    <tr class="text-center">
                                        @if($awb[0]->is_agen == 1)
                                            <th width='100%'>QTY</th> 
                                        @else
                                            <th width='16.6%'>K</th> 
                                            <th width='16.6%'>S</th> 
                                            <th width='16.6%'>B</th> 
                                            <th width='16.6%'>BB</th> 
                                            <th width='16.6%'>Kg</th> 
                                            <th width='16.6%'>Doc</th>
                                        @endif 
                                    </tr> 
                                    <tr class="text-center">
                                        @if($awb[0]->is_agen == 1)
                                        <td>{{ $awb[0]->qty }}</td> 
                                        @else
                                        <td>{{ $awb[0]->qty_kecil }}</td> 
                                        <td>{{ $awb[0]->qty_sedang }}</td> 
                                        <td>{{ $awb[0]->qty_besar }}</td> 
                                        <td>{{ $awb[0]->qty_besarbanget }}</td> 
                                        <td>{{ $awb[0]->qty_kg }}</td> 
                                        <td>{{ $awb[0]->qty_doc }}</td> 
                                        @endif
                                    </tr> 
                                </table>
                                <table  class="col-12  "  style="font-size:0.35cm; border-right:0px !important;">
                                    <tr>
                                        {{-- <th colspan='5'>Quantity:</th> --}}
                                    </tr>
                                    <tr class="text-center">
                                        <th width='33.3%' style="padding-top:2.5cm; font-size:0.3cm;border:1px solid black;">
                                            MARKETING<br>
                                             <i>&nbsp;<span class="namamarketing"></span></i>
                                        </th> 
                                        <th width='33.3%' style="padding-top:2.5cm; font-size:0.3cm;border:1px solid black;">CUSTOMER<br><i>{{ $awb[0]->nama_pengirim }}</i></th> 
                                        <th width='33.3%' style="padding-top:2.5cm; font-size:0.3cm;border:1px solid black;">PENERIMA<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>  
                                    </tr>  
                                </table>
                            </div> 
                        </div> 
                    </div> 
                </div>
                
                @endfor
            </div>
        <script type="text/javascript" src="{{asset('assets/gsa/js/bootstrap.bundle.min.js')}}"></script> 
        <script type="text/javascript">
            jQuery(document).bind("keyup keydown", function(e){
                if(e.ctrlKey && e.keyCode == 80){
                    return false;
                }
            });
            $(document).on('keyup', '#marketingchange', function() {
            // Does some stuff and logs the event to the consol
                $('.namamarketing').html($(this).val())
            });
            function updatetomanifest(){
                $.ajax({
                    method  :'POST',
                    url     :'{{ url('awb/updatetomanifest') }}',
                    data    :{
                        id              : "{{ $awb[0]->id }}",
                        '_token'        : "{{ csrf_token() }}" 
                    },
                    success:function(data){  
                        if(data.status != ''){

                            alert(data.status)
                        }
                        window.print();       
                    }
                }) 
            }
        </script>
    </body>
</html>
