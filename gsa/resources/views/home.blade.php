@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        @foreach ($page as $item)
            {!!$item!!}
        @endforeach
    </div>

    <div class="modal fade" id="modalscanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Scan AWB</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if (!Browser::isChrome())
                        <div class="alert alert-alert row" style="
                            color: #856404;
                            background-color: #fff3cd;
                            border-color: #ffeeba;
                            height: 100px;">
                            <img src="{{ asset('assets/gsa/img/chrome.png') }}" class="col-2"
                                style="object-fit: contain;">
                            <div class="col-10">
                                Untuk kelancaran scan QR, Gunakan browser google chrome
                                <a
                                    href="https://www.google.com/chrome/?brand=CHBD&gclid=CjwKCAjw7fuJBhBdEiwA2lLMYXmsMZsuOvkh0CG2ld2zkAV2WnWiVakTdwrk5F-g2BPEY1yQjqNLGhoCqsoQAvD_BwE&gclsrc=aw.ds">
                                    click disini untuk download chrome
                                </a> atau download pada playstore/appstore
                            </div>
                        </div>
                    @endif
 
                    @foreach ($modalawb as $item)
                        {!!$item!!}
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalscannermanifest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Scan Manifest</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if (!Browser::isChrome())
                        <div class="alert alert-alert row" style="
                            color: #856404;
                            background-color: #fff3cd;
                            border-color: #ffeeba;
                            height: 100px;">
                            <img src="{{ asset('assets/gsa/img/chrome.png') }}" class="col-2"
                                style="object-fit: contain;">
                            <div class="col-10">
                                Untuk kelancaran scan QR, Gunakan browser google chrome
                                <a
                                    href="https://www.google.com/chrome/?brand=CHBD&gclid=CjwKCAjw7fuJBhBdEiwA2lLMYXmsMZsuOvkh0CG2ld2zkAV2WnWiVakTdwrk5F-g2BPEY1yQjqNLGhoCqsoQAvD_BwE&gclsrc=aw.ds">
                                    click disini untuk download chrome
                                </a> atau download pada playstore/appstore
                            </div>
                        </div>
                    @endif
                    @foreach ($modalmanifest as $item)
                        {!!$item!!}
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalreport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Halaman Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($modalreport as $item)
                        {!!$item!!}
                    @endforeach 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
