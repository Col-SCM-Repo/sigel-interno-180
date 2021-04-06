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
                                        <div class="col-md-3">
                                            <button class="btn btn-light">
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>Lista de Familiares</h4>
                                                    <table class="table table-hover">
                                                        <thead>
                                                          <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Nombres</th>
                                                            <th scope="col">Relacion</th>
                                                            <th scope="col">Opciones</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <tr v-for="(familiar,i) in familiares">
                                                            <th scope="row">@{{i+1}}</th>
                                                            <td>@{{familiar.apellidos+', '+ familiar.nombres}}</td>
                                                            <td>@{{familiar.tipo}}</td>
                                                            <td>
                                                            </td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
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
