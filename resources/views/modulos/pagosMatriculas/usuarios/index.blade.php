@extends('layouts.moduloPagosYmatricula')

@section('content')
<div id="usuarios" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Usuarios</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 " style="">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <h3>Lista de Usuarios</h3>
                                </div>
                                <div class="col-auto">
                                    <div class="btn-group"  role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary btn-sm" v-on:click="crearUsuario" ><i class="fas fa-plus" ></i> Crear </button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Apellidos</th>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Cargo</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(usuario,i) in usuarios">
                                        <td>@{{i+1}}</td>
                                        <td>@{{usuario.apellidos}}</td>
                                        <td>@{{usuario.nombres}}</td>
                                        <td>@{{usuario.usuario}}</td>
                                        <td>@{{usuario.cargo}}</td>
                                        <td :class="usuario.estado=='ACTIVO'?'text-success':'text-danger'">
                                            @{{usuario.estado}}
                                        </td>
                                        <td>@{{usuario.tipo}}</td>
                                        <td>
                                            <div class="btn-group"  role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary btn-sm" v-on:click="editarUsuario(usuario)" >
                                                    <i class="fas fa-edit" ></i> Editar
                                                </button>
                                                <button v-if="usuario.serie" type="button" class="btn btn-success btn-sm" v-on:click="editarSerie(usuario)" >
                                                    <i class="fas fa-edit" ></i> Editar Serie
                                                </button>
                                                <button v-else type="button" class="btn btn-light btn-sm" v-on:click=crearSerie(usuario) >
                                                    <i class="fas fa-edit" ></i> Asignar Serie
                                                </button>
                                            </div>
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
    <!-- Modal Crea / Edidar Usuario -->
    <div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="!editar" class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
                    <h5 v-else class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" v-on:click="cerrarUsuarioModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Nombre</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" id="comprobante" v-model="usuario_modelo.nombres" placeholder="Ingrese nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Apellidos</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" id="comprobante" v-model="usuario_modelo.apellidos" placeholder="Ingrese apellidos">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Usuario</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control " id="comprobante" v-model="usuario_modelo.usuario" placeholder="Ingrese usuario">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Cargo</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" id="comprobante" v-model="usuario_modelo.cargo" placeholder="Ingrese cargo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Estado</label>
                                <div class="col-sm-8">
                                    <select name="" id="" class="custom-select" v-model="usuario_modelo.estado">
                                        <option value="">SELECCIONE ESTADO</option>
                                        <option value="ACTIVO">ACTIVO</option>
                                        <option value="INACTIVO">INACTIVO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Tipo</label>
                                <div class="col-sm-8">
                                    <select name="" id="" class="custom-select" v-model="usuario_modelo.tipo">
                                        <option value="">SELECCIONE ESTADO</option>
                                        <option value="SUPERVISOR">SUPERVISOR</option>
                                        <option value="NORMAL">NORMAL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password"  class="form-control" id="comprobante" v-model="usuario_modelo.password" placeholder="Ingrese contraseña">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarUsuarioModal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarUsuario" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Crea / Edidar Serie -->
    <div class="modal fade" id="serieModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="!editar" class="modal-title" id="exampleModalLabel">Crear Serie de @{{usuario_modelo.nombres}}</h5>
                    <h5 v-else class="modal-title" id="exampleModalLabel">Editar Serie de de @{{usuario_modelo.nombres}}</h5>
                    <button type="button" class="close" v-on:click="cerrarSerieModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Serie</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" id="comprobante" v-model="serie_modelo.nombre" placeholder="Ingrese nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Etiquetera</label>
                                <div class="col-sm-8">
                                    <select name="" id="" class="custom-select" v-model="serie_modelo.etiquetera_id">
                                        <option value="">SELEECIONE ETIQUETERA</option>
                                        <option value="1">ETIQUETERA 1</option>
                                        <option value="2">ETIQUETERA 2</option>
                                        <option value="3">ETIQUETERA 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarSerieModal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarSerie" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{asset('js/usuarios/index.js')}}"></script>
@endsection
