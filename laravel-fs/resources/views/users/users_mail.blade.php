<div class="content-table register" style="padding: 0rem 4rem;">
        <div style="background:#eaebef; padding: 1.5rem;">
            <center>
                <img src="{{ $message->embed(base_path() . '/public/img/login.png') }}" alt=“img” width="350" />
            </center> 
        </div>
        <div>
            <center>
                <img src="{{ $message->embed(base_path() . '/public/img/check.png') }}" alt=“img” />
            </center> 
        </div>

    <h1><center><strong>{{ __('WELCOME')}}</strong></center></h1>
    
    <div class="content-space register">

        <p> {{ __('Hello, ') }} <strong>{{$info['name']}}</strong>,</p>

        <p>{{ __('Thank you for signing up for ')}}<strong>{{__('FirstSwitch')}}</strong></p>
    
        <p>{{ __('We invite you to enter our platform through the following link: ') }}<a href="{{$info['link']}}">{{ __('Here') }}</a></p>

        <hr>
         
        <center>
            <p><strong>{{ __('Login data') }}</strong><br>
            {{__('USER: ')}}<strong>{{$info['username']}}</strong><br>
            {{__('TEMPORARY PASSWORD: ')}}<strong>{{$info['password']}}</strong><br></p>
       
         </center>

        <p> {{ __('This is an automatic message confirming your registration in the FirstSwitch system.') }}<br>
        {{ __('Please do not reply to this email.') }}  </p>

        <div style="background:#eaebef; padding: 1.5rem;">

            <p> {{ __('If you are unaware of this operation, please contact our institution, writing to our support email: ') }}{{'support@firstswitch.com'}} </p>

        </div>
    </div>
</div>

