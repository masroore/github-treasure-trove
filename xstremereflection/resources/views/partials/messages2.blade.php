
@if(isset ($errors) && count($errors) > 0)

    @foreach($errors->all() as $error)
        <script>
            //Notify
            $.notify({
                icon: 'fas fa-bomb',
                title: 'Action Completed',
                message: '{{ $error }}',
            },{
                type: 'error',
                placement: {
                    from: "bottom",
                    align: "right"
                },
                time: 5000,
            });

        </script>
    @endforeach



@endif
@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))


        @foreach ($data as $msg)

            <script>

                    console.log( "ready!" );
                    //Notify
                    $.notify({
                        icon: 'fas fa-shield-check',
                        title: 'Action Completed',
                        message: '{{ $msg }}',
                    },{
                        type: 'success',
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        time: 5000,
                    });

            </script>
        @endforeach


    @else
        <script>
            $( document ).ready(function() {
                console.log( "ready!" );
                //Notify
                $.notify({
                    icon: 'fas fa-shield-check',
                    title: 'Action Completed',
                    message: '{{ $data }}',
                },{
                    type: 'success',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    time: 5000,
                });
            });


        </script>
       @endif
@endif
