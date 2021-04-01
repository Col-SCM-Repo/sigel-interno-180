@extends('layouts.app')

@section('content')
<div id="pagos" class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
                                                <input id="buscar" type="date" class="form-control" aria-label="Ingrese nombres" aria-describedby="basic-addon2" v-model="fecha" v-on:change="obtenerPagos">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div  class="col-md-12">
                                    <h3>Lista de Pagos</h3>
                                    <table class="table table-striped">
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Número</th>
                                            <th scope="col">Observación</th>
                                            <th scope="col">Monto</th>
                                            {{-- <th scope="col">Opciones</th> --}}
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr v-for="(pago,i) in pagos">
                                            <th scope="row">@{{i+1}}</th>
                                            <td >@{{pago.fecha}}</td>
                                            <td >@{{pago.numero}}</td>
                                            <td >@{{pago.observacion}}</td>
                                            <td >S/ @{{pago.monto}}</td>
                                            {{-- <td >
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn btn-light" v-on:click="descargarPago(pago)"><i class="far fa-eye" ></i> Boleta | Factura</button>
                                                </div>
                                            </td> --}}
                                          </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr style="background: #ececec">
                                                <td colspan="4">
                                                    Total
                                                </td>
                                                <td>
                                                    S/ @{{total}}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
