{{ Form::open(['id' => 'form_re_login' ,'class' => 'form' , 'autocomplete' => 'Off']) }}
<div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-user"></i> {{__('Login')}}</h5>
</div>
<div class="content-space">
    <div class="content-table inside content-space pa-1">
		<div  class="modal-body">
			<div class="anuncement" role="alert">
			<list class="mb-2">{{__('To retrieve the session, enter your details again.')}}</list>
			</div>
			<div id="login-rebox">
			    <div class="inputBox">
			        <div class="form-floating mb-3">
			            {{ Form::text('username', null, ['class' => 'form-control min required', "required"=>"required",'placeholder' => 'Name', 'id'=> 'username'])}}
			            {!! Html::decode(Form::label('username','<i class="fa fa-user"></i>  '.__('Username'))) !!}
			        </div>
			    </div>
			    <div class="inputBox">
			        <div class="form-floating">                       
			            <span class="input-group-append eye">
			                <a href="javascript:show_pwd('password');" class="btn btn-outline-default btn-sm btn-icon" ><i id="{!! 'icon_password' !!}" class="far fa-eye-slash" title="Mostrar"></i></a>
			            </span>                  
			            {{ Form::password('password', ['class' => 'form-control eye min required',  "required"=>"required" , 'placeholder' => 'Password', 'id'=> 'password'])}}
			            {!! Html::decode(Form::label('password','<i class="fa fa-lock"></i>  '.__('Password'))) !!}
			        </div>
		        </div>
		    </div> 
		</div> 
		<div class="col-5 mx-auto mt-2 mb-2">  
		    <button type="button" onClick="re_login()" id="reLoginBotton" class="btn btn-primary">{{__('Login')}}</button>
		</div>
	</div> 
</div> 
{{ Form::close() }}   
<script type="text/javascript">
	var mostrar_pass = '';
    $(document).ready(function () {
    	session_close();
    });
	function show_pwd(valor) {
		if (valor == 'password') {
			if (mostrar_pass == '') {
				$('#password').attr('type', 'text');
				$('#icon_password').removeClass('fa-eye-slash');
				$('#icon_password').addClass('fa-eye');
				mostrar_pass = 'x';
			} else {
				$('#password').attr('type', 'password');
				$('#icon_password').removeClass('fa-eye');
				$('#icon_password').addClass('fa-eye-slash');
				mostrar_pass = '';
			}
		}
	}
	function re_login(){
		if ($("#form_re_login").valid()){
			$("#reLoginBotton").html(' <i class="fas fa-spinner fa-spin"></i> {{__("Login")}}').prop("disabled", true);
			$.get('{{route("login.modal")}}', $("#form_re_login").serialize(),  function (response){
				if (response.reload == 1){
					window.location.reload();
				}
				if (response.status == 1){
					idleLogout();
					$('#reLogin').modal('hide');
				}else{
					toastr[response.type](response.message);
					$("#reLoginBotton").html('{{__("Login")}}').prop("disabled", false);
				}
			}, 'json');
		}
	}
	function session_close() {
	    var time_remaing = 0;
	    var time_out = 300; //five seconds equivalent to three minutes
	    var myVar = setInterval(myTimer, 1000);
	    function myTimer() {
	        time_remaing++;
	        if (time_remaing == time_out) {
				window.location.reload();
	        }
	    }
	}
</script>

