<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>Bienvenido a HDLRS</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/legazy_pro/user.png')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

</head>

<style>
@font-face {
  font-family: "Work Sans";
  font-style: normal;
  font-weight: 300;
  src: local("Work Sans Light"), local("WorkSans-Light"),
    url(https://fonts.gstatic.com/s/worksans/v2/FD_Udbezj8EHXbdsqLUpl3hCUOGz7vYGh680lGh-uXM.woff)
      format("woff");
}
*,
*::before,
*::after {
  box-sizing: border-box;
}
html,
body {
  font-size: 12px;
  overflow: hidden;
  text-align: center;
  font-family: "Work Sans", sans-serif;
  line-height: 1.4;
  overflow: hidden;
  width: 100%;
}
.under,
html,
body {
  height: 100vh;
}
@keyframes charge {
  from {
    transform: translateY(2rem);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}
@keyframes wave {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
.under__content {
  color: #fff;
  font-weight: 300;
  padding: 0 2rem;
}
.under__content,
.under__footer {
  width: 100%;
  position: relative;
  z-index: 100;
}
.under,
.under__content,
.under__footer {
  display: flex;
  align-items: center;
  justify-content: center;
}
.under,
.under__content {
  flex-direction: column;
}
.under__footer,
.under__text,
.under__title {
  animation: charge 0.5s both;
}
.under__footer {
  flex-wrap: wrap;
  max-width: 600px;
  opacity: 0;
  animation-delay: 0.5s;
}
.under__subtitle,
.under__title {
  margin: 0;
}
.under__footer a {
  font-size: 20px;
  color: #fff;
  padding: 14px;
  background-color: rgba(0, 0, 0, 0.5);
  margin: 2px;
  border-radius: 3px;
  width: 51px;
  transition: background 0.3s;
}
.under__footer a:active,
.under__footer a:focus,
.under__footer a:hover {
  text-decoration: none;
}
.under__footer a:hover {
  background-color: rgba(0, 0, 0, 0.9);
}
.under__subtitle,
.under__text,
.under__title {
  backface-visibility: hidden;
}
.under__title {
  font-size: 2.4rem;
  font-weight: 300;
}
.under__text {
  max-width: 50rem;
  font-weight: 300;
  padding: 2rem 0;
  font-size: 1.3rem;
  color: rgba(255, 255, 255, 0.8);
  animation-delay: 0.3s;
}
@media (min-width: 768px) {
  html {
    font-size: 14px;
  }
  .under__title {
    font-size: 3.4rem;
  }
  .under__text {
    font-size: 1.5rem;
  }
}

.wave {
  opacity: 0.6;
  position: absolute;
  bottom: 40%;
  left: 50%;
  width: 6000px;
  height: 6000px;
  background: #000;
  margin-left: -3000px;
  transform-origin: 50% 48%;
  border-radius: 46%;
  animation: wave 12s infinite linear;
  pointer-events: none;
}
.wave2 {
  animation: wave 28s infinite linear;
  opacity: 0.3;
}
.wave3 {
  animation: wave 20s infinite linear;
  opacity: 0.1;
}

/*
=> Personalizar
*/
/* Wave
--------------------------------------------*/
.wave {
  background: #fff; /*color de fondo*/
}
/* Under
--------------------------------------------*/
.under {
  background-color: #0F88FF;
}

</style>

<body>
  <!-- Tutorial: http://bit.ly/2N0hpde -->
<div class='under'>
    <img src="{{asset('assets/img/HDLRS--vertical-color.png')}}" class="under__footer" width="100" height="450" alt="bg-img">
    <header class='under__content'>
      <h1 class='under__title mb-1 font-weight-bold'><b>Bienvenido a HDLRS</b></h1>
      {{-- <div class='under__text text-dark'>Estamos realizando cambios en la pagina. Síguenos en nuestras redes sociales para mantenerte informado.</div> --}}
    </header>
    <footer class='under__footer'>
      <a href='#' target='_blank'>
        <i class='fab fa-facebook-f'></i>
      </a>
      <a href='#' target='_blank'>
        <i class='fab fa-telegram'></i>
      </a>
      <a href='#' target='_blank'>
        <i class='fab fa-google-play'></i>
      </a>
      <a href='#' target='_blank'>
        <i class='fab fa-youtube'></i>
      </a>
    </footer>
    <a type="button" href="{{ route('login') }}" class="btn btn-info btn-lg text-dark mt-3">Entrar al Backoffice</a>
    <div class='wave'></div>
    <div class='wave wave2'></div>
    <div class='wave wave3'></div>

  </div>

</body>

</html>