@extends('layouts.moduloNotasAcademicas')

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
                                        <td ><a href="#" v-on:click="verNotas(matricula.id)"> @{{matricula.vacante.anio.nombre}}</a></td>
                                        <td >@{{matricula.id}}</td>
                                        <td >@{{matricula.vacante.nivel.nivel}}</td>
                                        <td >@{{matricula.vacante.grado.grado}} °</td>
                                        <td >@{{matricula.vacante.seccion.seccion}}</td>
                                        <td >@{{matricula.estado}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary btn-sm" >
                                                    <i class="fas fa-file-download"></i> Trim. 1
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm" >
                                                    <i class="fas fa-file-download"></i> Trim. 2
                                                </button>
                                                <button type="button" class="btn btn-light btn-sm" >
                                                    <i class="fas fa-file-download"></i> Trim. 3
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm" >
                                                    <i class="fas fa-file-download"></i> Lib.
                                                </button>

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

</div>
@endsection

@section('scripts')
    <script src="{{asset('js/modulos/notasAcademicas/alumnos/index.js')}}"></script>
@endsection
