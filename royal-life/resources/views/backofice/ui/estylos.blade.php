

@push('custom_css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;500&display=swap');

.zoom:hover {
    -webkit-transform:scale(1.05);
    -moz-transform:scale(1.05);
    -ms-transform:scale(1.05);
    -o-transform:scale(1.05);
    transform:scale(1.05);

    -webkit-transition:all 0.3s ease;
    -moz-transition:all 0.3s ease;
    -o-transition:all 0.3s ease;
    -ms-transition:all 0.3s ease;
    width:100%;
    box-shadow: 0 9px 9px 0 rgba(0, 0, 0, 0.16), 0 9px 9px 0 rgba(0, 0, 0, 0.12) !important;
}

.zoom:active {
    -webkit-transform:scale(1);
    -moz-transform:scale(1);
    -ms-transform:scale(1);
    -o-transform:scale(1);
    transform:scale(1);

    -webkit-transition:all 0.3s ease;
    -moz-transition:all 0.3s ease;
    -o-transition:all 0.3s ease;
    -ms-transition:all 0.3s ease;
    width:100%;
}

.zoom2:hover {
    -webkit-transform:scale(1.05);
    -moz-transform:scale(1.05);
    -ms-transform:scale(1.05);
    -o-transform:scale(1.05);
    transform:scale(1.05);

    -webkit-transition:all 0.3s ease;
    -moz-transition:all 0.3s ease;
    -o-transition:all 0.3s ease;
    -ms-transition:all 0.3s ease;
    width:30%;
    box-shadow: 0 9px 9px 0 rgba(0, 0, 0, 0.16), 0 9px 9px 0 rgba(0, 0, 0, 0.12) !important;

}

.zoom2:active {
    -webkit-transform:scale(1);
    -moz-transform:scale(1);
    -ms-transform:scale(1);
    -o-transform:scale(1);
    transform:scale(1);

    -webkit-transition:all 0.3s ease;
    -moz-transition:all 0.3s ease;
    -o-transition:all 0.3s ease;
    -ms-transition:all 0.3s ease;
    width:30%;
}

.zoom3:hover {
    -webkit-transform:scale(1.05);
    -moz-transform:scale(1.05);
    -ms-transform:scale(1.05);
    -o-transform:scale(1.05);
    transform:scale(1.05);

    -webkit-transition:all 0.3s ease;
    -moz-transition:all 0.3s ease;
    -o-transition:all 0.3s ease;
    -ms-transition:all 0.3s ease;
    box-shadow: 0 9px 9px 0 rgba(0, 0, 0, 0.16), 0 9px 9px 0 rgba(0, 0, 0, 0.12) !important;
}
.zoomj:hover {

    -webkit-transform:scale(1.1);
    -moz-transform:scale(1.1);
    -ms-transform:scale(1.1);
    -o-transform:scale(1.1);
    transform:scale(1.1);

    -webkit-transition:all 0.3s ease;
    -moz-transition:all 0.3s ease;
    -o-transition:all 0.3s ease;
    -ms-transition:all 0.3s ease;


    border-color: #66FFCC !important;

    box-shadow: 0 8px 25px -8px #66ffcc !important;
    background-color: #66FFCC;

}

.zoomj:active {

-webkit-transform:scale(0.9);
-moz-transform:scale(0.9);
-ms-transform:scale(0.9);
-o-transform:scale(0.9);
transform:scale(0.9);

-webkit-transition:all 0.3s ease;
-moz-transition:all 0.3s ease;
-o-transition:all 0.3s ease;
-ms-transition:all 0.3s ease;


border-color: #66FFCC !important;
color: black!important;
box-shadow: 0 8px 25px -8px #66ffcc;
background-color: #66FFCC;
}

.zoom5:hover {

    -webkit-transform:scale(1.05);
    -moz-transform:scale(1.05);
    -ms-transform:scale(1.05);
    -o-transform:scale(1.05);
    transform:scale(1.05);

    -webkit-transition:all 0.3s ease;
    -moz-transition:all 0.3s ease;
    -o-transition:all 0.3s ease;
    -ms-transition:all 0.3s ease;

    border-color: #66FFCC !important;
    color: black!important;
    box-shadow: 0 8px 25px -8px #66ffcc;
    background-color: #66FFCC;
}
.zoom5:active {

-webkit-transform:scale(1);
-moz-transform:scale(1);
-ms-transform:scale(1);
-o-transform:scale(1);
transform:scale(1);

-webkit-transition:all 0.3s ease;
-moz-transition:all 0.3s ease;
-o-transition:all 0.3s ease;
-ms-transition:all 0.3s ease;

border-color: #66FFCC !important;
color: rgb(255, 255, 255)!important;
box-shadow: 0 8px 25px -8px #66ffcc;
background-color: #66FFCC;
}
#i:active{
    color: rgb(255, 255, 255)!important;
}

.pri{


}

.card {
        margin: 0 auto; /* Added */
        float: none; /* Added */
        margin-bottom: 10px; /* Added */

}

.minimo{

}

.bdr
{
    border-radius: 6px;overflow:hidden;

}
.bar {
    position: relative;
    top: -30px;
	height: 20%;
    width: 93%;
    left: 3.5%;
}



.caja{
    background: #F5F5F5;
border: 1px solid #DADADA;
box-sizing: border-box;
border-radius: 5px;
}
.btn-custom{

    width: 150px;
    height: 40px;
    background: #67FFCC;
    border-radius: 7px;
}

.circulo{

width: 15px;
height: 15px;
left: 206px;
top: 810px;

background: #FFFFFF;
border: 2px solid #000000;
box-sizing: border-box;
}

.s{
    color: #303030;
    text-decoration: none;
    background-image: linear-gradient(currentColor, currentColor);
    background-position: 0% 100%;
    background-repeat: no-repeat;
    background-size: 0% 2px;
    transition: background-size .3s;
    font-family: 'Montserrat', sans-serif;
    font-style: normal;
    font-size: 14px;

}

.s:hover, s:focus {
    color: #67FFCC;
    background-size: 100% 2px;

}

.container {
        display: flex;
      }

.text-iz{

    position: relative;
    top: 1px;
	height:200px;
    left: -145px;
    background: #F2F1F3;
    background-size: 25px 50px;
    background-size: 50% 50%;


}

.texto{
    font-size: 20px;
    position: relative;
    top: 12px;
}
.texto2{
    font-size: 18px;
    top: 10px;
    position: relative;
}



.fuente{
    font-family: 'Montserrat' ;
    font-style: normal ;

}
.tarjeta{
    position: relative;
    top: 20px;
}
.tarjeta2{
    position: relative;
    top: -90px;

}

.circulo{

position: relative;
width: 15px;
height: 15px;
left: 108px;
top: 110px;

background: #FFFFFF;
border: 2px solid #000000;
box-sizing: border-box;
}



.Rangoprecio{
    height:30px;
   width:30px;
   background: #67FFCC;
   -moz-border-radius:50px;
   -webkit-border-radius:50px;
   border-radius:50px;
   border: 0;
   outline: none;

}


.sinborde {
   border: 0;
   background-color: #eee;
   outline: none;
   height:30px;
   width:60px;
   border-radius:25px;
 }

 .sumador{
    position: relative;
    left: -10px;
 }

 .fondoProducto{
    background: #67FFCC;
    height:300px;
   width:300px;
   -moz-border-radius:50px;
   -webkit-border-radius:50px;
   border-radius:500px;
 }
 .o{
     position: relative;
     top: 35px;
 }

 .backgroundfondo{

    height:140px;
    width:80px;
    background:#66FFCC;
    border-radius: 10px;
 }

 .mover{
     position: relative;
    top: -100px;
    left: 15px;
 }
 .mover2{
    position: relative;
    top: 15px;
    left: 1px;
 }

 .mover3{
    position: absolute;
    top: 697px;
    left: 733px;
 }


 .rezize{
    height:170px;
    width: 300px;
 }

 .ancho{
    width: 1200px;
 }




 .slider {
  -webkit-appearance: none;
  width: 100%;
  height: 5px;
  border-radius: 5px;
  background:#67FFCC;
  outline: none;

  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 15px;
  height: 15px;
  border-radius: 50%;

  cursor: pointer;

  background: #FFFFFF;
border: 2px solid #000000;
box-sizing: border-box;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #04AA6D;
  cursor: pointer;
}

.prize{
    position: relative;
    top: 10px;
}

.link{
    position: relative;
    left: 83%;
}

.btn-cr {
    border-color: #F2F1F3 !important;
color: black!important;
box-shadow: 0 8px 25px -8px #f2f1f3;
position: absolute;
top: 130px;
left: 27%;
width: 25%;
height: 23px;
background-color: #F2F1F3;
border-radius: 0.4285rem;
transform: translate(-50%, -50%);
  }

  .btn-cu{

border-color: #F2F1F3 !important;
color: black!important;
box-shadow: 0 8px 25px -8px #f2f1f3;
position: absolute;
top: 130px;
left: 33%;
width: 55%;
height: 23px;
background-color: #F2F1F3;
border-radius: 0.4285rem;
transform: translate(-50%, -50%);
}
.prize2{
    position: relative;

}
.texto3{
    font-size: 20px;
    position: relative;
    top: -5px;
    left: 50%;
}

.bg{
    background: #67FFCC;
    border-radius: 6px;overflow:hidden;
    position: relative;
    top: -10px;

    width: 107%;
    left: -3.6%;

}




</style>
@endpush
