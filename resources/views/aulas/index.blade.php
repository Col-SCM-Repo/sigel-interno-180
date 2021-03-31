@extends('layouts.app')

@section('content')
<div id="alumnos" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Aulas</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Seleccione Año</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                      </select>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Seleccione Aula</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
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
                                  {{-- <tr v-for="(alumno,i) in alumnos">
                                    <th scope="row">@{{i+1}}</th>
                                    <td >@{{alumno.nombres}}</td>
                                    <td >@{{alumno.dni}}</td>
                                    <td>
                                        <button type="button" class="btn btn-light" v-on:click="abrirModalMatriculas(alumno)"><i class="far fa-eye"></i> Ver Matriculas</button>
                                    </td>
                                  </tr> --}}
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

@endsection
