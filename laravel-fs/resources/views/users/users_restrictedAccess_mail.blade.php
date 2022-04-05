<div class="content-table register" style="padding: 0rem 8rem;">
        <div style="background:#eaebef; padding: 1.5rem;">
            <center>
                <img src="{{ $message->embed(base_path() . '/public/img/login.png') }}" alt=“img” width="350" />
            </center> 
        </div>
        <div>
            <center>
                <img src="{{ $message->embed(base_path() . '/public/img/checktimes.png') }}" alt=“img” />
            </center> 
        </div>

      <h1><center><strong>{{ __('RESTRICTED ACCESS')}}</strong></center></h1>
    
    <div class="content-space register">

        <center><p>{{ __('An unauthorized access attempt was detected from the following user:') }}</p></center>

        <hr>

       <center>
            <p><strong>{{ __('User data') }}</strong><br>
            {{__('USERNAME: ')}}<strong>{{$info['username']}}</strong><br>
            {{__('USER: ')}}<strong>{{$info['name']}}</strong><br></p>
            {{__('DATE: ')}}<strong>{{$info['date']}}</strong><br></p>
            {{__('TIME: ')}}<strong>{{$info['time']}}</strong><br></p>
        </center>

        <p> {{ __('This is an automatic message from the FirstSwitch system.') }}<br>
        {{ __('Please do not reply to this email.') }}  </p>

        <div style="background:#eaebef; padding: 1.5rem;">

         <p> {{ __('If you are unaware of this operation, please contact our institution, writing to our support email: ') }}{{'support@firstswitch.com'}} </p>

        </div>
    </div>
</div>


    </div>
</div>