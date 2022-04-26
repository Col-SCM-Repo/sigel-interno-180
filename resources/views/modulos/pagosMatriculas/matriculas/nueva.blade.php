@extends('layouts.moduloPagosYmatricula')

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
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <h3>Datos del Alumno</h3>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary btn-sm" v-on:click="abrirAlumnoModal">
                                        <i class="far fa-edit"></i>  Editar
                                    </button>
                                </div>
                            </div>
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
                                <div :class="matricula_id=='0'?'col-md-6':'col-md-12'">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Apoderado</span>
                                        </div>
                                       <select :class="error && validaciones['matricula.pariente_id'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="matricula.pariente_id" >
                                           <option value="">SELECCIONE APODERADO</option>
                                           <option v-for="apoderado in apoderados" :value="apoderado.parentesco_id">@{{apoderado.apellidos +', '+ apoderado.nombres + ' - ' +apoderado.tipo_parentesco.nombre }}</option>
                                       </select>
                                       <div v-if="error && validaciones['matricula.pariente_id']!= undefined" class="invalid-feedback">
                                        @{{_.head(validaciones['matricula.pariente_id'])}}
                                        </div>
                                    </div>
                                </div>
                                <div v-if="matricula_id=='0'" class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Fec. Ingreso</span>
                                        </div>
                                        <input type="date" :class="error && validaciones['matricula.fecha_ingreso'] ? 'form-control is-invalid': 'form-control'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="matricula.fecha_ingreso">
                                        <div v-if="error && validaciones['matricula.fecha_ingreso']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['matricula.fecha_ingreso'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text" >I.E. de Prodecedencia</span>
                                                </div>
                                               <select style="width: 80%" id="matricula_ie_procedencia" class="'custom-select is-invalid" name=""  v-model="matricula.institucion_educativa_procedencia_id" >
                                                   <option disabled value="">SELECCIONE I.E.</option>
                                                   <option v-for="institucion in instituciones_educativas" :value="institucion.id">@{{institucion.nombre}}</option>
                                               </select>
                                               <div v-if="error && validaciones['matricula.institucion_educativa_procedencia_id']!= undefined" class="invalid-feedback">
                                                @{{_.head(validaciones['matricula.institucion_educativa_procedencia_id'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success btn-sm" v-on:click="abrirInsEducativaModal">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div  class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Tipo Matricula</span>
                                        </div>
                                       <select :class="error && validaciones['matricula.tipo_matricula_id'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="matricula.tipo_matricula_id" >
                                           <option value="">SELECCIONE TIPO</option>
                                           <option value="1">NORMAL</option>
                                           <option value="2">BECA</option>
                                           <option value="3">SEMIBECA</option>
                                           <option value="4">INTERCAMBIO</option>
                                           <option value="5">REINCORPORADO</option>
                                       </select>
                                       <div v-if="error && validaciones['matricula.tipo_matricula_id']!= undefined" class="invalid-feedback">
                                        @{{_.head(validaciones['matricula.tipo_matricula_id'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Estado</span>
                                        </div>
                                       <select :class="error && validaciones['matricula.estado'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="matricula.estado" >
                                           <option value="">SELECCIONE TIPO</option>
                                           <option value="1">NUEVO</option>
                                           <option value="2">NORMAL</option>
                                           <option value="3">PRIMERA MATRICULA</option>
                                           <option v-if="matricula_id!=0 && matricula.puede_retirarse " value="4">RETIRADO</option>
                                           <option value="5">ABANDONO</option>
                                       </select>
                                       <div v-if="error && validaciones['matricula.estado']!= undefined" class="invalid-feedback">
                                        @{{_.head(validaciones['matricula.estado'])}}
                                        </div>
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
                                        <select :disabled="secciones.length==0" :class="error && validaciones['matricula.vacante_id'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="matricula.vacante_id" >
                                           <option value="">SELECCIONE SECCION</option>
                                           <option  v-for="seccion in secciones" :class="parseInt(seccion.vacantes_disponibles)>5? 'text-success':'text-danger'" :value="seccion.id">@{{seccion.nombre_completo + ' - '+ seccion.vacantes_disponibles + ' DISPONIBLES'}}</option>>
                                        </select>
                                        <div v-if="error && validaciones['matricula.vacante_id']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['matricula.vacante_id'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div  class="row">
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
                            </div> --}}
                            <div  class="row">
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" >Observación</span>
                                        </div>
                                        <textarea class="form-control mayus" name="" id=""   v-model="matricula.observacion"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row justify-content-md-center">
                                <div class="col-auto">
                                    <button class="btn btn-primary btn-sm" v-on:click="guardar">
                                        <i class="far fa-save"></i> Guardar
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
    <!-- Modal de Institucion Educativa -->
    <div class="modal fade" id="insEducativaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Datos de la Institucion Educativa</h5>
                    <button  type="button" class="close" v-on:click="cerrarInsEducativaModal" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Institucion Educativa</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="institucion_modelo.nombre">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Codigo Modular</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="institucion_modelo.codigo_modular">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Dirección</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="institucion_modelo.direccion">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Referencia</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="institucion_modelo.referencia">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Tipo </span>
                                </div>
                                <select :class="error && validaciones['institucion_modelo.condicion_ie_id'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="institucion_modelo.tipo_ie_id" >
                                    <option value="">SELECCIONE CONDICIÓN</option>
                                    <option v-for="tipo in tipos" :value="tipo.id">@{{tipo.nombre}}</option>
                                 </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Condicion </span>
                                </div>
                                <select :class="error && validaciones['institucion_modelo.condicion_ie_id'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="institucion_modelo.condicion_ie_id" >
                                    <option value="">SELECCIONE CONDICIÓN</option>
                                    <option value="1">NO ESCOLARIZADO</option>
                                    <option value="2">MILITARIZADO</option>
                                    <option value="3">PRE - UNIVERSITARIO</option>
                                    <option value="4">NORMAL</option>
                                 </select>
                                 <div v-if="error && validaciones['institucion_modelo.condicion_ie_id']!= undefined" class="invalid-feedback">
                                     @{{_.head(validaciones['institucion_modelo.condicion_ie_id'])}}
                                 </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Pais </span>
                                </div>
                                <select :class="error && validaciones['institucion_modelo.pais_id'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="institucion_modelo.pais_id" >
                                    <option value="">SELECCIONE CONDICIÓN</option>
                                    <option v-for="pais in paises" :value="pais.id">@{{pais.pais}}</option>
                                </select>
                                <div v-if="error && validaciones['institucion_modelo.pais_id']!= undefined" class="invalid-feedback">
                                    @{{_.head(validaciones['institucion_modelo.pais_id'])}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Ubicación </span>
                                </div>
                                <select style="width: 80%" id="institucion_distrito" class="custom-select is-invalid" name=""  v-model="institucion_modelo.distrito_id" >
                                    <option disabled value="">SELECCIONE CONDICIÓN</option>
                                    <option v-for="distrito in distritos" :value="distrito.id">@{{distrito.region+' - '+distrito.provincia+' - '+distrito.distrito}}</option>
                                </select>
                                <div v-if="error && validaciones['institucion_modelo.distrito_id']!= undefined" class="invalid-feedback">
                                    @{{_.head(validaciones['institucion_modelo.distrito_id'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-primary btn-sm" v-on:click="guardarInstitucionEducativa">Guardar</button>
                    <button  type="button" class="btn btn-success btn-sm" v-on:click="cerrarInsEducativaModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Datos Alumno -->
<div class="modal fade" id="alumnoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Datos del alumno</h5>
                <button id="cerrarAlumnoModalbtn1" type="button" class="close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background: #fafafa">
                <div class="row ">
                    <div class="col-md-12">
                        <div id="editar" class="container">
                            @include('modulos.pagosMatriculas.alumnos._contenidoEditar')
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="cerrarAlumnoModalbtn2" type="button" class="btn btn-success btn-sm" >Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{asset('js/alumnos/editar.js')}}"></script>
    <script src="{{asset('js/matriculas/nueva.js')}}"></script>
@endsection
