@extends('layouts.moduloRRHH')

@section('styles')
    <style>
        *{

        }

        input[type="date"]{
            border: none;
            border-bottom: 1px solid #333;
            background: transparent;
            margin-left: 10px;
            /*outline: none;*/
        }

        table{
            width: 100%;
        }
    </style>
@endsection

@section('content')
<div id="empleados" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">EMPLEADOS</div>
                <div class="card-body">
                    <!-- OPciones -->
                    <form id="form-busqueda" data-target="{{ route('rrnn.empleados.search') }}" @submit="getListaEmpleados($event)" class=" d-sm-flex justify-content-center align-items-center flex-wrap" >
                        <div class="input-group mb-3">
                            <input data-target="{{ route('rrnn.empleados.search') }}" @keyup="getListaEmpleados($event)" v-model="param" type="text" name="empleado_buscar" class="form-control mayus" placeholder="Ingrese NOMBRES, APELLIDOS o DNI">
                            <button class="input-group-text btn-sm" id="basic-addon2" type="submit" >
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </form>
                    <!--  Lista de empleados  -->
                    <div class="lista-empleados" v-if="! infoEmpleado">
                        <hr>
                        <table class="col-110table-striped" >
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th> NRO </th>
                                    <th class="text-left pl-5">APELLIDOS Y NOMBRES DEL PERSONAL</th> 
                                    <th class="text-left pl-3">DEPARTAMENTO</th> 
                                    <th style="width: 150px">ACCIONES</th> 
                                </tr>
                            </thead>
                            <tbody class="table-light">
                                <template v-if="data">
                                    <tr v-for="(personal,index) in data" :key="index">
                                        <td class="text-center"> @{{index+1}}</td>    
                                        <td style="padding-left: 16px"> @{{personal.nombre_empleado}}</td>
                                        <td style="padding-left: 16px"> @{{personal.departamento}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary" @click="cargarDataAsistencia($event)" 
                                            :data-nombre="personal.nombre_empleado" 
                                            :data-departamento="personal.departamento" 
                                            :data-id_personal="personal.nUserIdn" 
                                            type="button">
                                                Seleccionar &nbsp; <i class="fa fa-file" aria-hidden="true"></i> 
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr style="height: 100px">
                                        <td colspan="3" class="text-center" >Sin datos</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer" v-if="infoEmpleado">
                    <!--  Acciones -->
                    <form id="form-info-empleado" class="mt-1 mb-1 p-2 pt-4" style="border-top: 1px solid #333; border-bottom: 1px solid #333;">
                        <div class="d-block">
                            <div class="col-12 col-sm-5 col-md-7 d-inline-block">
                                <p>
                                    <strong>NOMBRE:</strong> @{{ infoEmpleado.nombre }}
                                </p>
                                <p>
                                    <strong>DEPARTAMENTO:</strong> @{{ infoEmpleado.departamento }}
                                </p> 
                            </div>
                            <div class="col-12 col-sm-5 col-md-4 d-inline-block">
                                <div class="form-group form-inline">
                                    <label for="f_inicio">Desde: </label> <input type="date" name="f_inicio" id="f_inicio" >
                                </div>
                                <div class="form-group form-inline">
                                    <label for="f_fin">Hasta:  </label> <input type="date" name="f_fin" id="f_fin" >
                                </div>
                            </div>
                            <input type="hidden" name="id_empleado" :value="infoEmpleado.id" >
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-outline-dark" data-target="{{ route('rrnn.empleados.ver') }}" @click="verReporte($event)"> 
                                <i class="fa fa-eye" aria-hidden="true"></i> Reporte 
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-dark" disabled> 
                                <i class="fa fa-eye" aria-hidden="true"></i> Horarios 
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-dark" data-target="{{ route('rrnn.empleados.download') }}" @click="descargarReporte($event)" > 
                                <i class="fa fa-download" aria-hidden="true"></i> Generar EXCEL 
                            </button>
                        </div>
                    </form>
                    <!--  Informacion ded los horarios  -->
                    <div id="info-horarios">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/reloj/empleados.js')}}"></script>
    <script>
        /* */
    </script>
@endsection



