@extends('layouts.app')

@section('content')
<div id="nueva" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 v-if="matricula_id==0">Nueva Matrícula</h3>
                    <h3 v-else>Editar Matrícula</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Datos del Alumno</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >DNI</span>
                                        </div>
                                        <input id="buscar_alumno" :disabled="alumno_id==0?false:true" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.dni" v-on:change="buscarAlumnoPorDNI" maxlength="8">
                                      </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Género</span>
                                        </div>
                                       <select class="form-control" name=""  v-model="alumno.genero" disabled>
                                           <option value="">SELECCIONE GÉNERO</option>
                                           <option value="F">FEMENINO</option>
                                           <option value="M">MASCULINO</option>
                                       </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Nombres</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.nombres" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Apellidos</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.apellidos" disabled>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="alumno_id!=0" class="col-md-12">
                            <h3>Datos de la Matricula</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Apoderado</span>
                                        </div>
                                       <select class="form-control" name=""  v-model="matricula.pariente_id" >
                                           <option value="">SELECCIONE APODERADO</option>
                                           <option v-for="apoderado in apoderados" :value="apoderado.parentesco_id">@{{apoderado.apellidos +', '+ apoderado.nombres + ' - ' +apoderado.tipo }}</option>
                                       </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >I.E. de Prodecedencia</span>
                                        </div>
                                       <select class="form-control" name=""  v-model="matricula.ie_procedencia_id" >
                                           <option value="">SELECCIONE I.E.</option>
                                           <option v-for="institucion in instituciones_educativas" :value="institucion.id">@{{institucion.nombre}}</option>
                                       </select>
                                    </div>
                                </div>
                            </div>
                            <div  class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Tipo Matricula</span>
                                        </div>
                                       <select class="form-control" name=""  v-model="matricula.tipo_id" >
                                           <option value="">SELECCIONE TIPO</option>
                                           <option value="1">NORMAL</option>
                                           <option value="2">BECA</option>
                                           <option value="3">SEMIBECA</option>
                                           <option value="4">INTERCAMBIO</option>
                                           <option value="5">REINCORPORADO</option>
                                       </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Estado</span>
                                        </div>
                                       <select class="form-control" name=""  v-model="matricula.estado" >
                                           <option value="">SELECCIONE TIPO</option>
                                           <option value="1">NUEVO</option>
                                           <option value="2">NORMAL</option>
                                           <option value="3">PRIMERA MATRICULA</option>
                                           <option value="4">RETIRADO</option>
                                           <option value="5">ABANDONO</option>
                                       </select>
                                    </div>
                                </div>
                            </div>
                            <div  class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Nivel</span>
                                        </div>
                                       <select class="form-control" name=""  v-model="matricula.nivel" >
                                           <option value="">SELECCIONE NIVEL</option>
                                           <option value="1">PRIMARIA</option>
                                           <option value="2">SECUNDARIA</option>
                                       </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Grado</span>
                                        </div>
                                        <select :disabled="matricula.nivel==''" class="form-control" name=""  v-model="matricula.grado" v-on:change="obtenerSecciones">
                                           <option value="">SELECCIONE GRADO</option>
                                           <option value="1">1° - PRIMERO</option>
                                           <option value="2">2° - SEGUNDO</option>
                                           <option value="3">3° - TERCERO</option>
                                           <option value="4">4° - CUARTO</option>
                                           <option value="5">5° - QUINTO</option>
                                           <option v-if="matricula.nivel == 1" value="6">6° - SEXTO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Sección</span>
                                        </div>
                                        <select :disabled="secciones.length==0" class="form-control" name=""  v-model="matricula.vacante_id" >
                                           <option value="">SELECCIONE SECCION</option>
                                           <option v-for="seccion in secciones" :value="seccion.vacante_id">@{{seccion.seccion}}</option>>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div  class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Monto Matrícula</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="matricula.monto_matricula" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Monto Pensión</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="matricula.monto_pension" >
                                    </div>
                                </div>
                            </div>
                            <div  class="row">
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Observación</span>
                                        </div>
                                        <textarea class="form-control" name="" id=""   v-model="matricula.observacion"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row justify-content-md-center">
                                <div class="col-sm-3">
                                    <button class="btn btn-dark" v-on:click="guardar">
                                        <i class="far fa-save"></i> Guardar
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button class="btn btn-light">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <input type="text" id="alumno_id" value="{{$alumno_id}}" hidden>
   <input type="text" id="matricula_id" value="{{$matricula_id}}" hidden>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/matriculas/nueva.js')}}"></script>
@endsection
