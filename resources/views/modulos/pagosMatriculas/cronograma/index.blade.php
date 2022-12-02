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
                                <div class="col-md-6 text-right">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button  type="button" class="btn btn-primary btn-sm" v-on:click='abrirModalOtrosDocumentosModal("{{ route('documentos.listar', ['modulo_id'=>1]) }}"   )'> <i class="fa fa-file" aria-hidden="true"></i> Documentos</button>
                                        <button  type="button" class="btn btn-warning btn-sm" v-on:click="abrirModalDescuentos"> <i class="fa fa-money" aria-hidden="true"></i> Becas/descuentos</button>
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
                                    <th scope="col">Monto final</th>
                                    <th scope="col">Descuento</th>
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
                                        <input v-if="editar && i!=0 && (cronograma.estado!='CANCELADO'||cronograma.estado=='EXONERADO')"  type="text" v-model="cronograma.monto_cobrar" class="form-control" v-on:change="modificarMonto(cronograma)">
                                        <p v-else>S/ @{{cronograma.monto_cobrar}}</p>
                                    </td>
                                    <td >S/ @{{cronograma.monto_descuento ? cronograma.monto_descuento : '0.0' }}</td>
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
                                                    <a :href='"{{ route('matricula.generar.xml-especifico', ['pago_id'=>'']) }}/" + pago.id' target="_blank" class="btn btn-light btn-sm"> <i class="fa fa-file" aria-hidden="true"></i> XML </a>
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
                                    {{-- <div  v-if="pago_model.tipo_comprobante_id==4" class="form-group row">
                                        <label for="serie" class="col-sm-4 col-form-label">Número</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" v-model="pago_model.numero" >
                                        </div>
                                    </div> --}}

                                    <template v-if="pago_model.tipo_comprobante_id==4">
                                        <div   class="form-group row">
                                            <label for="serie" class="col-sm-4 col-form-label">Numero RUC</label>
                                            <div class="col-sm-8">
                                                <input type="text"  class="form-control" v-model="pago_model.ruc" >
                                            </div>
                                        </div>
                                        <div  v-if="pago_model.tipo_comprobante_id==4" class="form-group row">
                                            <label for="serie" class="col-sm-4 col-form-label">Razón social</label>
                                            <div class="col-sm-8">
                                                <input type="text"  class="form-control" v-model="pago_model.razon_social" >
                                            </div>
                                        </div>
                                    </template>

                                    <div class="form-group row">
                                        <label for="monto" class="col-sm-4 col-form-label">Monto</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="monto" :value="'S/ ' + cronograma_seleccionado.monto_cobrar" disabled>
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

                                    <div class="form-group row">
                                        <label for="responsable_vacante" class="col-sm-4 col-form-label">Responsable:</label>
                                        <div class="col-sm-8">
                                            <select id="responsable_vacante"  class="form-control mayus" v-model="pago_model.responsable_pago_id">
                                                <option value="">SELECCIONE UN RESPONSABLE </option>
                                                <option v-for="responsable in pago_model.responsables_pago"  :value="responsable.id">@{{ responsable.apellidos + ', '+responsable.nombres }}</option>
                                            </select>
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
                                    {{-- <div class="form-group row">
                                        <label for="correlativo" class="col-sm-4 col-form-label">Nro. Comprobante</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="correlativo" v-model="pago_model.numero" >
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <label for="monto" class="col-sm-4 col-form-label">Monto</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" id="monto" :value="'S/ ' + pago_model.monto" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nota_observacion" class="col-sm-4 col-form-label">Observación</label>
                                        <div class="col-sm-8">
                                            <textarea  type="text"  class="form-control mayus" id="nota_observacion" v-model="pago_model.observacion"rows="4" ></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="responsable_vacante_nc" class="col-sm-4 col-form-label">Responsable:</label>
                                        <div class="col-sm-8">
                                            <select id="responsable_vacante_nc"  class="form-control mayus" v-model="pago_model.responsable_pago_id">
                                                <option value="">SELECCIONE UN RESPONSABLE </option>
                                                <option v-for="responsable in pago_model.responsables_pago"  :value="responsable.id">@{{ responsable.apellidos + ', '+responsable.nombres }}</option>
                                            </select>
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

    <!-- Modal para Becas y Descuentos-->
    <div class="modal fade" id="becasDescuentosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Descuentos </h5>
                    <button type="button" class="close" v-on:click="cerrarModalDescuentos">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="padding: 0 20px; background: #fafafa">
                    <div class="row">
                        <form class="col-12" id="formulario-aplicar-descuento" action="{{ route('matricula.aplicar.descuento') }}">
                            <div class="form-group">
                                <div class="row">
                                    <label for="tipo-descuento-beca"class="col-sm-3 form-label pr-0">
                                        Tipo Descuento:
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="tipoDescuentoBeca" id="tipo-descuento-beca" class="form-control " v-model="descuentoSeleccionado_id">
                                            <option value="">SELECCIONE UN DESCUENTO</option>
                                            <option value="-6">NINGUN DESCUENTO</option>
                                            <option  v-for=" descuento in listaDescuentosDisponibles" :title="descuento.DESCRIPCION" :value="descuento.MP_DESCUENTO_ID">@{{ descuento.MP_NOMBRE}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <button class="btn btn-xs p-0 bg-transparent text-success" type="button" v-on:click="abrirModalNuevosDescuentos" > <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <table class="table table-striped table-hover" style="width: 100%">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th class="text-center " >COD.</th>
                                                <th class="text-center " >CONCEPTO</th>
                                                <th class="text-center "  >
                                                    <input type="checkbox" title="Aplicar a todos los cronogramas" name="aplicarTodo" id="aplicar-todo-cronograma" v-on:change="aplicarTodo($event)">
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <template v-if=" listaCronogramasDescuentos && listaCronogramasDescuentos.length >0 ">
                                                    <tr v-for="(cronograma, index) in listaCronogramasDescuentos" :key="index+'cronogramas'" >
                                                        <td class="p-0 text-center"  scope="row"> <label :for="'cronograma-'+cronograma.id"> @{{ cronograma.id }} </label> </td>
                                                        <td class="p-0 text-center" > <label :for="'cronograma-'+cronograma.id"> @{{ cronograma.nombre }} </label> </td>
                                                        <td class="p-0 text-center"  class="text-center">
                                                            <input type="checkbox" :name="'cronograma-'+cronograma.id" :id="'cronograma-'+cronograma.id" v-model="cronograma.check"  v-on:change="onUpdateCronograma($event)">
                                                        </td>
                                                    </tr>
                                                </template>
                                                <template v-else>
                                                    <tr>
                                                        <td colspan="3"> <small> No se encontró cronogramas </small> </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                    </table>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarModalDescuentos">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="aplicarDescuentosBecar" >Aplicar descuento</button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal para otros documentos-->
<div class="modal fade" id="otrosDocumentosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> OTROS DOCUMENTOS </h5>
                <button type="button" class="close" v-on:click="cerrarModalOtrosDocumentosModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="padding: 0 20px; background: #fafafa">

                <table class="table table-hover " style="width: 100%">
                    <thead class="thead-inverse">
                        <tr>
                            <th class="text-center">NRO</th>
                            <th>NOMBRE DE DOCUMENTO</th>
                            <th class="text-center">ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr v-for=" documento in listaDocumentos">
                                <td class="pt-0 pb-0 text-center"  scope="row"> @{{ documento.id }} </td>
                                <td class="pt-0 pb-0" > @{{ documento.nombre_archivo }} </td>
                                <td class="pt-0 pb-0 text-center" >
                                    <template v-if="documento.tipo_documento == 'ESTATICO'">
                                        <a type="button" class="btn btn-sm pt-0 pb-0 bg-transparent text-primary" target="_blank" :href=' "{{ asset('/') }}"+ documento.directorio +"/"+ documento.nombre_archivo ' >
                                            <i class="fa fa-file" aria-hidden="true"></i> Descargar
                                        </a>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-sm pt-0 pb-0 bg-transparent text-primary" v-on:click='generarDocumento( "{{ route('documentos.matricula.generar-word') }}", documento.id ) ' {{--  v-on:click="generarFichaMatricula" --}}>
                                            <i class="fa fa-file" aria-hidden="true"></i> Descargar
                                        </button>
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarModalOtrosDocumentosModal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal para creacion de becas/descuentos-->
    <div class="modal fade" id="nuevaBecaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> DESCUENTOS REGISTRADOS </h5>
                    <button type="button" class="close" v-on:click="cerrarModalNuevosDescuentos">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="background: #fafafa">
                    <div class="row">

                        <div class="col-sm-7">
                            <table class="table table-striped table-inverse " style="width: 100%">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>COD.</th>
                                        <th>NOMBRE</th>
                                        <th>TIPO</th>
                                        <th>VALOR</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <template v-if=" listaDescuentosDisponibles && listaDescuentosDisponibles.length>0 ">
                                            <tr v-for=" descuento in listaDescuentosDisponibles" :title="descuento.DESCRIPCION">
                                                <td class="text-uppercase pt-0 pb-0"  scope="row"> @{{ descuento.MP_DESCUENTO_ID }} </td>
                                                <td class="text-uppercase pt-0 pb-0" > @{{ descuento.MP_NOMBRE }} </td>
                                                <td class="text-uppercase pt-0 pb-0" > @{{ descuento.MP_TIPO_BECA }} </td>
                                                <td class="text-uppercase pt-0 pb-0" > @{{ descuento.VALOR }} </td>
                                                <td class="pt-0 pb-0">
                                                    <button type="button" class="btn btn-xs bg-transparent p-0 text-primary" title="Editar" v-on:click="onEditarDescuento(descuento.MP_DESCUENTO_ID, $event)">
                                                        <i class="fas fa-edit    "></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                        <template v-else>
                                            <tr>
                                                <td colspan="4" class="text-center"> <small>No se encontrò descuentos</small> </td>
                                            </tr>
                                        </template>
                                    </tbody>
                            </table>
                        </div>
                        <div class="col-sm-5" style="border-left: 1px solid #a09a9a54; ">
                            <h5> @{{ descuentoEditar_id == ''? 'Nuevo':'Actualizar' }} descuento</h5>

                            <form action="{{ route('descuentos.registrar') }}" id="form-nuevo-descuento"  v-on:submit="registrarDescuento($event)">
                                <div class="form-group">
                                  <label for="nombreDescuento">Nombre:</label>
                                  <input type="text"
                                    class="form-control text-uppercase" name="nombreDescuento" id="nombreDescuento" aria-describedby="helpId" placeholder="">
                                </div>

                                <div class="form-group">
                                  <label for="descripcionDescuento">Descripcion</label>
                                  <textarea class="form-control text-uppercase" name="descripcionDescuento" id="descripcionDescuento" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="tipoDescuento">Tipo:</label>
                                    <select name="tipoDescuento" id="tipoDescuento" class="form-control">
                                        <option value="">SELECCIONE UN TIPO</option>
                                        <option value="porcentaje">PORCENTUAL</option>
                                        <option value="monto">MONTO FIJO</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="valorDescuento">Valor:</label>
                                    <input type="text" class="form-control" name="valorDescuento" id="valorDescuento" >
                                    <input type="hidden" name="descuentoEditarId" id="descuentoEditar_id" value="">
                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-xs btn-success " type="submit">
                                        @{{ descuentoEditar_id == '' ? 'Guardar' : 'Actualizar' }}
                                    </button>
                                </div>
                            </form>
                        </div>



                    </div>
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
