<div class="row mt-1">
    {{-- Seccion ayuda --}}

    <div class="col-6">

        <div class="card h-100 d-flex justify-content-center align-items-center">
            <h1><b> Ahorro Circular </b></h1>
            <div class="row">
                <div class="card-content col-6">
                    <div class="card-body">
                        <div class="card-body text-center">
                        <img src="{{asset('assets/img/sistema/24-7-support.png')}}" alt="card-img-left">
                            <h4 class="card-title mt-2">
                                <strong>
                                    Reinversion de Comissiones
                                </strong>
                                <h4>
                                    <a class="btn text-white padding-button-short btn-block bg-purple-alt2 mt-1 waves-effect waves-light" data-toggle="modal" data-target="#exampleModalCenter"><b>REINVERTIR</b></a href="javascript:;">
                        </div>
                    </div>
                </div>

                <div class="card-content col-6">
                    <div class="card-body">
                        <div class="card-body text-center">
                        <img src="{{asset('assets/img/sistema/24-7-support.png')}}" alt="card-img-left">
                            <h4 class="card-title mt-2">
                                <strong>
                                    Reinversion del Capital
                                </strong>
                                <h4>
                                    <a class="btn text-white padding-button-short btn-block bg-purple-alt2 mt-1 waves-effect waves-light" data-toggle="modal" data-target="#exampleModalCenter"><b>REINVERTIR</b></a href="javascript:;">

                        </div>
                    </div>
                </div>
            </div>
        </div>



          <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Planes
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>






    </div>

    <div class="col-6">
        <div class="card h-100 d-flex justify-content-center align-items-center">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-body text-center">
                        <img src="{{asset('assets/img/sistema/24-7-support.png')}}" alt="card-img-left">
                        <h4 class="card-title mt-2">
                            <strong>
                                ¿Necesitas Ayuda?
                            </strong>
                            <h4>
                                <p class="card-text">
                                    Contacta con nosotros, estaremos <br>
                                    encantado de ayudarte
                                </p>
                                <a href=""
                                    class="btn text-white padding-button-short btn-block bg-purple-alt2 mt-1 waves-effect waves-light">CONTACTANOS</a
                                    href="javascript:;">
                    </div>
                </div>
            </div>
        </div>
    </div>



     
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                <h1>Inversiones</h1>
                    <div class="table-responsive">
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">
                                <tr class="text-center text-white bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Inicio</th>
                                    <th>Vence</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="text-center">

                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Seccion Grafico --}}
    <div class="col-12">
        <div class="row">
            <div class="col-sm-6 col-12 mt-1">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-usd text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-bold-700 mt-1">$ {{number_format($data['wallet'], '2', ',', '.')}}
                            </h2>
                            <p class="mb-0">Tu dinero</p>
                        </div>
                    </div>
                    <div class="card-content">
                        <div id="line-area-chart-1"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-12 mt-1">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0">
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-money text-success font-medium-5"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-bold-700 mt-1">$ {{number_format($data['comisiones'], '2', ',', '.')}}</h2>
                            <p class="mb-0">Comisiones totales</p>
                        </div>
                    </div>
                    <div class="card-content">
                        <div id="line-area-chart-2"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-12 mt-1">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-cart text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-bold-700 mt-1">{{$data['ordenes']}}</h2>
                            <p class="mb-0">Todas las ordenes</p>
                        </div>
                    </div>
                    <div class="card-content">
                        <div id="line-area-chart-4"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-12 mt-1">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0">
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-ticket text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-bold-700 mt-1">{{$data['tickets']}}</h2>
                            <p class="mb-0">Total de tickets</p>
                        </div>
                    </div>
                    <div class="card-content">
                        <div id="line-area-chart-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
