@if(isset ($errors) && count($errors) > 0)

    <div class="toast" data-autohide="false" style="position: absolute; top: 70px; right: 0; z-index: 99;">
        <div class="toast-header">
            <svg class=" rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                <rect fill="#007aff" width="100%" height="100%" /></svg>
            <strong class="mr-auto">Error Reported</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body text-dark">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    </div>


@endif

@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))


                @foreach ($data as $msg)



                    <div class="toast" data-autohide="false" style="position: absolute; top: 70px; right: 0; z-index: 99;">
                        <div class="toast-header">
                            <svg class=" rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                                <rect fill="#007aff" width="100%" height="100%" /></svg>
                            <strong class="mr-auto">Action Completed</strong>
                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body text-dark">
                            {{ $msg }}
                        </div>
                    </div>

                @endforeach


    @else
        <div class="toast" data-autohide="false" style="position: absolute; top: 70px; right: 0; z-index: 99;">
            <div class="toast-header">
                <svg class=" rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                    <rect fill="#007aff" width="100%" height="100%" /></svg>
                <strong class="mr-auto">Action Completed</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body text-dark">
                {{ $data }}
            </div>
        </div>

    @endif
@endif
