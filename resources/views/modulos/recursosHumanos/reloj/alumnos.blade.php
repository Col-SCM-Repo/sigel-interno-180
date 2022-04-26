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
<div id="alumnos" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ALUMNOS</div>
                <div class="card-body">
                    <!-- OPciones -->
                    <form id="form-busqueda" action="{{ route('rrhh.alumnos.data') }}" method="POST" class=" d-sm-flex justify-content-center align-items-center flex-wrap" v-on:submit="getData($event)">
                        <div class="px-3">
                            <label for="nivel">NIVEL</label>
                            <select name="nivel" id="nivel">
                                <option value="">-Seleccione un nivel-</option>
                                <option value="PRIMARIA">PRIMARIA</option>
                                <option value="SECUNDARIA">SECUNDARIA</option>
                            </select>
                        </div>
                        <div class="px-3">
                            <label for="grado">GRADO</label>
                            <select name="grado" id="grado">
                                <option value="">-Seleccione un grado-</option>
                                <option value="1">PRIMERO</option>
                                <option value="2">SEGUNDO</option>
                                <option value="3">TERCERO</option>
                                <option value="4">CUARTO</option>
                                <option value="5">QUINTO</option>
                                <option value="6">SEXTO</option>
                            </select>
                        </div>
                        <div class="px-3">
                            <label for="seccion">SECCION</label>
                            <select name="seccion" id="seccion">
                                <option value="">-</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                        <div class="px-3">
                            <label for="f_inicio">F.INICIO</label>
                            <input type="date" name="f_inicio" id="f_inicio">
                        </div>
                        
                        <!--   
                        <div class="px-3">
                            <label for="f_fin">F.FIN</label>
                            <input type="date" name="f_fin" id="f_fin">
                        </div>
                        -->

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
</div>

@endsection

@section('scripts')
    <script src="{{asset('js/reloj/alumnos.js')}}"></script>

    <script>
        /*SUPER LOGICA PARA EL COMPORTAMIENTO DE LAS OPCIONES*/
        /*Comportaminento*/
        const $formulario = document.getElementById('form-busqueda');
        console.log($formulario.nivel);

        /*
        $formulario.nivel.addEventListener('change',(e)=>{
            console.log(e)
        });

        */

        /*Validaciones*/



        /* PETICIONES */
        $formulario.addEventListener('submit', (e)=>{
            e.preventDefault();

            console.log(e.target)
        })

    </script>


@endsection



