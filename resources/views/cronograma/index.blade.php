@extends('layouts.app')
@section('styles')
    <style>
        input[type='text']{
            background: white;
            padding-left: 5px;
            border: 1px;
        }
    </style>

@endsection
@section('content')
<div id="cronograma" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cronograma de Pagos de <b>@{{alumno}}</b>  </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>CRONOGRAMA DE PAGOS</h3>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Mes</th>
                                    <th scope="col">Fec. Vencimiento</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Opciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(cronograma,i) in cronogramas">
                                    <th scope="row">@{{i+1}}</th>
                                    <td >@{{cronograma.concepto}}</td>
                                    <td >@{{cronograma.mes}}</td>
                                    <td :style="cronograma.vencido?'color:red':'color:green'">@{{cronograma.fecha_vencimiento}}</td>
                                    <td >@{{cronograma.monto}}</td>
                                    <td :style="cronograma.estado=='CANCELADO'?'color:green':(cronograma.estado=='EXONERADO'?'color:skyblue':(cronograma.estado=='PENDIENTE'?'color:orange':'color:red'))">@{{cronograma.estado}}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-light" v-on:click="verCronograma(cronograma.cronograma_id, cronograma.mes)" ><i class="far fa-eye"></i> Ver Pagos</button>
                                            <button type="button" class="btn btn-secondary" v-on:click="pagarCronograma(cronograma)"><i class="fas fa-money-bill-alt"></i> Pagar</button>
                                        </div>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <!-- Modal de Pagos -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pagos de @{{mes_seleccionado}}</h5>
                    <button type="button" class="close" v-on:click="cerrarModalPagos">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left: 75px">
                    <div class="row">
                        <div class="'col-md-12">
                            <div class="row ">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Número</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Monto</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(pago,i) in pagos">
                                            <th scope="row">@{{i+1}}</th>
                                            <td >@{{pago.numero}}</td>
                                            <td >@{{pago.tipo}}</td>
                                            <td >@{{pago.monto}}</td>
                                            <td >@{{pago.fecha}}</td>
                                            <td >@{{pago.usuario}}</td>
                                            <td>
                                                <button type="button" class="btn btn-light" v-on:click="descargar(pago)"><i class="far fa-eye" ></i> Boleta | Factura</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="cerrarModalPagos">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Pagar-->
    <div class="modal fade" id="pagarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Relizar Pago de @{{pagar_crono.mes}} </h5>
                    <button type="button" class="close" v-on:click="cerrarModalPagar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left: 75px">
                    <div class="row">
                        <div class="'col-md-12">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form">

                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                          <input type="text"  class="form-control-plaintext" id="staticEmail" value="email@example.com">
                                        </div>
                                    </div>
                                </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="cerrarModalPagar">Close</button>
                </div>
            </div>
        </div>
    </div>
    <input type="text" name="" id="matricula_id" value="{{$matricula_id}}" hidden>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/cronograma/index.js')}}"></script>
@endsection
