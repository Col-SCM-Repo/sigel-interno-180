@extends('layouts.app')

@section('content')
<div id="alumnos" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">REGISTRAR PAGOS</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input id="buscar" type="text" class="form-control" placeholder="Ingrese NOMBRES, APELLIDOS o DNI" aria-label="Ingrese nombres" aria-describedby="basic-addon2" v-model="cadena">
                                <button class="input-group-text" id="basic-addon2" v-on:click="obtenerAlumnos"><i class="fas fa-search"></i></button >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h3>Lista de Alumnos</h3>
                            <table class="table table-striped">
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
                                            <button type="button" class="btn btn-dark" v-on:click="abrirModalMatriculas(alumno)"><i class="far fa-eye"></i> Ver Matriculas</button>
                                            <button type="button" class="btn btn-secondary" v-on:click="editarAlumno(alumno.id)"><i class="far fa-edit"></i> Editar</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Matriculas de @{{alumno_seleccionado.nombres}}</h5>
                    <button type="button" class="close" v-on:click="cerrarModalMatricula">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <div class="row justify-content-md-center">
                        <div class="'col-md-12">
                            <div class="row ">
                                <div class="col-md-12">
                                    <table class="table table-striped">
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
                                                <td >@{{matricula.anio}}</td>
                                                <td >@{{matricula.matricula_id}}</td>
                                                <td >@{{matricula.nivel}}</td>
                                                <td >@{{matricula.grado}}</td>
                                                <td >@{{matricula.seccion}}</td>
                                                <td >@{{matricula.estado}}</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-dark" v-on:click="verCronograma(matricula.matricula_id)"><i class="far fa-eye" ></i> Ver Cronograma</button>
                                                        <button type="button" class="btn btn-secondary" v-on:click="abrirModalOtrosPagos(matricula)"><i class="fas fa-money-check-alt"></i> Otros Pagos</button>
                                                        <button type="button" class="btn btn-light" v-on:click="editarMatricula(matricula.matricula_id)"><i class="far fa-edit"></i> Editar</button>
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
                    <button type="button" class="btn btn-secondary" v-on:click="cerrarModalMatricula">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
     <!-- Modal de Otros Pagos -->
     <div class="modal fade" id="otrosPagosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pagos</h5>
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
                                        <input disabled type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value = "2021">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Concepto</span>
                                        </div>
                                       <select id="conceptos" class="form-control" name="" v-on:change="asignarMonto" v-model="concepto_pago_id">
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
                                          <span class="input-group-text" >Monto</span>
                                        </div>
                                        <input disabled type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" :value="'S/ '+ monto_pago">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Observacion</span>
                                        </div>
                                        <input  type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="observacion_pago" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" v-on:click="guardarPago">Guardar</button>
                    <button type="button" class="btn btn-secondary" v-on:click="cerrarModalOtrosPagos">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/alumnos/index.js')}}"></script>
@endsection
