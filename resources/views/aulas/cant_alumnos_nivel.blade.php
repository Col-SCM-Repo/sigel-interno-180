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
                                    <select id="anios" class="form-control" aria-label="Default select example" v-model="anio_id" >
                                        <option value=''>Seleccione Año</option>
                                        <option v-for="anio in anios" :value="anio.id">@{{anio.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <select id="niveles" :disabled="anio_id==''" class="form-control" aria-label="Default select example" v-model="nivel_id" v-on:change="obtenerSecciones" >
                                        <option value=''>Seleccione Nivel</option>
                                        <option value='1'>PRIMARIA</option>
                                        <option value='2'>SECUNDARIA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div v-if="nivel_id!=''" class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Lista de Secciones</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group"  role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-light" v-on:click="descargarPDF" style="color: red"><i class="fas fa-file-pdf " ></i> Exportar PDF</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">Grado</th>
                                    <th scope="col">Seccion</th>
                                    <th scope="col">Total Vacantes</th>
                                    <th scope="col">Vacantes Disponibles</th>
                                    <th scope="col">Vacantes Ocupadas</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="seccion in secciones">
                                        <th scope="row">@{{seccion.grado}}</th>
                                        <td >@{{seccion.seccion}}</td>
                                        <td >@{{seccion.total_vacantes}}</td>
                                        <td >@{{seccion.vacantes_disponibles}}</td>
                                        <td >@{{seccion.vacantes_ocupadas}} </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Total</td>
                                        <td>@{{total_vacantes}}</td>
                                        <td>@{{vacantes_disponibles}}</td>
                                        <td>@{{vacantes_ocupadas}}</td>
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
    <script src="{{asset('js/aulas/cant_alumnos_nivel.js')}}"></script>
@endsection
