@extends('layouts.app')

@section('content')
<div id="editar" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 v-if="alumno_id==0">Registrar Alumno</h3>
                    <h3 v-else>Editar Alumno</h3>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <h3></h3>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datos del Alumno</a>
                                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Datos de los Familiares</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" >Nombres</span>
                                                        </div>
                                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.nombres">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text" >Apellidos</span>
                                                        </div>
                                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.apellidos">
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text" >Género</span>
                                                        </div>
                                                       <select class="form-control" name=""  v-model="alumno.genero">
                                                           <option value="">SELECCIONE GÉNERO</option>
                                                           <option value="F">FEMENINO</option>
                                                           <option value="M">MASCULINO</option>
                                                       </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text" >DNI</span>
                                                        </div>
                                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.dni" maxlength="8">
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text" >Correo</span>
                                                        </div>
                                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.correo">
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text" >Fec. Nac.</span>
                                                        </div>
                                                        <input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.fecha_nacimiento">
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" >Celular</span>
                                                        </div>
                                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.celular">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text" >Teléfono</span>
                                                        </div>
                                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.telefono">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" >Religión</span>
                                                        </div>
                                                        <select class="form-control" name=""  v-model="alumno.religion_id">
                                                            <option value="">SELECCIONE RELIGIÓN</option>
                                                            <option v-for="religion in religiones" :value="religion.id">@{{religion.religion}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <h4>Datos de Residencia</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text" >País</span>
                                                        </div>
                                                       <select class="form-control" name=""  v-model="alumno.pais_id">
                                                           <option value="">SELECCIONE PAÍS</option>
                                                           <option v-for="pais in paises" :value="pais.id">@{{pais.nombre}}</option>
                                                       </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text" >Distrito de Nacimiento</span>
                                                        </div>
                                                       <select class="form-control" name=""  v-model="alumno.distrito_nacimiento">
                                                           <option value="">SELECCIONE DISTRITO</option>
                                                           <option v-for="distrito in distritos" :value="distrito.id">@{{distrito.region+' - '+distrito.provincia+' - '+distrito.provincia}}</option>
                                                       </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text" >Distrito de Residencia</span>
                                                        </div>
                                                       <select class="form-control" name=""  v-model="alumno.distrito_residencia">
                                                           <option value="">SELECCIONE DISTRITO</option>
                                                           <option v-for="distrito in distritos" :value="distrito.id">@{{distrito.region+' - '+distrito.provincia+' - '+distrito.provincia}}</option>
                                                       </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text" >Dirección</span>
                                                        </div>
                                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.direccion">
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-3">
                                            <button class="btn btn-dark" v-on:click="guardarAlumno">
                                                <i class="far fa-save"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h4>Lista de Familiares</h4>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button v-if="alumno_id!=0" type="button" class="btn btn-dark" v-on:click="editarFamiliar([],true,true)"><i class="fas fa-plus"></i> Agregar Familiar</button>
                                                        {{-- <button v-if="familiares.length!=0" type="button" class="btn btn-ligth" v-on:click="matricularAlumno"><i class="fas fa-plus"></i> Matricular</button> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nombres</th>
                                                    <th scope="col">DNI</th>
                                                    <th scope="col">Relacion</th>
                                                    <th scope="col">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(familiar,i) in familiares">
                                                    <th scope="row">@{{i+1}}</th>
                                                    <td>@{{familiar.apellidos+', '+ familiar.nombres}}</td>
                                                    <td>@{{familiar.dni}}</td>
                                                    <td>@{{familiar.tipo}}</td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <button type="button" class="btn btn-light" v-on:click="editarFamiliar(familiar,false,false)"><i class="far fa-eye" ></i> Info</button>
                                                            <button type="button" class="btn btn-light" v-on:click="editarFamiliar(familiar,true, false)"><i class="far fa-edit"></i> Editar</button>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div  class="col-md-12">
                                            <div v-if="familiar_seleccionado.length!=0" class="row">
                                                <div class="col-md-12">
                                                    <h4>Informaciación del Familiar</h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Tipo de Documento</span>
                                                                </div>
                                                               <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.tipo_documento_id">
                                                                   <option value="">SELECCIONE TIPO</option>
                                                                   <option v-for="tipo in tipo_documentos" :value="tipo.id">@{{tipo.nombre}}</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >DNI</span>
                                                                </div>
                                                                <input :disabled="!editar_familiar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.dni" maxlength="15">
                                                              </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" >Nombres</span>
                                                                </div>
                                                                <input :disabled="!editar_familiar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.nombres">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Apellidos</span>
                                                                </div>
                                                                <input :disabled="!editar_familiar"  type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.apellidos">
                                                              </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Género</span>
                                                                </div>
                                                               <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.genero">
                                                                   <option value="">SELECCIONE GÉNERO</option>
                                                                   <option value="F">FEMENINO</option>
                                                                   <option value="M">MASCULINO</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Fec. Nac.</span>
                                                                </div>
                                                                <input :disabled="!editar_familiar" type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.fecha_nacimiento">
                                                              </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" >Celular</span>
                                                                </div>
                                                                <input :disabled="!editar_familiar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.celular">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Teléfono</span>
                                                                </div>
                                                                <input :disabled="!editar_familiar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.telefono">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Correo</span>
                                                                </div>
                                                                <input :disabled="!editar_familiar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.correo">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" >Religión</span>
                                                                </div>
                                                                <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.religion_id">
                                                                    <option value="">SELECCIONE RELIGIÓN</option>
                                                                    <option v-for="religion in religiones" :value="religion.id">@{{religion.religion}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Estado Civíl</span>
                                                                </div>
                                                                <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.estado_civil_id">
                                                                    <option value="">SELECCIONE ESTADO</option>
                                                                    <option value="1">SOLTERO(A)</option>
                                                                    <option value="2">CASADO(A)</option>
                                                                    <option value="3">DIVORCIADO(A)</option>
                                                                    <option value="4">VIUDO(A)</option>
                                                                    <option value="5">CONVIVIENTE</option>
                                                                    <option value="6">NINGUNO</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" >Parentesco</span>
                                                                </div>
                                                                <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.tipo_id">
                                                                    <option value="">SELECCIONE PARENTESCO</option>
                                                                    <option v-for="parentesco in tipo_parentescos" :value="parentesco.id">@{{parentesco.nombre}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>Datos de Residencia</h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >País de Nacimiento</span>
                                                                </div>
                                                               <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.pais_nacimiento_id">
                                                                   <option value="">SELECCIONE PAÍS</option>
                                                                   <option v-for="pais in paises" :value="pais.id">@{{pais.nombre}}</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Distrito de Nacimiento</span>
                                                                </div>
                                                               <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.distrito_nacimiento_id">
                                                                   <option value="">SELECCIONE DISTRITO</option>
                                                                   <option v-for="distrito in distritos" :value="distrito.id">@{{distrito.region+' - '+distrito.provincia+' - '+distrito.provincia}}</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >País de Residencia</span>
                                                                </div>
                                                               <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.pais_residencia_id">
                                                                   <option value="">SELECCIONE PAÍS</option>
                                                                   <option v-for="pais in paises" :value="pais.id">@{{pais.nombre}}</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Distrito de Residencia</span>
                                                                </div>
                                                               <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.distrito_residencia_id">
                                                                   <option value="">SELECCIONE DISTRITO</option>
                                                                   <option v-for="distrito in distritos" :value="distrito.id">@{{distrito.region+' - '+distrito.provincia+' - '+distrito.provincia}}</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Dirección</span>
                                                                </div>
                                                                <input :disabled="!editar_familiar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.direccion">
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>Datos Laboralres</h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Grado de Instruccion</span>
                                                                </div>
                                                               <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.grado_intruccion_id">
                                                                   <option value="">SELECCIONE GRADO</option>
                                                                   <option v-for="grado in grados_intruccion" :value="grado.id">@{{grado.nombre}}</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Centro Laboral</span>
                                                                </div>
                                                               <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.centro_laboral_id">
                                                                   <option value="">SELECCION CENTRO</option>
                                                                   <option v-for="centro in centro_laborales" :value="centro.id">@{{centro.nombre}}</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                  <span class="input-group-text" >Ocupacion</span>
                                                                </div>
                                                               <select :disabled="!editar_familiar" class="form-control" name=""  v-model="familiar_seleccionado.ocupacion_id">
                                                                   <option value="">SELECCIONE OCUPACIÓN</option>
                                                                   <option v-for="ocupacion in ocupaciones" :value="ocupacion.id">@{{ocupacion.nombre}}</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="editar_familiar" class="col-md-12">
                                                    <button class="btn btn-dark" v-on:click="guardaFamiliar">
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
                </div>
            </div>
        </div>
    </div>
   <input type="text" id="alumno_id" value="{{$alumno_id}}" hidden>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/alumnos/editar.js')}}"></script>
@endsection
