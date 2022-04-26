

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
                <div v-if="alumno_id!='0'" class="col-md-4">
                    <div class="row justify-content-cente">
                        <div class="col-md-12">
                            <div class="text-center">
                                <img id="foto_alumno" :src="alumno.url_foto"  class="rounded mx-auto" alt="foto_alumno" width="40%">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" accept="image/jpeg" v-on:change="precargarImagen($event)">
                                    <label class="custom-file-label" for="inputGroupFile04">Selecione archivo</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04" v-on:click="guardarImagen" style=" font-size: 0.6rem;"><i class="fas fa-upload"></i> Subir Foto</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="alumno_id!='0'?'col-md-8':'col-md-12'">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Nombres</span>
                                </div>
                                <input type="text" :class="error && validaciones['alumno.nombres'] ? 'form-control is-invalid mayus': 'form-control mayus'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.nombres">
                                <div v-if="error && validaciones['alumno.nombres']!= undefined" class="invalid-feedback">
                                    @{{_.head(validaciones['alumno.nombres'])}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Apellidos</span>
                                </div>
                                <input type="text" :class="error && validaciones['alumno.apellidos'] ? 'form-control is-invalid mayus': 'form-control mayus'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.apellidos">
                                <div v-if="error && validaciones['alumno.apellidos']!= undefined" class="invalid-feedback">
                                    @{{_.head(validaciones['alumno.apellidos'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Género</span>
                                </div>
                                <select :class="error && validaciones['alumno.genero'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="alumno.genero">
                                    <option value="">SELECCIONE GÉNERO</option>
                                    <option value="F">FEMENINO</option>
                                    <option value="M">MASCULINO</option>
                                </select>
                                <div v-if="error && validaciones['alumno.genero']!= undefined" class="invalid-feedback">
                                    @{{_.head(validaciones['alumno.genero'])}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >DNI</span>
                                </div>
                                <input type="text" :class="error && validaciones['alumno.dni'] ? 'form-control is-invalid': 'form-control'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.dni" maxlength="8">
                                <div v-if="error && validaciones['alumno.dni']!= undefined" class="invalid-feedback">
                                    @{{_.head(validaciones['alumno.dni'])}}
                                </div>
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
                                <input type="date" :class="error && validaciones['alumno.fecha_nacimiento'] ? 'form-control is-invalid': 'form-control'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.fecha_nacimiento">
                                <div v-if="error && validaciones['alumno.fecha_nacimiento']!= undefined" class="invalid-feedback">
                                    @{{_.head(validaciones['alumno.fecha_nacimiento'])}}
                                </div>
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
                                <select  :class="error && validaciones['alumno.religion_id'] ? 'custom-select is-invalid': 'custom-select'"   v-model="alumno.religion_id">
                                    <option value="">SELECCIONE RELIGIÓN</option>
                                    <option v-for="religion in religiones" :value="religion.id">@{{religion.religion}}</option>
                                </select>
                                <button class="btn btn-success btn-sm" v-on:click="crearReligion(1)" style=" font-size: 0.6rem;"><i class="fas fa-plus"></i></button>
                                <div v-if="error && validaciones['alumno.religion_id']!= undefined" class="invalid-feedback">
                                    @{{_.head(validaciones['alumno.religion_id'])}}
                                </div>
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
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >País</span>
                                        </div>
                                        <select style="width: 80%" id="alumno_pais" class="custom-select is-invalid" name=""  v-model="alumno.pais_id">
                                            <option disabled value="">SELECCIONE PAÍS</option>
                                            <option v-for="pais in paises" :value="pais.id">@{{pais.pais}}</option>
                                        </select>
                                        <div v-if="error && validaciones['alumno.pais_id']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['alumno.pais_id'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success btn-sm" v-on:click="crearPais(1,2)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Distrito de Nacimiento</span>
                                        </div>
                                        <select style="width: 80%" id="alumno_nacimiento" class="custom-select is-invalid" name=""  v-model="alumno.distrito_nacimiento">
                                            <option disabled value="">SELECCIONE DISTRITO</option>
                                            <option v-for="distrito in distritos" :value="distrito.id">@{{distrito.region+' - '+distrito.provincia+' - '+distrito.distrito}}</option>
                                        </select>
                                        <div v-if="error && validaciones['alumno.distrito_nacimiento']!= undefined" class="invalid-feedback">
                                        @{{_.head(validaciones['alumno.distrito_nacimiento'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success btn-sm" v-on:click="crearDistrito(1,3)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Distrito de Residencia</span>
                                        </div>
                                        <select style="width: 81%" id="alumno_residencia" class="custom-select is-invalid" name=""  v-model="alumno.distrito_residencia">
                                            <option disabled value="">SELECCIONE DISTRITO</option>
                                            <option v-for="distrito in distritos" :value="distrito.id">@{{distrito.region+' - '+distrito.provincia+' - '+distrito.distrito}}</option>
                                        </select>
                                        <div v-if="error && validaciones['alumno.distrito_residencia']!= undefined" class="invalid-feedback">
                                        @{{_.head(validaciones['alumno.distrito_residencia'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success btn-sm" v-on:click="crearDistrito(1,4)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Dirección</span>
                                </div>
                                <input type="text" :class="error && validaciones['alumno.direccion'] ? 'form-control is-invalid mayus': 'form-control mayus'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="alumno.direccion">
                                <div v-if="error && validaciones['alumno.pais_id']!= undefined" class="invalid-feedback">
                                    @{{_.head(validaciones['alumno.direccion'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-md-3">
                    <button class="btn btn-primary btn-sm" v-on:click="guardarAlumno">
                        <i class="far fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
        {{-- Seccion familiares --}}
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <h4>Lista de Familiares</h4>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button v-if="alumno_id!=0" type="button" class="btn btn-primary btn-sm" v-on:click="editarFamiliar([],true,true)"><i class="fas fa-plus"></i> Agregar Familiar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover table-sm table-bordered">
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
                            <td>@{{familiar.tipo_parentesco.nombre}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-success btn-sm" v-on:click="editarFamiliar(familiar,false,false)"><i class="far fa-eye" ></i> Info</button>
                                    <button type="button" class="btn btn-primary btn-sm" v-on:click="editarFamiliar(familiar,true, false)"><i class="far fa-edit"></i> Editar</button>
                                </div>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div  class="col-md-12">
                    <div v-if="familiar_seleccionado.length!=0" class="row">
                        <div class="col-md-12">
                            <h4>Información del Familiar</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Tipo de Documento</span>
                                        </div>
                                        <select :disabled="!editar_familiar" :class="error && validaciones['familiar.tipo_documento_id'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="familiar_seleccionado.tipo_documento_id">
                                            <option value="">SELECCIONE TIPO</option>
                                            <option v-for="tipo in tipo_documentos" :value="tipo.id">@{{tipo.nombre}}</option>
                                        </select>
                                        <div v-if="error && validaciones['familiar.tipo_documento_id']!= undefined" class="invalid-feedback">
                                        @{{_.head(validaciones['familiar.tipo_documento_id'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >DNI</span>
                                        </div>
                                        <input :disabled="!editar_familiar" type="text" :class="error && validaciones['familiar.dni'] ? 'form-control is-invalid': 'form-control'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.dni" maxlength="15">
                                        <div v-if="error && validaciones['familiar.dni']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.dni'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Nombres</span>
                                        </div>
                                        <input :disabled="!editar_familiar" type="text" :class="error && validaciones['familiar.nombres'] ? 'form-control is-invalid mayus': 'form-control mayus'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.nombres">
                                        <div v-if="error && validaciones['familiar.nombres']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.nombres'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Apellidos</span>
                                        </div>
                                        <input :disabled="!editar_familiar"  type="text" :class="error && validaciones['familiar.apellidos'] ? 'form-control is-invalid mayus': 'form-control mayus'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.apellidos">
                                        <div v-if="error && validaciones['familiar.apellidos']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.apellidos'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Género</span>
                                        </div>
                                        <select :disabled="!editar_familiar" :class="error && validaciones['familiar.genero'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="familiar_seleccionado.genero">
                                            <option value="">SELECCIONE GÉNERO</option>
                                            <option value="F">FEMENINO</option>
                                            <option value="M">MASCULINO</option>
                                        </select>
                                        <div v-if="error && validaciones['familiar.genero']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.genero'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Fec. Nac.</span>
                                        </div>
                                        <input :disabled="!editar_familiar" type="date" :class="error && validaciones['familiar.fecha_nacimiento'] ? 'form-control is-invalid': 'form-control'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.fecha_nacimiento">
                                        <div v-if="error && validaciones['familiar.fecha_nacimiento']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.fecha_nacimiento'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Celular</span>
                                        </div>
                                        <input :disabled="!editar_familiar" type="text" :class="error && validaciones['familiar.celular'] ? 'form-control is-invalid': 'form-control'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.celular">
                                        <div v-if="error && validaciones['familiar.celular']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.celular'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Teléfono</span>
                                        </div>
                                        <input :disabled="!editar_familiar" type="text" :class="error && validaciones['familiar.telefono'] ? 'form-control is-invalid': 'form-control'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.telefono">
                                        <div v-if="error && validaciones['familiar.telefono']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.telefono'])}}
                                        </div>
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
                                        <select :disabled="!editar_familiar" :class="error && validaciones['familiar.religion_id'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="familiar_seleccionado.religion_id">
                                            <option value="">SELECCIONE RELIGIÓN</option>
                                            <option v-for="religion in religiones" :value="religion.id">@{{religion.religion}}</option>
                                        </select>
                                        <button class="btn btn-success btn-sm" v-on:click="crearReligion(2)" style=" font-size: 0.6rem;"><i class="fas fa-plus"></i></button>
                                        <div v-if="error && validaciones['familiar.religion_id']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.religion_id'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Estado Civíl</span>
                                        </div>
                                        <select :disabled="!editar_familiar" :class="error && validaciones['familiar.estado_civil_id'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="familiar_seleccionado.estado_civil_id">
                                            <option value="">SELECCIONE ESTADO</option>
                                            <option value="1">SOLTERO(A)</option>
                                            <option value="2">CASADO(A)</option>
                                            <option value="3">DIVORCIADO(A)</option>
                                            <option value="4">VIUDO(A)</option>
                                            <option value="5">CONVIVIENTE</option>
                                            <option value="6">NINGUNO</option>
                                        </select>
                                        <div v-if="error && validaciones['familiar.estado_civil_id']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.estado_civil_id'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Parentesco</span>
                                        </div>
                                        <select :disabled="!editar_familiar" :class="error && validaciones['familiar.tipo_parentesco_id'] ? 'custom-select is-invalid': 'custom-select'" name=""  v-model="familiar_seleccionado.tipo_parentesco_id">
                                            <option value="">SELECCIONE PARENTESCO</option>
                                            <option v-for="parentesco in tipo_parentescos" :value="parentesco.id">@{{parentesco.nombre}}</option>
                                        </select>
                                        <div v-if="error && validaciones['familiar.tipo_parentesco_id']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.tipo_parentesco_id'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h4>Datos de Residencia</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" >País de Nacimiento</span>
                                                </div>
                                                <select id="familiar_pais_nacimiento" :disabled="!editar_familiar" class="custom-select is-invalid" name=""  v-model="familiar_seleccionado.pais_nacimiento_id">
                                                    <option value="">SELECCIONE PAÍS</option>
                                                    <option v-for="pais in paises" :value="pais.id">@{{pais.pais}}</option>
                                                </select>
                                                <div v-if="error && validaciones['familiar.pais_nacimiento_id']!= undefined" class="invalid-feedback">
                                                    @{{_.head(validaciones['familiar.pais_nacimiento_id'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success btn-sm" v-on:click="crearPais(2,2)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" >Distrito de Nacimiento</span>
                                                </div>
                                                <select id="familiar_distrito_nacimiento" :disabled="!editar_familiar" class="custom-select is-invalid" name=""  v-model="familiar_seleccionado.distrito_nacimiento_id">
                                                    <option value="">SELECCIONE DISTRITO</option>
                                                    <option v-for="distrito in distritos" :value="distrito.id">@{{distrito.region+' - '+distrito.provincia+' - '+distrito.distrito}}</option>
                                                </select>
                                                <div v-if="error && validaciones['familiar.distrito_nacimiento_id']!= undefined" class="invalid-feedback">
                                                    @{{_.head(validaciones['familiar.distrito_nacimiento_id'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success btn-sm" v-on:click="crearDistrito(2,4)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" >País de Residencia</span>
                                                </div>
                                                <select id="familiar_pais_residencia" :disabled="!editar_familiar" class="custom-select is-invalid" name=""  v-model="familiar_seleccionado.pais_residencia_id">
                                                    <option value="">SELECCIONE PAÍS</option>
                                                    <option v-for="pais in paises" :value="pais.id">@{{pais.pais}}</option>
                                                </select>
                                                <div v-if="error && validaciones['familiar.pais_residencia_id']!= undefined" class="invalid-feedback">
                                                    @{{_.head(validaciones['familiar.pais_residencia_id'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success btn-sm" v-on:click="crearPais(2,3)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" >Distrito de Residencia</span>
                                                </div>
                                                <select id="familiar_distrito_residencia" :disabled="!editar_familiar" class="custom-select is-invalid" name=""  v-model="familiar_seleccionado.distrito_residencia_id">
                                                    <option value="">SELECCIONE DISTRITO</option>
                                                    <option v-for="distrito in distritos" :value="distrito.id">@{{distrito.region+' - '+distrito.provincia+' - '+distrito.distrito}}</option>
                                                </select>
                                                <div v-if="error && validaciones['familiar.distrito_residencia_id']!= undefined" class="invalid-feedback">
                                                    @{{_.head(validaciones['familiar.distrito_residencia_id'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success btn-sm" v-on:click="crearDistrito(2,5)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Dirección</span>
                                        </div>
                                        <input :disabled="!editar_familiar" type="text" :class="error && validaciones['familiar.direccion'] ? 'form-control is-invalid mayus': 'form-control mayus'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="familiar_seleccionado.direccion">
                                        <div v-if="error && validaciones['familiar.direccion']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.direccion'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h4>Datos Laborales</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Grado de Instruccion</span>
                                        </div>
                                        <select :disabled="!editar_familiar" :class="error && validaciones['familiar.grado_instruccion_id'] ? 'custom-select is-invalid': 'custom-select'"  name=""  v-model="familiar_seleccionado.grado_instruccion_id">
                                            <option value="">SELECCIONE GRADO</option>
                                            <option v-for="grado in grados_intruccion" :value="grado.id">@{{grado.nombre}}</option>
                                        </select>
                                        <div v-if="error && validaciones['familiar.grado_instruccion_id']!= undefined" class="invalid-feedback">
                                            @{{_.head(validaciones['familiar.grado_instruccion_id'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" >Centro Laboral</span>
                                                </div>
                                                <select id="familiar_centro_laboral"  :disabled="!editar_familiar" class="custom-select is-invalid" name=""  v-model="familiar_seleccionado.centro_laboral_id">
                                                    <option value="">SELECCION CENTRO</option>
                                                    <option v-for="centro in centro_laborales" :value="centro.id">@{{centro.nombre}}</option>
                                                </select>
                                                <div v-if="error && validaciones['familiar.centro_laboral_id']!= undefined" class="invalid-feedback">
                                                    @{{_.head(validaciones['familiar.centro_laboral_id'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success btn-sm" v-on:click="crearCentroLaboral(2,6)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" >Ocupacion</span>
                                                </div>
                                                <select id="familiar_ocupacion" :disabled="!editar_familiar" class="custom-select is-invalid"  name=""  v-model="familiar_seleccionado.ocupacion_id">
                                                    <option value="">SELECCIONE OCUPACIÓN</option>
                                                    <option v-for="ocupacion in ocupaciones" :value="ocupacion.id">@{{ocupacion.nombre}}</option>
                                                </select>
                                                <div v-if="error && validaciones['familiar.ocupacion_id']!= undefined" class="invalid-feedback">
                                                    @{{_.head(validaciones['familiar.ocupacion_id'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success btn-sm" v-on:click="crearOcupacion(2,7)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div v-if="editar_familiar" class="col-md-3">
                            <button class="btn btn-primary btn-sm" v-on:click="guardaFamiliar">
                                <i class="far fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


     <!-- Modal para Religiones-->
    <div class="modal fade" id="religionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Religión </h5>
                    <button type="button" class="close" v-on:click="cerraModalReligion">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-left: 75px; background: #fafafa">
                    <div class="row">
                        <div class="'col-md-12">
                            <div class="form-group row">
                                <label for="monto" class="col-sm-4 col-form-label">Religion</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" id="nueva_religion" value="" placeholder="Ingrese la religión">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerraModalReligion" >Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="GuardarReligion" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Paises-->
    <div class="modal fade" id="paisModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo País </h5>
                    <button type="button" class="close" v-on:click="cerraModalPais">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-left: 75px; background: #fafafa">
                    <div class="row">
                        <div class="'col-md-12">
                            <div class="form-group row">
                                <label for="monto" class="col-sm-4 col-form-label">País</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" id="nuevo_pais" value="" placeholder="Ingrese el País">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerraModalPais" >Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="GuardarPais" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Distritos-->
    <div class="modal fade" id="distritoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Distrito </h5>
                    <button type="button" class="close" v-on:click="cerraModalDistrito">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-left: 75px; background: #fafafa">
                    <div class="row">
                        <div class="'col-md-12">
                            <div class="form-group row">
                                <label for="monto" class="col-sm-4 col-form-label">Región</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" v-model="modelo.region" value="" placeholder="Ingrese la Región">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="monto" class="col-sm-4 col-form-label">Provincia</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" v-model="modelo.provincia" value="" placeholder="Ingrese la Provincia">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="monto" class="col-sm-4 col-form-label">Distrito</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" v-model="modelo.distrito" value="" placeholder="Ingrese el Distrito">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerraModalDistrito" >Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="GuardarDistrito" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Centro laboral-->
    <div class="modal fade" id="centroLaboralModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Centro Laboral </h5>
                    <button type="button" class="close" v-on:click="cerraCentroLaboral">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-left: 75px; background: #fafafa">
                    <div class="row">
                        <div class="'col-md-12">
                            <div class="form-group row">
                                <label for="monto" class="col-sm-4 col-form-label">Centro Laboral</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" v-model="modelo.nombre" value="" placeholder="Ingrese el Centro Laboral">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerraCentroLaboral" >Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarCentroLaboral" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Ocupacion-->
    <div class="modal fade" id="ocupacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Ocupación </h5>
                    <button type="button" class="close" v-on:click="cerraOcupacion">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-left: 75px; background: #fafafa">
                    <div class="row">
                        <div class="'col-md-12">
                            <div class="form-group row">
                                <label for="monto" class="col-sm-4 col-form-label">Ocupación</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control mayus" v-model="modelo.nombre" value="" placeholder="Ingrese la Ocupación">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerraOcupacion" >Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarOcupacion" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
   <input type="text" id="alumno_id" value="{{$alumno_id}}" hidden>

