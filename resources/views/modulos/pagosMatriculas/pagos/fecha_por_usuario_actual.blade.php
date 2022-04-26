@extends('layouts.moduloPagosYmatricula')

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
                                                <input id="buscar" type="date" class="form-control" aria-label="Seleccione fecha" aria-describedby="basic-addon2" v-model="fecha" v-on:change="obtenerPagos">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div  class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>Lista de Pagos</h3>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="btn-group"  role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-light" v-on:click="descargarPagos" style="color: rgb(124, 11, 11)"><i class="far fa-file-pdf"></i> Descargar PDF</button>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-sm table-bordered">
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Alumno</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Número</th>
                                            <th scope="col">Concepto</th>
                                            <th scope="col">Observación</th>
                                            <th scope="col">Efectivo / Depósito</th>
                                            <th scope="col">Banco / Num. Operación</th>
                                            <th scope="col">Monto</th>
                                            <th scope="col">Opciones</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr v-for="(pago,i) in pagos">
                                            <th scope="row">@{{i+1}}</th>
                                            <td >@{{pago.nombres_alumno}}</td>
                                            <td >@{{pago.fecha}}</td>
                                            <td >@{{pago.numero}}</td>
                                            <td >@{{pago.nombre_concepto}}</td>
                                            <td >@{{pago.observacion}}</td>
                                            <td >@{{pago.tipoPago}}</td>
                                            <td >@{{pago.banco? (pago.banco+ ' / ' +pago.numero_operacion):''}}</td>
                                            <td >S/ @{{pago.monto}}</td>
                                            <td >
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn btn-light btn-sm" v-on:click="verBoleta(pago)"><i class="far fa-eye" ></i> Boleta | Factura</button>
                                                </div>
                                            </td>
                                          </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr style="background: #ececec">
                                                <td colspan="8">
                                                    Total
                                                </td>
                                                <td>
                                                    S/ @{{total}}
                                                </td>
                                                <td>
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
    <script src="{{asset('js/pagos/fecha_por_usuario_actual.js')}}"></script>
@endsection
