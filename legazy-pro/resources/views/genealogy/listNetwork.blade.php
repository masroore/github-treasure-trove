@extends('layouts.dashboard')

@section('title', 'Listado '.$title)

{{-- contenido --}}
@section('content')
<div class="col-12">
    <div class="card bg-lp">
        <div class="card-content"> 
            <div class="card-body card-dashboard">
                <div class="table-responsive">
                    @if ($allNetwork == 1)
                        @include('genealogy.component.tableDirect', ['data' => $users])
                    @else
                        @include('genealogy.component.tableNetwork', ['data' => $users])
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')