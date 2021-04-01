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
                                    <td >@{{alumno.nombres}}</td>
                                    <td >@{{alumno.dni}}</td>
                                    <td>
                                        <button type="button" class="btn btn-light" v-on:click="abrirModalMatriculas(alumno)"><i class="far fa-eye"></i> Ver Matriculas</button>
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
                <div class="modal-body" style="margin-left: 75px">
                    <div class="row">
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
                                                    <button type="button" class="btn btn-light" v-on:click="verCronograma(matricula.matricula_id)"><i class="far fa-eye" ></i> Ver Cronograma</button>
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
                    <button type="button" class="btn btn-secondary" v-on:click="cerrarModalMatricula">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/alumnos/index.js')}}"></script>
@endsection
