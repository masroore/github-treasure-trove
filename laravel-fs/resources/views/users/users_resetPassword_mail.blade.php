<div class="content-table register" style="padding: 0rem 4rem;">
        <div style="background:#eaebef; padding: 1.5rem;">
            <center>
                <img src="{{ $message->embed(base_path() . '/public/img/login.png') }}" width="350" alt=“img” />
            </center> 
        </div>
        <div>
            <center>
                <img src="{{ $message->embed(base_path() . '/public/img/check.png') }}" alt=“img”/>
            </center> 
        </div>

      <h1><center><strong>{{ __('PASSWORD RESET')}}</strong></center></h1>
    
    <div class="content-space register">

         <p> {{ __('Hello, ') }} <strong>{{$info['name']}}</strong>,</p>

        <p>{{ __('Your password has been reset') }}</p>

        <hr>

       <center>
            <p><strong>{{ __('Login data') }}</strong><br>
            {{__('USER: ')}}<strong>{{$info['username']}}</strong><br>
            {{__('TEMPORARY PASSWORD: ')}}<strong>{{$info['password']}}</strong><br></p>
       
         </center>

      <p>{{ __('We invite you to enter our platform through the following link: ') }}<a href="{{$info['link']}}">{{ __('Here') }}</a></p>

        <p> {{ __('This is an automatic message from the FirstSwitch system.') }}<br>
        {{ __('Please do not reply to this email.') }}  </p>

        <div style="background:#eaebef; padding: 1.5rem;">

         <p> {{ __('If you are unaware of this operation, please contact our institution, writing to our support email: ') }}{{'support@firstswitch.com'}} </p>

        </div>
    </div>
</div>


    </div>
</div>