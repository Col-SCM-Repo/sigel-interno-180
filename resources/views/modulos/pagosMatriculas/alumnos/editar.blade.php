@extends('layouts.moduloPagosYmatricula')

@section('content')
    <div id="editar" class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <h3 v-if="alumno_id==0">Registrar Alumno</h3>
                                <h3 v-else>Editar Alumno</h3>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button v-if="familiares.length!=0" type="button" class="btn btn-primary btn-sm" v-on:click="matricularAlumno"><i class="fas fa-file-invoice"></i> Matricular</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @include('modulos.pagosMatriculas.alumnos._contenidoEditar')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/alumnos/editar.js')}}"></script>
@endsection
