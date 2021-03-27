@extends('layouts.app')

@section('content')
<div id="pagos" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">REGISTRAR PAGOS</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-control" aria-label=".form-select-sm example" v-model="anio_id">
                                <option value="">Seleccione Año</option>
                                <option v-for="anio in anios" :value="anio.id">@{{anio.nombre}}</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Ingrese nombres o DNI" aria-label="Ingrese nombres" aria-describedby="basic-addon2" v-model="cadena">
                                <button class="input-group-text" id="basic-addon2" v-on:click="obtenerAlumnos"><i class="fas fa-search"></i></button >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h3>Lista de Alumnos</h3>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">Cod.</th>
                                    <th scope="col">Alumno</th>
                                    <th scope="col">Nivel</th>
                                    <th scope="col">Sección</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Opciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="alumno in alumnos">
                                    <th scope="row">@{{alumno.matricula_id}}</th>
                                    <td >@{{alumno.nombres}}</td>
                                    <td >@{{alumno.nivel}}</td>
                                    <td >@{{alumno.seccion}}</td>
                                    <td >@{{alumno.estado}}</td>
                                    <td>
                                        <button type="button" class="btn btn-light" v-on:click="verCronograma(alumno.matricula_id)"><i class="far fa-eye"></i> Ver Cronograma</button>
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
    <script src="{{asset('js/pagos/index.js')}}"></script>
@endsection
