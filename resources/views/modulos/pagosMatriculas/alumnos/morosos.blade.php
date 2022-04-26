@extends('layouts.moduloPagosYmatricula')

@section('content')
<div id="aulas" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Alumnos Morosos</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 " style="margin-bottom: 10px">
                            <div class="row">
                                <div class="col-md-2">
                                    <select id="anios" class="form-control" aria-label="Default select example" v-model="anio_id" v-on:change="restablecerValores">
                                        <option value=''>Seleccione Año</option>
                                        <option v-for="anio in anios" :value="anio.id">@{{anio.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select :disabled="anio_id==''" class="form-control" aria-label="Default select example" v-model="nivel_id" v-on:change="obtenerSecciones" >
                                        <option value=''>Seleccione Nivel</option>
                                        <option value='1'>PRIMARIA</option>
                                        <option value='2'>SECUNDARIA</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select v-model="seccion_id" :disabled="nivel_id==''" class="form-control" aria-label="Default select example" >
                                        <option value=''>Seleccione Seccion</option>
                                        <option value='0'>TODOS</option>
                                        <option v-for="seccion in secciones" :value='seccion.id'>@{{seccion.nombre_completo}}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select v-model="concepto_id" :disabled="nivel_id==''" class="form-control" aria-label="Default select example" >
                                        <option value=''>Seleccione Conceptos</option>
                                        <option value='0'>TODOS</option>
                                        <option v-for="concepto in conceptos" :value='concepto.concepto_pago_id'>@{{concepto.concepto}}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select v-model="estado" :disabled="nivel_id==''" class="form-control" aria-label="Default select example" >
                                        <option value=''>Seleccione Estado</option>
                                        <option value='0'>TODOS</option>
                                        <option value='1'>SALDO</option>
                                        <option value='2'>PENDIENTE</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group"  role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary btn-sm" v-on:click="obtenerAlumnosMorosos" ><i class="fas fa-search" ></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="alumnos.length>0" class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Lista de Morosos</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group"  role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-light btn-sm" v-on:click="descargarPDF" style="color: red"><i class="fas fa-file-pdf " ></i> Exportar PDF</button>
                                        <button type="button" class="btn btn-light btn-sm" v-on:click="descargarExcel" style="color: green"><i class="fas fa-file-csv " ></i> Exportar Excel</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cod. Matricula</th>
                                    <th scope="col">Alumno</th>
                                    <th scope="col">Aula / Nivel</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Estado</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(alumno,i) in alumnos">
                                        <th scope="row">@{{i+1}}</th>
                                        <th scope="row">@{{alumno.matricula_id}}</th>
                                        <td>@{{alumno.apellidos+', '+alumno.nombres}}</td>
                                        <td>@{{alumno.aula+' - '+alumno.nivel}}</td>
                                        <td>@{{alumno.estado_matricula}}</td>
                                        <td>@{{alumno.concepto}}</td>
                                        <td>S/ @{{alumno.saldo}} </td>
                                        <td>@{{alumno.estado}} </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">Total</td>
                                        <td>S/ @{{total_monto}}</td>
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
    <script src="{{asset('js/alumnos/morosos.js')}}"></script>
@endsection
