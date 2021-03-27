@extends('layouts.app')

@section('content')
<div id="cronograma" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                                    <td >@{{cronograma.monto}}</td>
                                    <td >@{{cronograma.estado}}</td>
                                    <td>
                                        <button type="button" class="btn btn-light" v-on:click="verCronograma(cronograma.cronograma_id, cronograma.mes)" ><i class="far fa-eye"></i> Ver Pagos</button>
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
   <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pagos de @{{mes_seleccionado}}</h5>
            <button type="button" class="close" v-on:click="cerrarModal">
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
                                            <button type="button" class="btn btn-light" v-on:click="descargar(pago)"><i class="far fa-eye" ></i> Comprobante</button>
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
                <button type="button" class="btn btn-secondary" v-on:click="cerrarModal">Close</button>
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
