@extends('layouts.app')
@section('styles')

@endsection
@section('content')
<div id="cronograma" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Año:</b> @{{matricula.anio}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Cod. Matricula:</b> @{{matricula.id}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Nivel:</b> @{{matricula.nivel}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Seccion:</b> @{{matricula.grado+'° '+matricula.seccion}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p><b>Alumno:</b>@{{alumno}}</p>
                    </div>
                </div>
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
                                    <td >S/ @{{cronograma.monto}}</td>
                                    <td :style="cronograma.estado=='CANCELADO'?'color:green':(cronograma.estado=='EXONERADO'?'color:skyblue':(cronograma.estado=='PENDIENTE'?'color:orange':'color:blue'))">@{{cronograma.estado}}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button v-if="cronograma.estado!='PENDIENTE'" type="button" class="btn btn-light" v-on:click="verCronograma(cronograma.cronograma_id, cronograma.mes)" ><i class="far fa-eye"></i> Ver Pagos</button>
                                            <button v-if="cronograma.estado!='CANCELADO'" type="button" class="btn btn-secondary" v-on:click="pagarCronograma(cronograma)"><i class="fas fa-money-bill-alt"></i> Pagar</button>
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
                <div class="modal-body" style="margin-left: 25px">
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
                                            <td >S/ @{{pago.monto}}</td>
                                            <td >@{{pago.fecha}}</td>
                                            <td >@{{pago.usuario}}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn btn-light" v-on:click="descargar(pago)"><i class="far fa-eye" ></i> Boleta | Factura</button>
                                                    <button v-if="pago.tipo!='NOTA DE CREDITO'" type="button" class="btn btn-secondary" v-on:click="abrirModalNota(pago)"><i class="fas fa-money-bill-alt"></i> N. C.</button>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="cerrarModalPagos">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Pagar-->
    <div class="modal fade" id="pagarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Relizar Pago de @{{pagar_crono.mes}} </h5>
                    <button type="button" class="close" v-on:click="cerrarModalPagar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-left: 75px; background: #fafafa">
                    <div class="row">
                        <div class="'col-md-12">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="concepto" class="col-sm-4 col-form-label">Concepto</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="concepto" :value="pagar_crono.mes" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="comprobante"class="col-sm-4 col-form-label">Tip. Comprobante</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="comprobante" value="BOLETA ELECTRÓNICA" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="serie" class="col-sm-4 col-form-label">Serie</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="serie" value="{{Auth::user()->SerieComprobante()->get()->last()->serie()}}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="monto" class="col-sm-4 col-form-label">Monto</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="monto" :value="'S/ ' + pagar_crono.monto" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fecha" class="col-sm-4 col-form-label">Fecha</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="fecha" :value="fecha_pago" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="saldo" class="col-sm-4 col-form-label">Saldo</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="saldo" :value="'S/ '+ saldo" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pago" class="col-sm-4 col-form-label">Pago</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="pago" v-model="monto_pago" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pago" class="col-sm-4 col-form-label">Observación</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="pago" v-model="observacion_pago" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="cerrarModalPagar">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="guardarPago" :disabled="saldo==0 ||monto_pago>saldo">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Nota de Credito-->
    <div class="modal fade" id="notaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nota de Credito de B.E. - @{{pago_seleccionado.numero}} </h5>
                    <button type="button" class="close" v-on:click="cerrarModalPagar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-left: 75px; background: #fafafa">
                    <div class="row">
                        <div class="'col-md-12">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="comprobante"class="col-sm-4 col-form-label">Tip. Comprobante</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="comprobante" value="NOTA DE CREDITO" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="serie" class="col-sm-4 col-form-label">Serie</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="serie" value="{{Auth::user()->SerieComprobante()->get()->last()->serie()}}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="correlativo" class="col-sm-4 col-form-label">Nro. Comprobante</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="correlativo" v-model="pago_seleccionado.correlativo" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="monto" class="col-sm-4 col-form-label">Monto</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="monto" :value="'S/ -' + pago_seleccionado.monto" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nota_observacion" class="col-sm-4 col-form-label">Observación</label>
                                        <div class="col-sm-8">
                                            <p>ANULA TICKET Nº @{{pago_seleccionado.numero}}, POR ...</p>
                                            <textarea  type="text"  class="form-control" id="nota_observacion" v-model="pago_seleccionado.observacion"rows="4" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="cerrarModalNota">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="guardaNotaCredito" >Guardar</button>
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
