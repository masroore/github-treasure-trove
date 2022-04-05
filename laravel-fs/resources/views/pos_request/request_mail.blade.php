<div class="content-table register" style="padding: 0rem 4rem;">
        <div style="background:#eaebef; padding: 1.5rem;">
            <center>
                <img src="{{ $message->embed(base_path() . '/public/img/login.png') }}" alt=“img” width="350" />
            </center> 
        </div>

    <h1><center><strong>{{ __('NEW POS REQUEST')}}</strong></center></h1>
    
    <div class="content-space register">

        <p> {{__('A new POS request has been processed in the system with the following data: ') }}</p>

        <hr>
         
        <center>
            <p><strong>{{ __('POS request data') }}</strong><br>
            {{__('RESPONSIBLE: ')}}<strong>{{$info['responsible']}}</strong><br>
            {{__('REQUEST NUMBER: ')}}<strong>{{$info['request']}}</strong><br></p>
            {{__('MODEL: ')}} @foreach($info['model'] as $key => $value) <strong>{{$value['model_name']}}</strong> </p> @endforeach <br>
            {{__('AMOUNT: ')}}@foreach($info['model'] as $key => $value) <strong>{{$value['amount']}}</strong> </p> @endforeach <br>
            {{__('DATE: ')}}<strong>{{$info['date']}}</strong><br></p>
       
         </center>

        <div style="background:#eaebef; padding: 1.5rem;">

            <p> {{ __('If you are unaware of this operation, please contact our institution, writing to our support email: ') }}{{'support@firstswitch.com'}} </p>

        </div>
    </div>
</div>

