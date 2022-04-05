<!DOCTYPE html>
<html>
<head>
    <title> Laravel Signature Pad Example - codechief.org </title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw==" crossorigin="anonymous"></script></script>
    <script type="text/javascript" src="{{url('/assets/js/jquery.signature.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/jquery.signature.css')}}">

    <style>
        .kbw-signature { width: 100%; height: 400px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
    </style>

</head>
<body class="bg-dark">
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    <h5>Estimate Package Approval Confirmation </h5>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form method="POST" action="/customerSignature/{{$pid}}/{{$eid}}">
                        @csrf
                        <div class="col-xl-12">
                            I've reviewed all the packages offered to me on the previous page, I selected package # {{$estimate->id}}-{{$package->id}}
                            for a total of ${{$package->chargedPrice}}. The deposit for this package is ${{$package->deposit}}. I understand that by signing below,
                            I am entering into a promise to pay the amount of the package, I also understand that deposit's are
                            due upon accepting the package.
                        </div>
                        <div class="col-md-12">
                            <label class="" for="">Signature:</label>
                            <br/>
                            <div id="sig" ></div>
                            <br/>
                            <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                            <textarea id="signature64" name="signed" style="display: none"></textarea>
                        </div>
                        <br/>
                        <button class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>

</body>
</html>

