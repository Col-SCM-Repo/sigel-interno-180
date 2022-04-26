@extends('layouts.moduloPagosYmatricula')
@section('styles')

@endsection
@section('content')
<div id="cronograma" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- card Cronogramam --}}
            <div class="card">
                <div class="card-header">
                    <div v-if="matricula.vacante" class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Año: </b> @{{matricula.vacante.anio.nombre}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Cod. Matricula: </b> @{{matricula.id}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Nivel: </b> @{{matricula.vacante.nivel.nivel}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Seccion: </b> @{{matricula.vacante.grado.grado+'° '+matricula.vacante.seccion.seccion}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Alumno: </b> @{{alumno.apellidos+', '+alumno.nombres}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p :class="matricula.estado=='RETIRADO'?'text-danger':'text-primary'"><b>Estado Matricula: </b> @{{matricula.estado}} <span v-if="matricula.estado=='RETIRADO'">(@{{matricula.fecha_fin}})</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>CRONOGRAMA DE PAGOS</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary btn-sm" v-on:click="generarFichaMatricula"><i class="fas fa-file-export" ></i> F. de Matícula</button>
                                        <button  type="button" class="btn btn-success btn-sm" v-on:click="generarCronograma"><i class="far fa-calendar-alt"></i> Cro. Pagos</button>
                                        <button  type="button" class="btn btn-light btn-sm" v-on:click="editarCronograma">
                                            <template v-if="!editar">
                                                <i class="far fa-edit"></i> Editar
                                            </template>
                                            <template v-else>
                                                <i class="fas fa-ban"></i> Cancelar
                                            </template>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-sm table-bordered">
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
                                    <td >@{{cronograma.tipo_deuda}}</td>
                                    <td >@{{cronograma.concepto.concepto}}</td>
                                    <td :style="cronograma.vencido?'color:red':'color:green'">@{{cronograma.fecha_vencimiento}}</td>
                                    <td >
                                        <input v-if="editar && i!=0 && (cronograma.estado!='CANCELADO'||cronograma.estado=='EXONERADO')"  type="text" v-model="cronograma.monto" class="form-control" v-on:change="modificarMonto(cronograma)">
                                        <p v-else>S/ @{{cronograma.monto}}</p>
                                    </td>
                                    <td :style="cronograma.estado=='CANCELADO'?'color:green':(cronograma.estado=='EXONERADO'?'color:skyblue':(cronograma.estado=='PENDIENTE'?'color:orange':'color:blue'))">@{{cronograma.estado}}</td>
                                    <td>
                                        <div v-if="i==0" class="btn-group" role="group" aria-label="Basic example">
                                            <button v-if="cronograma.estado!='PENDIENTE'||cronograma.estado=='EXONERADO'" type="button" class="btn btn-light btn-sm" v-on:click="verPagosPorCronograma(cronograma.id, cronograma.concepto.concepto)" ><i class="far fa-eye"></i> Ver Pagos</button>
                                            <button v-if="cronograma.estado!='CANCELADO'||cronograma.estado=='EXONERADO'" type="button" class="btn btn-success btn-sm" v-on:click="pagarCronograma(cronograma)"><i class="fas fa-money-bill-alt"></i> Pagar</button>
                                        </div>
                                        <div v-if="i>0 && ((cronogramas[i-1].estado=='CANCELADO' || cronogramas[i-1].estado=='EXONERADO') &&cronogramas[i].estado!='EXONERADO')" class="btn-group" role="group" aria-label="Basic example">
                                            <button v-if="cronograma.estado!='PENDIENTE'||cronograma.estado=='EXONERADO'" type="button" class="btn btn-light btn-sm" v-on:click="verPagosPorCronograma(cronograma.id, cronograma.concepto.concepto)" ><i class="far fa-eye"></i> Ver Pagos</button>
                                            <button v-if="cronograma.estado!='CANCELADO'||cronograma.estado=='EXONERADO'" type="button" class="btn btn-success btn-sm" v-on:click="pagarCronograma(cronograma)"><i class="fas fa-money-bill-alt"></i> Pagar</button>
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
        <div class="col-md-12">
            <br>
        </div>
        {{-- Card otros pagos --}}
        <div v-if="otros_pagos.length>0" class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Pagos por Otros Conceptos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Lista de Pagos</h3>
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Número</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(pago,i) in otros_pagos">
                                    <th scope="row">@{{i+1}}</th>
                                    <td >@{{pago.concepto.concepto}}</td>
                                    <td >@{{pago.serie+' - '+pago.numero}}</td>
                                    <td >@{{pago.tipo_comprobante}}</td>
                                    <td >S/ @{{pago.monto}}</td>
                                    <td >@{{pago.fecha}}</td>
                                    <td >@{{pago.usuario_nombres}}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-light btn-sm" v-on:click="verBoletaFactura(pago.id)"><i class="far fa-eye" ></i> Boleta | Factura</button>
                                            <button v-if="parseFloat(pago.monto)>0" type="button" class="btn btn-success btn-sm" v-on:click="abrirModalNota(pago)"><i class="fas fa-money-bill-alt"></i> N. C.</button>
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
   <!-- Modal de Pagos por Cronograma -->
    <div class="modal fade" id="pagosPorCronogramaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="matricula.vacante" class="modal-title" id="exampleModalLabel">Pagos de @{{mes_seleccionado}} - @{{alumno.apellidos+', '+alumno.nombres}} - @{{matricula.vacante.grado.grado+'° '+matricula.vacante.seccion.seccion}} - @{{matricula.vacante.nivel.nivel}} </h5>
                    <button type="button" class="close" v-on:click="cerrarModalPagos">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left: 25px">
                    <div class="row">
                        <div class="'col-md-12">
                            <div class="row ">
                                <div class="col-md-12">
                                    <table class="table table-striped table-sm table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Número</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Monto</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Banco / Num. Operación</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(pago,i) in pagos">
                                            <th scope="row">@{{i+1}}</th>
                                            <td >@{{pago.serie +' - ' +pago.numero}}</td>
                                            <td >@{{pago.tipo_comprobante}}</td>
                                            <td >S/ @{{pago.monto}}</td>
                                            <td >@{{pago.fecha}}</td>
                                            <td >@{{pago.usuario_nombres}}</td>
                                            <td >@{{pago.tipoPago}}</td>
                                            <td >@{{pago.banco? (pago.banco+ ' / ' +pago.numero_operacion):''}}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn btn-light btn-sm" v-on:click="verBoletaFactura(pago.id)"><i class="far fa-eye" ></i> Boleta | Factura</button>
                                                    <button v-if="parseFloat(pago.monto)>0" type="button" class="btn btn-success btn-sm" v-on:click="abrirModalNota(pago)"><i class="fas fa-money-bill-alt"></i> N. C.</button>
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
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarModalPagos">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Pagar-->
    <div  class="modal fade" id="pagarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="pago_model"  class="modal-title" id="exampleModalLabel">Relizar Pago de @{{pago_model.concepto}}</h5>
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
                                        <div v-if="pago_model" class="col-sm-8">
                                            <input type="text"  class="form-control" id="concepto" :value="pago_model.concepto" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for=""class="col-sm-4 col-form-label">Tip. Comprobante</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="" id="" v-model="pago_model.tipo_comprobante_id">
                                                <option value="">SELECIONE TIPO</option>
                                                <option value="8">BOLETA ELECTRÓNICA</option>
                                                <option value="4">FACTURA ELECTRÓNICA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for=""class="col-sm-4 col-form-label">Modalidad de Pago</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="" id="" v-model="pago_model.modalidad">
                                                <option value="">SELECIONE MODALIDAD</option>
                                                <option value="1">EFECTIVO</option>
                                                <option value="2">DEPOSITO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <template v-if="pago_model.modalidad==2">
                                        <div class="form-group row">
                                            <label for=""class="col-sm-4 col-form-label">Banco</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="" id="" v-model="pago_model.banco">
                                                    <option value="">SELECIONE BANCO</option>
                                                    <option value="1">BCP</option>
                                                    <option value="2">BBVA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for=""class="col-sm-4 col-form-label">N° Operación</label>
                                            <div class="col-sm-8">
                                                <input type="text"  class="form-control" v-model="pago_model.numero_operacion" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for=""class="col-sm-4 col-form-label">Fecha de Deposito</label>
                                            <div class="col-sm-8">
                                                <input type="date"  class="form-control" v-model="pago_model.fecha_emision" >
                                            </div>
                                        </div>
                                    </template>
                                    <div class="form-group row">
                                        <label for="serie" class="col-sm-4 col-form-label">Serie</label>
                                        <div class="col-sm-8">
                                            <input v-if="pago_model.tipo_comprobante_id==8" type="text"  class="form-control" v-model="pago_model.serie=serie_usuario" disabled>
                                            <input v-else type="text" class="form-control" v-model="pago_model.serie='E001'"  >
                                        </div>
                                    </div>
                                    <div  v-if="pago_model.tipo_comprobante_id==4" class="form-group row">
                                        <label for="serie" class="col-sm-4 col-form-label">Número</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" v-model="pago_model.numero" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="monto" class="col-sm-4 col-form-label">Monto</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="monto" :value="'S/ ' + cronograma_seleccionado.monto" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fecha" class="col-sm-4 col-form-label">Fecha</label>
                                        <div class="col-sm-8">
                                            <input type="date"  class="form-control" id="fecha" v-model="pago_model.fecha" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="saldo" class="col-sm-4 col-form-label">Saldo</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="saldo" :value="'S/ '+ pago_model.saldo" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pago" class="col-sm-4 col-form-label">Pago</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="pago" v-model="pago_model.monto" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pago" class="col-sm-4 col-form-label">Observación</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control mayus" id="pago" v-model="pago_model.observacion" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarModalPagar">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="validarPago" :disabled="parseFloat(pago_model.monto)>parseFloat(pago_model.saldo)">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Nota de Credito-->
    <div class="modal fade" id="notaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nota de Credito de B.E. @{{pago_seleccionado.serie}} - @{{pago_seleccionado.numero}} </h5>
                    <button type="button" class="close" v-on:click="cerrarModalNota">
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
                                            <input type="text"  class="form-control" id="serie" v-model="pago_model.serie" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="correlativo" class="col-sm-4 col-form-label">Nro. Comprobante</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="correlativo" v-model="pago_model.numero" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="monto" class="col-sm-4 col-form-label">Monto</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="monto" :value="'S/ ' + pago_model.monto" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nota_observacion" class="col-sm-4 col-form-label">Observación</label>
                                        <div class="col-sm-8">
                                            <p>ANULA TICKET Nº @{{pago_seleccionado.serie}}-@{{pago_seleccionado.numero}}, POR ...</p>
                                            <textarea  type="text"  class="form-control mayus" id="nota_observacion" v-model="pago_model.observacion"rows="4" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarModalNota">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardaNotaCredito" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <input type="text" name="" id="matricula_id" value="{{$matricula_id}}" hidden>
    <input type="text" name="" id="serie_usuario" value="{{Auth::user()->SerieComprobante()->get()->last()->serie()}}" hidden>
</div>
@endsection
@section('scripts')
    <script src="{{asset('js/cronograma/index.js')}}"></script>
@endsection
