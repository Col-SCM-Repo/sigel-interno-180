@extends('layouts.app')

@section('content')
<div id="pagos" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pagos del dia @{{fecha}}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 " style="margin-bottom: 10px">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Seleccione Fecha:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <input id="buscar" type="date" class="form-control" placeholder="Ingrese NOMBRES, APELLIDOS o DNI" aria-label="Ingrese nombres" aria-describedby="basic-addon2" v-model="fecha" v-on:change="obtenerPagos">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/pagos/del_dia.js')}}"></script>
@endsection
