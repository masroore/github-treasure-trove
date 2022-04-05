@extends('backofice.layouts.dashboard')
@section('content')
<div class="carousel-inner" role="listbox">
    <img class="d-block w-100" src="{{asset('assets/img/home/formas_fondo1.png')}}" style="background: #F2F4F4;">
    <div class="container carousel-caption d-flex justify-content-start" style="top: 250px;left: 100px;">
        <div class="row">
            <div class="col-md-6">
                <div class="text-left">
                    <h1 style="font-size: 45px;  color: #303030;">Linea completa de<strong> Royal life </strong> </h1>
                    <p class="text-dark mt-2 mb-3">Gracias a nuestro amplio portafolio de productos, podrás encontrar la combinación perfecta, para ello
                        nos hemos aliado con los mejores laboratorios en los Estados Unidos que gracias a sus investigaciones Hoy te entregamos la mejor
                        del mercado, productos excepcionales, los mejores procesos y la mas alta pureza.</p>
                    <a href="{{route('shop.backofice')}}" class="btn btn-primario"><strong>ir a la tienda</strong></a>
                </div>
            </div>
            <div class="col-md-6">
                <img src="{{asset('assets/img/home/Polygon5.png')}}" alt=""
                    class="carousel-caption d-flex justify-content-center" style="top:-240px;left: -45px;">
                <img src="{{asset('assets/img/home/producto1.png')}}" alt=""
                    class="carousel-caption d-flex justify-content-center" style="top:-180px;left: -50px;">
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 pb-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <h1 class="texto-title mb-2"><strong> Categorias de nuetros productos </strong></h1>
            </div>
        </div>
    </div>
    <div class="contaniner">
        <div class="row d-flex justify-content-center">
            <div class="col-7">

            </div>
        </div>
    </div>


    <div class="">
        <div class="row d-flex justify-content-center">
            <div class="card mb-1 col-md-3 ml-md-1" style="height: 350px;background: white;">
                <img class="mx-auto d-block" src="{{asset('assets/img/home/producto21.png')}}" alt="" height="70%">
                <div class="text-center text-card"><strong>Cremas</strong></div>
                <a class="text-center" style="color: #303030;" href="{{route('shop.backofice')}}"> ver todos
                    los productos<img src="{{asset('assets/img/home/Arrow1.png')}}" alt=""
                        style="margin-left: 10px;"></a>
            </div>
            <div class="card mb-1 col-md-3 ml-md-1" style="height: 350px;background: white;">
                <img class="mx-auto d-block" src="{{asset('assets/img/home/producto21.png')}}" alt="" height="70%">
                <div class="text-center text-card"><strong>Cremas</strong></div>
                <a class="text-center" style="color: #303030;" href="{{route('shop.backofice')}}"> ver todos
                    los productos<img src="{{asset('assets/img/home/Arrow1.png')}}" alt=""
                        style="margin-left: 10px;"></a>
            </div>
            <div class="card mb-1 col-md-3 ml-md-1" style="height: 350px;background: white;">
                <img class="mx-auto d-block" src="{{asset('assets/img/home/producto21.png')}}" alt="" height="70%">
                <div class="text-center text-card"><strong>Cremas</strong></div>
                <a class="text-center" style="color: #303030;" href="{{route('shop.backofice')}}"> ver todos
                    los productos<img src="{{asset('assets/img/home/Arrow1.png')}}" alt=""
                        style="margin-left: 10px;"></a>
            </div>
            <div class="card mb-1 col-md-3 ml-md-1" style="height: 350px;background: white;">
                <img class="mx-auto d-block" src="{{asset('assets/img/home/producto21.png')}}" alt="" height="70%">
                <div class="text-center text-card"><strong>Cremas</strong></div>
                <a class="text-center" style="color: #303030;" href="{{route('shop.backofice')}}"> ver todos
                    los productos<img src="{{asset('assets/img/home/Arrow1.png')}}" alt=""
                        style="margin-left: 10px;"></a>
            </div>
            <div class="card mb-1 col-md-3 ml-md-1" style="height: 350px;background: white;">
                <img class="mx-auto d-block" src="{{asset('assets/img/home/producto21.png')}}" alt="" height="70%">
                <div class="text-center text-card"><strong>Cremas</strong></div>
                <a class="text-center" style="color: #303030;" href="{{route('shop.backofice')}}"> ver todos
                    los productos<img src="{{asset('assets/img/home/Arrow1.png')}}" alt=""
                        style="margin-left: 10px;"></a>
            </div>
            <div class="card mb-1 col-md-3 ml-md-1" style="height: 350px;background: white;">
                <img class="mx-auto d-block" src="{{asset('assets/img/home/producto21.png')}}" alt="" height="70%">
                <div class="text-center text-card"><strong>Cremas</strong></div>
                <a class="text-center" style="color: #303030;" href="{{route('shop.backofice')}}"> ver todos
                    los productos<img src="{{asset('assets/img/home/Arrow1.png')}}" alt=""
                        style="margin-left: 10px;"></a>
            </div>
        </div>
    </div>
</div>
<div class="p-1 pb-5" style="background:#F0FFFA;">
    <div class="container mb-3">
        <h1 class="texto-title mt-5 mb-1 ml-5 pl-3"><strong>Los más vendidos</strong></h1>
        <p class="ml-5 pl-3" style="color: #303030;font-size: 15px;">Lorem, ipsum dolor sit amet, consectetur
            adipisicing elit. Purus malesuada et.
        </p>
        <div class="row d-flex justify-content-center">
            <div class="card-body col-md-3 mb-1 ml-md-2"
                style="background: white;border-radius: 10px;padding: 0.8rem;max-width: 27%;">
                <div class="d-flex">
                    <div style="background:#66FFCC;border-radius: 10px;width: 100px;">
                        <img class="mx-auto d-block" src="{{asset('assets/img/home/producto24.png')}}"
                            style="height: 125px;">
                    </div>
                    <div class="col-md-7">
                        <h5><strong>Pomada CBD</strong></h5>
                        <p class="card-text" style="color: #303030; width: 160px;font-size: 13px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id pellentesque auctor.</p>
                        <a href="" class="btn btn-cre">
                            <p style="margin-top: -9px; margin-left: -10px;">cremas</p>
                        </a>
                        <p style="color: #303030;margin-left: 140px;font-size: 20px;margin-bottom: 0;margin-top: -5px;">
                            <strong>31$</strong></p>
                    </div>
                </div>
            </div>
            <div class="card-body col-md-3 mb-1 ml-md-2"
                style="background: white;border-radius: 10px;padding: 0.8rem;max-width: 27%;">
                <div class="d-flex">
                    <div style="background:#66FFCC;border-radius: 10px;width: 100px;">
                        <img class="mx-auto d-block" src="{{asset('assets/img/home/producto24.png')}}"
                            style="height: 125px;">
                    </div>
                    <div class="col-md-7">
                        <h5><strong>Pomada CBD</strong></h5>
                        <p class="card-text" style="color: #303030; width: 160px;font-size: 13px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id pellentesque auctor.</p>
                        <a href="" class="btn btn-cre">
                            <p style="margin-top: -9px; margin-left: -10px;">cremas</p>
                        </a>
                        <p style="color: #303030;margin-left: 140px;font-size: 20px;margin-bottom: 0;margin-top: -5px;">
                            <strong>31$</strong></p>
                    </div>
                </div>
            </div>
            <div class="card-body col-md-3 mb-1 ml-md-2"
                style="background: white;border-radius: 10px;padding: 0.8rem;max-width: 27%;">
                <div class="d-flex">
                    <div style="background:#66FFCC;border-radius: 10px;width: 100px;">
                        <img class="mx-auto d-block" src="{{asset('assets/img/home/producto24.png')}}"
                            style="height: 125px;">
                    </div>
                    <div class="col-md-7">
                        <h5><strong>Pomada CBD</strong></h5>
                        <p class="card-text" style="color: #303030; width: 160px;font-size: 13px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id pellentesque auctor.</p>
                        <a href="" class="btn btn-cre">
                            <p style="margin-top: -9px; margin-left: -10px;">cremas</p>
                        </a>
                        <p style="color: #303030;margin-left: 140px;font-size: 20px;margin-bottom: 0;margin-top: -5px;">
                            <strong>31$</strong></p>
                    </div>
                </div>
            </div>
            <div class="card-body col-md-3 mb-1 ml-md-2"
                style="background: white;border-radius: 10px;padding: 0.8rem;max-width: 27%;">
                <div class="d-flex">
                    <div style="background:#66FFCC;border-radius: 10px;width: 100px;">
                        <img class="mx-auto d-block" src="{{asset('assets/img/home/producto24.png')}}"
                            style="height: 125px;">
                    </div>
                    <div class="col-md-7">
                        <h5><strong>Pomada CBD</strong></h5>
                        <p class="card-text" style="color: #303030; width: 160px;font-size: 13px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id pellentesque auctor.</p>
                        <a href="" class="btn btn-cre">
                            <p style="margin-top: -9px; margin-left: -10px;">cremas</p>
                        </a>
                        <p style="color: #303030;margin-left: 140px;font-size: 20px;margin-bottom: 0;margin-top: -5px;">
                            <strong>31$</strong></p>
                    </div>
                </div>
            </div>
            <div class="card-body col-md-3 mb-1 ml-md-2"
                style="background: white;border-radius: 10px;padding: 0.8rem;max-width: 27%;">
                <div class="d-flex">
                    <div style="background:#66FFCC;border-radius: 10px;width: 100px;">
                        <img class="mx-auto d-block" src="{{asset('assets/img/home/producto24.png')}}"
                            style="height: 125px;">
                    </div>
                    <div class="col-md-7">
                        <h5><strong>Pomada CBD</strong></h5>
                        <p class="card-text" style="color: #303030; width: 160px;font-size: 13px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id pellentesque auctor.</p>
                        <a href="" class="btn btn-cre">
                            <p style="margin-top: -9px; margin-left: -10px;">cremas</p>
                        </a>
                        <p style="color: #303030;margin-left: 140px;font-size: 20px;margin-bottom: 0;margin-top: -5px;">
                            <strong>31$</strong></p>
                    </div>
                </div>
            </div>
            <div class="card-body col-md-3 mb-1 ml-md-2"
                style="background: white;border-radius: 10px;padding: 0.8rem;max-width: 27%;">
                <div class="d-flex">
                    <div style="background:#66FFCC;border-radius: 10px;width: 100px;">
                        <img class="mx-auto d-block" src="{{asset('assets/img/home/producto24.png')}}"
                            style="height: 125px;">
                    </div>
                    <div class="col-md-7">
                        <h5><strong>Pomada CBD</strong></h5>
                        <p class="card-text" style="color: #303030; width: 160px;font-size: 13px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id pellentesque auctor.</p>
                        <a href="" class="btn btn-cre">
                            <p style="margin-top: -9px; margin-left: -10px;">cremas</p>
                        </a>
                        <p style="color: #303030;margin-left: 140px;font-size: 20px;margin-bottom: 0;margin-top: -5px;">
                            <strong>31$</strong></p>
                    </div>
                </div>
            </div>
            <div class="card-body col-md-3 mb-1 ml-md-2"
                style="background: white;border-radius: 10px;padding: 0.8rem;max-width: 27%;">
                <div class="d-flex">
                    <div style="background:#66FFCC;border-radius: 10px;width: 100px;">
                        <img class="mx-auto d-block" src="{{asset('assets/img/home/producto24.png')}}"
                            style="height: 125px;">
                    </div>
                    <div class="col-md-7">
                        <h5><strong>Pomada CBD</strong></h5>
                        <p class="card-text" style="color: #303030; width: 160px;font-size: 13px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id pellentesque auctor.</p>
                        <a href="" class="btn btn-cre">
                            <p style="margin-top: -9px; margin-left: -10px;">cremas</p>
                        </a>
                        <p style="color: #303030;margin-left: 140px;font-size: 20px;margin-bottom: 0;margin-top: -5px;">
                            <strong>31$</strong></p>
                    </div>
                </div>
            </div>
            <div class="card-body col-md-3 mb-1 ml-md-2"
                style="background: white;border-radius: 10px;padding: 0.8rem;max-width: 27%;">
                <div class="d-flex">
                    <div style="background:#66FFCC;border-radius: 10px;width: 100px;">
                        <img class="mx-auto d-block" src="{{asset('assets/img/home/producto24.png')}}"
                            style="height: 125px;">
                    </div>
                    <div class="col-md-7">
                        <h5><strong>Pomada CBD</strong></h5>
                        <p class="card-text" style="color: #303030; width: 160px;font-size: 13px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id pellentesque auctor.</p>
                        <a href="" class="btn btn-cre">
                            <p style="margin-top: -9px; margin-left: -10px;">cremas</p>
                        </a>
                        <p style="color: #303030;margin-left: 140px;font-size: 20px;margin-bottom: 0;margin-top: -5px;">
                            <strong>31$</strong></p>
                    </div>
                </div>
            </div>
            <div class="card-body col-md-3 mb-1 ml-md-2"
                style="background: white;border-radius: 10px;padding: 0.8rem;max-width: 27%;">
                <div class="d-flex">
                    <div style="background:#66FFCC;border-radius: 10px;width: 100px;">
                        <img class="mx-auto d-block" src="{{asset('assets/img/home/producto24.png')}}"
                            style="height: 125px;">
                    </div>
                    <div class="col-md-7">
                        <h5><strong>Pomada CBD</strong></h5>
                        <p class="card-text" style="color: #303030; width: 160px;font-size: 13px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Id pellentesque auctor.</p>
                        <a href="" class="btn btn-cre">
                            <p style="margin-top: -9px; margin-left: -10px;">cremas</p>
                        </a>
                        <p style="color: #303030;margin-left: 140px;font-size: 20px;margin-bottom: 0;margin-top: -5px;">
                            <strong>31$</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="carousel-inner d-flex" style="background: #173138">
    <div class="container carousel-caption" style="font-size: 40px;top: 100px;text-align: left;">
        <div class="row">
            <div class="col-6">
                <strong>Royal life el equilibrio perfecto.</strong>
            </div>
        </div>
    </div>
    <div class="container carousel-caption" style="top: 250px;text-align: left;font-size:18px;">
        <div class="row">
            <div class="col-sm-6">
                <div class="">
                    Cada proceso de nuestros productos son cuidadosamente vigilados por expertos,
                    nuestros laboratorios aliados garantizan el CBD mas puro del mercado y nuestra
                    linea de productos lo demuestra.
                </div>
            </div>
        </div>
    </div>
    <img src="{{asset('assets/img/home/formas_fondo2.png')}}" alt="" width="50%">
    <img src="{{asset('assets/img/home/cbd1.png')}}" alt="" width="50%">
</div>
<div class="container mt-5">
    <div class="text-center">
        <h1 class="texto-title pb-3"><strong> Productos </strong></h1>

    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1 ml-1" style="">
            <div class="card-body product text-center">
                <p class="text-center card-h">
                    <img class="mx-auto d-block img-ho" src="{{asset('assets/img/home/producto21.png')}}">
                </p>
                <div class="card-body">
                    <a href="" class="btn btn-cren">
                        <p style="margin-left: -25px;margin-top: -10px;">cremas</p>
                    </a>
                    <p class="text-right" style="color:black;font-size:25px;"> <strong>$31</strong></p>
                    <h3 class="text-left" style="color:black;"><strong>Pomada CBD</strong></h3>
                    <p class="text-left" style="color:#303030;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet lobortis venenatis vel integer. Odio feugiat tortor eget porttitor.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="text-center">
        <h1 class="texto-title"><strong> Clientes satisfechos </strong></h1>
    </div>
</div>
<div class="testimonials-clean">
    <div class="container">
        <div class="row people">
            <div class="col-md-6 item">
                <div class="box">
                    <div style="margin-top: 8px;">
                        <img src="{{ asset('assets/img/home/Vector.png') }}" alt="">
                        <img src="{{ asset('assets/img/home/Vector.png') }}" alt="">
                        <img src="{{ asset('assets/img/home/Vector.png') }}" alt="">
                        <img src="{{ asset('assets/img/home/Vector.png') }}" alt="">
                        <img src="{{ asset('assets/img/home/Vector.png') }}" alt="">
                    </div>
                    <div>
                        <p class="description" style="margin-top: 30px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Vel habitant elementum volutpat neque viverra. Risus felis
                            metus, enim amet suspendisse elit in. Egestas turpis vitae
                            et, et nibh porttitor. Accumsan eget.</p>
                    </div>
                </div>
                <div class="author"><img class="rounded-circle " src="{{asset('assets/img/home/Ellipse.png')}}"
                        style="margin-top: 5px;">
                    <h5 class="name" style="margin-top: 5px;">Antonio Medina</h5>
                    <p class="title"><strong>Cliente</strong></p>
                </div>
            </div>
            <div class="col-md-6 item">
                <div class="box">
                    <div style="margin-top: 8px;">
                        <img src="{{ asset('assets/img/home/Vector.png') }}" alt="">
                        <img src="{{ asset('assets/img/home/Vector.png') }}" alt="">
                        <img src="{{ asset('assets/img/home/Vector.png') }}" alt="">
                        <img src="{{ asset('assets/img/home/Vector.png') }}" alt="">
                        <img src="{{ asset('assets/img/home/Vector.png') }}" alt="">
                    </div>
                    <p class="description" style="margin-top: 30px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vel habitant elementum volutpat neque viverra. Risus felis metus, enim amet suspendisse elit in. Egestas turpis vitae et, et nibh porttitor. Accumsan eget.</p>
                </div>
                <div class="author"><img class="rounded-circle" src="{{asset('assets/img/home/Ellipse1.png')}}"
                        style="margin-top: 5px;">
                    <h5 class="name" style="margin-top: 5px;">Felipe Minaya</h5>
                    <p class="title"><strong>Cliente</strong></p>
                </div>
            </div>
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <img src="{{asset('assets/img/home/Rectangle29.png')}}" alt="" style="margin-top: -215px; width: 70%;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row d-flex justify-content-center mt-3">
        <div class="carousel-inner mb-2 ml-1 " style="background: #173138;border-radius: 1rem;box-shadow: 0 8px 40px -8px #cfd4d5;">
            <div class="carousel-caption" style="top: 50px;font-size: 40px;">
                <strong>Faucibus pulvinar euismod tincidunt</strong>
            </div>
            <div class="carousel-caption" style="top: 140px;font-size: 16px;">
                Lorem ipsum dolor sit amet consectetur adipisicing elit.Quam blandit ac commodo turpis turpis. Ipsum adipiscing lacus
                , quis aliquam magna leo. Quam convallis pellentesque sed ipsum sit malesuada libero fermentum. Volutpat
                 dolor vitae adipiscing mi. ut nec felis dolor a eu viverra sed adipiscing.
            </div>
            <a href="{{route('contact_us')}}" class="btn btn-pri"><strong>Contáctanos</strong></a>
            <img class="w-100" src="{{asset('assets/img/home/formas_fondo22.png')}}" alt="">
        </div>
    </div>
</div>
@endsection
