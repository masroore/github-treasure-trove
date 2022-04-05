<link href="{{ asset('css/fontawesome/all.min.css') }}" rel="stylesheet">
<div class="page_content_wrap">

   <div class="content_wrap">
        <div class="text-align-center error-login">
        
            <i class="fa fa-exclamation-triangle"></i>
         	 <p class="subtitulo_login"><strong>{{__('Permission Denied')}}</strong></p>
         	 <p class="contenido_login">{{__('You do not have permission to perform this action')}} </p>
        </div>
    </div>
</div>

<style>

body{
    margin:0;
    background:#eaebef;
    color: #404040;
    font-family: 'Poppins-Black', sans-serif;     
}
.page_content_wrap {
  /*  background: linear-gradient(45deg, #bbbbbb, #fff);*/
    width: 100%;
    height: 100vh;
    background-image: radial-gradient(rgba(0,0,0,.07) 5%, transparent 0);
    /*background-size: 30px 30px;    */
}
.content_wrap {
    background: #fff;
    border-top: 45px solid #171717;
    position: absolute;
    z-index: 1;
    left: 50%;
    display: block;
    transform: translate(-50%, -50%);
    top: 50%;
    width: 400px;
    color: #404040;
    border-radius: 10px;
    box-shadow: -10px 10px 2px rgb(0 0 0 / 30%);
    padding: 0rem 2rem 2rem 2rem;
    font-size: 1.2em;
}
.content_wrap:before {
    content: "...";
    position: absolute;
    font-size: 100px;
    color: #f36d17;
    margin: -110px 0px 0px -10px;
    font-family: calibri;
}  
.content_wrap i, .content_wrap .svg-inline--fa {
    text-align: center;
    width: 100%;
    display: block;
    font-size: 40px;
    color: #f36d17;
    margin: 2rem 0 0rem 0;
}
.text-align-center.error-login {
    text-align: center;
}

p.subtitulo_login {
    text-align: center;
    text-transform: uppercase;
    font-size: 1.5em;
    font-family: 'Poppins-Black', sans-serif;
}
.btn-secondary.back:before {
    font-weight: 700;
    content: "\f060";
    font-family: 'Font Awesome 5 Free';
     margin: 0 10px 0 0;
}
a {
    text-decoration: none;
}

</style>
@if (\Request::ajax())
<script type="text/javascript">
    /*document.location.reload();*/
</script>
@endif