@extends('layouts.layout')
@section('title' ,'Contact Me')

@section('content')

    <div class="col">
        <div class="write-post">
            <div class="post-comments">
                <h2 class="comments-title">Send me an message</h2>
                <div class="comment-respond">
                    <form action="{{ route('contact.post') }}" method="post" id="form">
                    @csrf
                    <!-- Name Form Input -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <!-- Email Form Input -->
                        <div class="form-group">
                            <label for="email">E-mail Address</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <!-- Message Form Input -->
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea rows="8" name="message" id="message" class="form-control" required></textarea>
                        </div><!-- Message Form Input End -->

                        <!--  Displaying The Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                    @endif
                    <!-- Displaying The Validation Errors -->


                        <div class="progress form-group">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                 aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                 style="width: 0%;background-color: #b59f5b"></div>
                        </div>
                        <p class="form-submit">
                            <input type="submit" class="flat-btn" value="Send"/>
                        </p>
                    </form>
                </div>
                <!-- #respond -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#form").submit(function (event) {
                event.preventDefault(); //prevent default action
                var post_url = $(this).attr("action"); //get form action url
                var request_method = $(this).attr("method"); //get form GET/POST method
                var form_data = new FormData(this); //Encode form elements for submission

                $.ajax({
                    url: post_url,
                    type: request_method,
                    data: form_data,
                    contentType: false, //contentType is set to false otherwise default is set "application/x-www-form-urlencoded", which is no good for uploading files, setting it false will post data as "multipart/form-data".
                    processData: false, // processData, which must also be set to false, otherwise jQuery will try to serialize the FormData object into query string, and you might end up with an Illegal invocation error.
                    xhr: function () {
                        //upload Progress
                        var xhr = $.ajaxSettings.xhr();
                        if (xhr.upload) {
                            $('.submit').val('Sending').attr("disabled", true);
                            xhr.upload.addEventListener('progress', function (event) {
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                    percent = Math.ceil(position / total * 100);
                                }
                                //update progressbar
                                $(".progress-bar").css("width", +percent + "%");
                            }, true);
                        }
                        return xhr;
                    }
                }).done(function (response) { //
                    //update progressbar
                    $(".progress-bar").css("width", "0%");
                    $('.submit').val('Send').removeAttr("disabled");
                    toastr.success(response.success); // success notification
                    $("#form").trigger("reset"); // form reset
                });
            });
        });
    </script>
@endsection
