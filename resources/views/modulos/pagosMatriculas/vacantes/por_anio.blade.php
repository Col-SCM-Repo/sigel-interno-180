@extends('layouts.moduloPagosYmatricula')

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
                                    <select id="seccion" :disabled="anio_id==''" class="form-control" aria-label="Default select example" v-model="aula_id" v-on:change="obtenerMatriculas" >
                                        <option value=''>Seleccione Aula</option>
                                        <option v-for="aula in aulas" :value="aula.id">@{{aula.nombre_completo}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div v-if="aula_id!=''" class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Lista de Alumnos (@{{matriculas.length}})</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group"  role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-light btn-sm" v-on:click="descargarLista" style="color: green"><i class="fas fa-file-csv " ></i> Exportar EXCEL</button>
                                        <button type="button" class="btn btn-light btn-sm" v-on:click="generarCarnets" style="color: orange"><i class="fas fa-address-card"></i> Carnets</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
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
                                    <tr v-for="(matricula,i) in matriculas">
                                        <th scope="row">@{{i+1}}</th>
                                        <th >@{{matricula.id}}</th>
                                        <td >@{{matricula.nombres_alumno}}</td>
                                        <td >@{{matricula.alumno.dni}}</td>
                                        <td >@{{matricula.pariente.apellidos +', ' +matricula.pariente.nombres}}</td>
                                        <td >@{{matricula.pariente.celular}} / @{{matricula.pariente.telefono}}</td>
                                        <td >@{{matricula.alumno.direccion}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary btn-sm" v-on:click="verCronograma(matricula.id)"><i class="far fa-eye" ></i> Cronograma</button>
                                                <button type="button" class="btn btn-success btn-sm" v-on:click="editarAlumno(matricula.alumno_id)"><i class="far fa-edit"></i> Editar</button>
                                                <button type="button" class="btn btn-light btn-sm" v-on:click="generarCarnetAlumno(matricula.id)"><i class="fas fa-address-card"></i> Carnet</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="8">
                                            <h3>Total de Alumnos: @{{matriculas.length}}</h3>
                                        </th>
                                    </tr>
                                </tfoot>
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
    <script src="{{asset('js/vacantes/por_anio.js')}}"></script>
@endsection
