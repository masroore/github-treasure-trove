@extends('layouts.dashboard')

@section('content')
<div id="logs-list">
    <div class="col-12">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                      <h1 class="text-white">Lista de Ordenes</h1>
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">
                                <tr class="text-center text-white bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Producto</th>
                                    <th>Fecha de Creación</th>
                                    <th>Cantidad</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($ordenes as $orden)
                                <tr class="text-center text-white">
                                    <td>{{$orden->id}}</td>
                                    <td>{{$orden->name}}</td>
                                    {{-- <td>{{$orden->grupo}}</td> --}}
                                    <td>{{$orden->getPackageOrden->name}}
                                    <td>{{date('Y-m-d', strtotime($orden->created_at))}}</td>
                                    {{-- <td>{{$orden->idtransacion}}</td> --}}
                                    <td>{{$orden->cantidad}}</td>
                                    <td>{{$orden->monto}}</td>
                                    @if ($orden->status == '0')
                                    <td> <a class=" btn btn-info text-white text-bold-600" data-toggle="modal" data-target="#ModalStatus{{$orden->id}}">Esperando</a></td>
                                    @elseif($orden->status == '1')
                                    <td> <a class=" btn btn-success text-white text-bold-600">Aprobado</a></td>
                                    @elseif($orden->status == '2')
                                    <td> <a class=" btn btn-danger text-white text-bold-600">Cancelado</a></td>
                                    @endif
                                    <td>
                                        <a class="btn btn-outline-primary text-white text-bold-600" data-toggle="modal"
                                            data-target="#ModalDetail{{$orden->id}}"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="ModalDetail{{$orden->id}}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Cancelar compra</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('orden.detail') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="{{$orden->id}}" disabled>
                                                    Detalles de la Orden
                                                    <br>
                                                    <input type="hidden"  name="iduser" value="{{$orden->iduser}}" disabled>
                                                    <br>
                                                    <p>Usuario</p>
                                                    <input id="monto_bruto" name="monto_bruto" type="text"
                                                        class="inputransparente text-white form-control"
                                                        value="{{$orden->name}}" disabled>
                                                    <input type="hidden"  name="total" value="">
                                                    <br>
                                                    <p>Paquete</p>
                                                    <input id="monto_bruto" name="monto_bruto" type="text"
                                                        class="inputransparente text-white form-control"
                                                        value="{{$orden->monto}}" disabled>
                                                    <input type="hidden"  name="total" value="">
                                                    <br>
                                                    <p>Fecha de Creacion</p>
                                                    <input id="monto_bruto" name="monto_bruto" type="text"
                                                        class="inputransparente text-white form-control"
                                                        value="{{date('Y-m-d', strtotime($orden->created_at))}}" disabled>
                                                    <input type="hidden"  name="total" value="">
                                                    <br>
                                                    <p>Monto</p>
                                                    <input id="monto_bruto" name="monto_bruto" type="text"
                                                        class="inputransparente text-white form-control"
                                                        value="{{$orden->total}}" disabled>
                                                    <input type="hidden"  name="total" value="">
                                                    <br>
                                                    <p class="text-center">Estado</p>
                                                    @if ($orden->status == '0')
                                                    <a class=" btn btn-info text-white text-bold-600 d-flex justify-content-center" data-toggle="modal" data-target="#ModalStatus{{$orden->id}}">Esperando</a>
                                                    @elseif($orden->status == '1')
                                                    <a class=" btn btn-success text-white text-bold-600 d-flex justify-content-center">Aprobado</a>
                                                    @elseif($orden->status >= '2')
                                                    <a class=" btn btn-danger text-white text-bold-600 d-flex justify-content-center">Cancelado</a>
                                                    @endif
                                                    <br>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @if (Auth::user()->admin == 1)
                                <!-- Modal -->
                            <div class="modal fade" id="ModalStatus{{$orden->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cambiar estatus</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('cambiarStatus') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">

                                    <input type="hidden" name="id" value="{{$orden->id}}">
                                    ¿Desea cambiar es estatus de la orden?
                                    <br>
                                    <label>Seleccione el estado</label>
                                    <select name="status" required class="form-control">
                                        <option value="">Seleccione un estado</option>
                                        <option value="1">Aprobado</option>
                                        <option value="2">Rechazado</option>
                                    </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            @else

                            @endif

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')


