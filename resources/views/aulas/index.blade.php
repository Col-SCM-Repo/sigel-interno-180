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
                                    <select class="form-control" aria-label="Default select example" v-model="anio_id" v-on:change="obtenerAulas">
                                        <option value=''>Seleccione Año</option>
                                        <option v-for="anio in anios" :value="anio.id">@{{anio.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <select :disabled="anio_id==''" class="form-control" aria-label="Default select example" v-model="aula_id" v-on:change="obtenerAlumnos" >
                                        <option value=''>Seleccione Aula</option>
                                        <option v-for="aula in aulas" :value="aula.id">@{{aula.nombre_completo}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div v-if="aula_id!=''" class="col-md-12">
                            <h3>Lista de Alumnos</h3>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">Cod. Matrícula</th>
                                    <th scope="col">Alumno</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Apoderado</th>
                                    <th scope="col">Cel. / Telf. Apoderado</th>
                                    <th scope="col">Dirección Alumno</th>
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
