@extends('layouts.moduloPagosYmatricula')

@section('content')
<div id="alumnos" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">BUSCAR ALUMNO</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input id="buscar" type="text" class="form-control mayus" placeholder="Ingrese NOMBRES, APELLIDOS o DNI" aria-label="Ingrese nombres" aria-describedby="basic-addon2" v-model="buscar_string">
                                <button class="input-group-text btn-sm" id="basic-addon2" v-on:click="obtenerAlumnos"><i class="fas fa-search"></i></button >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <h3>Lista de Alumnos</h3>
                                </div>
                                <div class="col-auto">
                                    <a href="{{route('editar.alumno.alumnos', ['alumno_id' => 0])}}" type="button" class="btn btn-primary btn-sm" ><i class="fas fa-plus"></i> Nuevo Alumno</a>
                                </div>
                            </div>
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Alumno</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Opciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(alumno,i) in alumnos">
                                    <th scope="row">@{{i+1}}</th>
                                    <td >@{{alumno.apellidos+', '+ alumno.nombres}}</td>
                                    <td >@{{alumno.dni}}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-primary btn-sm" v-on:click="abrirModalMatriculas(alumno)"><i class="far fa-eye"></i> Matriculas</button>
                                            <button type="button" class="btn btn-success btn-sm" v-on:click="editarAlumno(alumno.id)"><i class="far fa-edit"></i> Editar</button>
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
    <!-- Modal de Matriculas -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row justify-content-between" style="width: 100%">
                        <div class="col-auto">
                            <h3 class="modal-title" id="exampleModalLabel">Matriculas de @{{alumno_seleccionado.nombres}}</h3>
                        </div>
                        <div class="col-auto">
                            <button v-if="puede_matricularse"  type="button" class="btn btn-primary  btn-sm" v-on:click="matricularAlumno(alumno_seleccionado.id)"><i class="fas fa-file-invoice"></i> Matricular</button>
                        </div>
                    </div>
                    <button type="button" class="close" v-on:click="cerrarModalMatricula" style="margin: -1rem -1rem -1rem 0rem!important;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <div class="row justify-content-md-center">
                        <div class="'col-md-12">
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Año</th>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Nivel</th>
                                    <th scope="col">Grado</th>
                                    <th scope="col">Sección</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="matricula in matriculas">
                                        <td >@{{matricula.vacante.anio.nombre}}</td>
                                        <td >@{{matricula.id}}</td>
                                        <td >@{{matricula.vacante.nivel.nivel}}</td>
                                        <td >@{{matricula.vacante.grado.grado}} °</td>
                                        <td >@{{matricula.vacante.seccion.seccion}}</td>
                                        <td >@{{matricula.estado}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary btn-sm" v-on:click="verCronograma(matricula.id)"><i class="far fa-eye" ></i> Cronograma</button>
                                                <button type="button" class="btn btn-success btn-sm" v-on:click="abrirModalOtrosPagos(matricula)"><i class="fas fa-money-check-alt"></i> Otros Pagos</button>
                                                <button type="button" class="btn btn-light btn-sm" v-on:click="editarMatricula(matricula.id)"><i class="far fa-edit"></i> Editar</button>
                                                <button type="button" class="btn btn-primary btn-sm" v-on:click="generarCarnetAlumno(matricula.id)"><i class="fas fa-address-card"></i> Carnet</button>
                                                <button v-if="matricula.puede_retirarse" type="button" class="btn btn-danger btn-sm" v-on:click="retirarAlumno(matricula)"><i class="fas fa-user-minus"></i> Retirar</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarModalMatricula">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
     <!-- Modal de Otros Pagos -->
     <div class="modal fade" id="otrosPagosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Otros Pagos</h5>
                    <button type="button" class="close" v-on:click="cerrarModalOtrosPagos">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-md-12">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Año</span>
                                        </div>
                                        <input disabled type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" :value="anio_actual.nombre">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Concepto</span>
                                        </div>
                                       <select id="conceptos" class="form-control" name="" v-on:change="asignarMonto" v-model="pago_model.concepto_pago_id">
                                           <option value="">SELECCIONE CONCEPTO</option>
                                           <option v-for="concepto in conceptos" :value="concepto.concepto_pago_id" :monto="concepto.monto">@{{concepto.concepto}}</option>
                                       </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Tip. Comprobante</span>
                                        </div>
                                        <select class="form-control" name="" id="" v-model="pago_model.tipo_comprobante_id">
                                            <option value="">SELECIONE TIPO</option>
                                            <option value="8">BOLETA ELECTRÓNICA</option>
                                            <option value="4">FACTURA ELECTRÓNICA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Mod. de Pago</span>
                                        </div>
                                        <select class="form-control" name="" id="" v-model="pago_model.modalidad">
                                            <option value="">SELECIONE MODALIDAD</option>
                                            <option value="1">EFECTIVO</option>
                                            <option value="2">DEPOSITO</option>
                                        </select>
                                    </div>
                                </div>

                                <template v-if="pago_model.modalidad==2">
                                    <div class="col-md-12">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" >Banco</span>
                                            </div>
                                            <select class="form-control" name="" id="" v-model="pago_model.banco">
                                                <option value="">SELECIONE BANCO</option>
                                                <option value="1">BCP</option>
                                                <option value="2">BBVA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" >N° Operación</span>
                                            </div>
                                            <input type="text"  class="form-control" v-model="pago_model.numero_operacion" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" >Fe. de Deposito</span>
                                            </div>
                                            <input type="date"  class="form-control" v-model="pago_model.fecha_emision" >
                                        </div>
                                    </div>
                                </template>
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Serie</span>
                                        </div>
                                        <input v-if="pago_model.tipo_comprobante_id==8" type="text"  class="form-control" v-model="pago_model.serie=serie_usuario" disabled>
                                        <input v-else type="text" class="form-control" v-model="pago_model.serie='E001' "  >
                                    </div>
                                </div>
                                <div v-if="pago_model.tipo_comprobante_id==4" class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Número</span>
                                        </div>
                                        <input type="text"  class="form-control" v-model="pago_model.numero" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Monto</span>
                                        </div>
                                        <input disabled type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" :value="'S/ '+ pago_model.monto">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Observacion</span>
                                        </div>
                                        <input  type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="pago_model.observacion" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarPago">Guardar</button>
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarModalOtrosPagos">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <input type="text" name="" id="serie_usuario" value="{{Auth::user()->SerieComprobante()->get()->last()->serie()}}" hidden>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/alumnos/index.js')}}"></script>
@endsection
