<div class="bg-green-500 h-0">
    @if( get_cf_ip_country() != 'KR') 
        <div id="recaptcha-service" class="g-recaptcha"
            data-callback="recaptchaCallback"
            data-sitekey=""
        >
        </div>
        {{-- <div class="text-xs text-red-400">{{ get_cf_ip_country()  }}</div> --}}

        <div class="">
            @php

// RECAPCHA_SITE_KEY=6Le4ljcaAAAAAPvQQ7WMcJvtJUzKb3pUlkOM6d5F
// RECAPCHA_SECRET_KEY=6Le4ljcaAAAAAKAtJP230x_DnYX-E0GEfd4qHXX_

                // $recapcha_site_key= env('RECAPCHA_SITE_KEY');
                $recapcha_site_key= '6Le4ljcaAAAAAPvQQ7WMcJvtJUzKb3pUlkOM6d5F';
                $session_key = 'counter002';
                $time_key = 'timer002';
                $value = session($session_key);
                $interval = 60  * 60 ;
                // $interval = 10 ;
                $checkTime = false;
                if( $value ){
                    $value = (int) $value ;
                    $saved_time =  \Carbon\Carbon::parse( session( $time_key) );
                    $diff =  \Carbon\Carbon::now()->diffInSeconds( $saved_time ) ;
                    if( $diff > $interval ){
                        session()->forget( [ $session_key, $time_key] );
                        session([ $time_key =>  \Carbon\Carbon::now()->toDateTimeString() ]);
                        session([$session_key=> 1]);
                        $checkTime = true;
                    } else{
                        session([$session_key=> $value + 1 ]);
                    }
                } else {
                    session([ $time_key =>  \Carbon\Carbon::now()->toDateTimeString() ]);
                    session([$session_key=> 1]);
                    $checkTime = true;
                    $diff = null;
                }
            @endphp
            
            {{-- recapcha_site_key : {{ $recapcha_site_key  }}
                <br>
                value =-=== {{ $value }}
                <br>
                diff : {{ $diff }}
                <br>
                <br>
                checkTime ; {{ $checkTime }} --}}


            @if ( $checkTime )
                <div id="recapcha-container">
                    <div id="recaptcha-service" 
                        class="g-recaptcha"
                        data-callback="recaptchaCallback"
                        data-sitekey=""
                    >
                    </div>
                    
                    <script src="https://www.google.com/recaptcha/api.js?render={{ $recapcha_site_key }}"></script>
                </div>
                <script>
                    window.recaptchaCallback = undefined;

                    grecaptcha.ready(function() {
                        grecaptcha.execute("{{ $recapcha_site_key }}", {action: 'homepage'}).then(function(token) {

                        // console.log('token', token)
                            var payload = {
                                token : token
                            }
                            var data = new FormData();
                            data.append( "json", JSON.stringify( payload ) );
                            var headers = {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
                            }

                            fetch('/recapcha-ajax', {
                                method: 'POST', 
                                headers: headers,
                                body: data
                            })
                            .then(function (response) {
                                return response.json();
                            }).then( function( body ){
                                // console.log(body);
                                if( parseInt( body.success ) === 1 ) {
                                    if( parseFloat( body.score ) < 0.5  ) {
                                        window.location.replace("/empty");    
                                    } 
                                } else {
                                    // window.location.replace("/empty");
                                }
                            })
                        });
                    });
                </script>
            @endif
        </div>
    @endif 
</div>