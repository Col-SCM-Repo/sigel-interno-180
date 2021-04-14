@extends('layouts.app')

@section('content')
<div id="aulas" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">AULAS</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 " style="margin-bottom: 10px">
                            <div class="row">
                                <div class="col-md-4">
                                    <select id="anios" class="form-control" aria-label="Default select example" v-model="anio_id" v-on:change="obtenerAulas">
                                        <option value=''>Seleccione Año</option>
                                        <option v-for="anio in anios" :value="anio.id">@{{anio.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <select id="seccion" :disabled="anio_id==''" class="form-control" aria-label="Default select example" v-model="aula_id" v-on:change="obtenerAlumnos" >
                                        <option value=''>Seleccione Aula</option>
                                        <option v-for="aula in aulas" :value="aula.id">@{{aula.nombre_completo}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div v-if="aula_id!=''" class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Lista de Alumnos</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group"  role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-light" v-on:click="descargarLista" style="color: green"><i class="fas fa-file-csv " ></i> Exportar EXCEL</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">Cod. Matrícula</th>
                                    <th scope="col">Alumno</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Apoderado</th>
                                    <th scope="col">Cel. / Telf. Apoderado</th>
                                    <th scope="col">Dirección Alumno</th>
                                    <th scope="col">Opciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="alumno in alumnos">
                                        <th scope="row">@{{alumno.matricula_id}}</th>
                                        <td >@{{alumno.nombres}}</td>
                                        <td >@{{alumno.dni}}</td>
                                        <td >@{{alumno.apoderado.nombres}}</td>
                                        <td >@{{alumno.apoderado.celular}} / @{{alumno.apoderado.telefono}}</td>
                                        <td >@{{alumno.direccion}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-dark" v-on:click="verCronograma(alumno.matricula_id)"><i class="far fa-eye" ></i> Ver Cronograma</button>
                                                <button type="button" class="btn btn-secundary" v-on:click="editarAlumno(alumno.alumno_id)"><i class="far fa-edit"></i> Editar</button>
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
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/aulas/index.js')}}"></script>
@endsection
