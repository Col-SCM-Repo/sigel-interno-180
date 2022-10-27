@extends('layouts.moduloRRHH')

@section('styles')
    <style>
        *{

        }
        table{
            width: 100%;
        }
    </style>
@endsection

@section('content')
<div id="alumnos-academia" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ALUMNOS</div>
                <div class="card-body">
                    <!-- OPciones -->
                    <form id="form-busqueda" action="{{ route('rrhh.alumnos.data') }}" method="POST" class=" d-sm-flex justify-content-center align-items-center flex-wrap" v-on:submit="getData($event)">
                        <div class="px-3">
                            <label for="nivel">NIVEL: </label>
                            <select name="nivel" id="nivel" v-model="nivelStr" v-on:change="cargarAulas()">
                                <option value="">-Seleccione un nivel-</option>
                                <option value="ESCOLAR">ESCOLAR</option>
                                <option value="SEMILLERO">SEMILLERO</option>
                                <option value="SEMILLERO-PRE">SEMILLERO-PRE</option>
                                <option value="PREUNIVERSITARIO">PREUNIVERSITARIO</option>
                                <option value="ACADEMIA">ACADEMIA</option>
                            </select>
                        </div>
                        <div class="px-3">
                            <label for="aulas">AULAS DISPONIBLES: </label>
                            <select name="aulas" id="aulas" v-model="aulaSeleccionada">
                                <option value="">-Seleccione una aula-</option>
                                <option v-for="aula in aulasDisponibles" :value="aula">@{{ aula }}</option>
                            </select>
                        </div>
                        <div class="px-3">
                            <label for="fecha_busqueda" title="FECHA DE BUSQUEDA. ">F. BUSQUEDA</label>
                            <input type="date" name="fecha_busqueda" id="fecha_busqueda" required v-model="fecha">
                        </div>

                        <button class="input-group-text btn-sm" id="basic-addon2" ><i class="fas fa-search"></i></button >
                    </form>
                </div>

                <hr>

                <div class="card-footer">

                    <div class="p-1" v-if="alumnos">
                        <ul class="nav nav-tabs position-relative">
                            <li class="nav-item">
                                <button class="nav-link" :class="visible_maniana? 'active': ''" v-on:click="toggleTurn(true)" >Mañana</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link"  :class="!visible_maniana? 'active': ''" v-on:click="toggleTurn(false)"  >Tarde</button>
                            </li>
                            <li class="nav-item ">
                                <button class="nav-link btn btn-sm btn-secondary position-absolute " style="right: 0; position: absolute;" data-target="{{ route('rrhh.alumnos.download', ['type'=>'']) }}" v-on:click="descargar($event)" >Descargar reporte <i class="fa fa-download"> </i></button>
                            </li>
                        </ul>
                        <div class="bg-white p-1">
                            <div v-if="visible_maniana">
                                <table  class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5" style="text-align: center"> Turno Mañana </th>
                                        </tr>
                                        <tr>
                                            <th>Nº</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Nombre</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="(alumno, index) in alumnos.alumnos_maniana">
                                        <tr v-if="alumno.asistio">
                                            <td class="text-center" > @{{ index+1 }} </td>
                                            <td class="text-center" > @{{ alumno.fecha  }} </td>
                                            <td class="text-center" > @{{ alumno.hora  }} </td>
                                            <td> @{{ alumno.nombre }} </td>
                                            <td class="text-center"> ASISTIÓ </td>
                                        </tr>
                                        <tr v-else style="background: #FfCCDD;">
                                            <td class="text-center" > @{{ index+1 }} </td>
                                            <td class="text-center" > - </td>
                                            <td class="text-center" > - </td>
                                            <td> @{{ alumno.nombre }} </td>
                                            <td class="text-center"> FALTA </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="text-right small"> Alumnos asistentes @{{alumnos.count_maniana}} de @{{alumnos.alumnos_maniana.length}}   </p>
                            </div>
                            <div v-else>
                                <table  class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5" style="text-align: center"> Turno Tarde </th>
                                        </tr>
                                        <tr>
                                            <th>Nº</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Nombre</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="(alumno, index) in alumnos.alumnos_tarde">
                                        <tr v-if="alumno.asistio">
                                            <td class="text-center" > @{{ index+1 }} </td>
                                            <td class="text-center" > @{{ alumno.fecha  }} </td>
                                            <td class="text-center" > @{{ alumno.hora  }} </td>
                                            <td> @{{ alumno.nombre }} </td>
                                            <td class="text-center"> ASISTIÓ </td>
                                        </tr>
                                        <tr v-else style="background: #FfCCDD;">
                                            <td class="text-center" > @{{ index+1 }} </td>
                                            <td class="text-center" > - </td>
                                            <td class="text-center" > - </td>
                                            <td> @{{ alumno.nombre }} </td>
                                            <td class="text-center"> FALTA </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="text-right small"> Alumnos asistentes @{{alumnos.count_tarde}} de @{{alumnos.alumnos_tarde.length}}   </p>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center">
                            Sin resultados
                    </div>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" name="baseurl" id="baseurl" value="{{ asset('/') }}">
</div>

@endsection

@section('scripts')
    <script src="{{asset('js/reloj/alumnosAcademia.js')}}"></script>

    <script>
        const $formulario = document.getElementById('form-busqueda');

        $formulario.addEventListener('submit', (e)=>{
            e.preventDefault();

            console.log(e.target)
        })

    </script>


@endsection



