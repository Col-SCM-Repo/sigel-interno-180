@extends('layouts.moduloPagosYmatricula')

@section('content')
<div id="anios" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Años Escolares</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 " style="">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <h3>Lista de Años Escolares</h3>
                                </div>
                                <div class="col-auto">
                                    <div class="btn-group"  role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary btn-sm" v-on:click="crearAnio" ><i class="fas fa-plus" ></i> Crear Año</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Año</th>
                                        <th scope="col">Fecha Inicio</th>
                                        <th scope="col">Fecha Fin</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(anio,i) in anios">
                                        <td>@{{i+1}}</td>
                                        <td>@{{anio.descripcion}}</td>
                                        <td>@{{anio.nombre}}</td>
                                        <td>@{{anio.fecha_inicio}}</td>
                                        <td>@{{anio.fecha_fin}}</td>
                                        <td :class="anio.estado=='VIGENTE'?'text-success':'text-danger'">
                                            @{{anio.estado}}
                                        </td>
                                        <td>
                                            <div class="btn-group"  role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary btn-sm" v-on:click=editarAnio(anio) >
                                                    <i class="fas fa-edit" ></i> Editar
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm" v-on:click=abrirAulasModal(anio) >
                                                    <i class="fas fa-eye" ></i> Aulas
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm" v-on:click=abrirConceptosModal(anio) >
                                                    <i class="fas fa-eye" ></i> Conceptos / Pagos
                                                </button>
                                                <button type="button" class="btn btn-light btn-sm" v-on:click=abrirCarnetsModal(anio) >
                                                    <i class="fas fa-eye" ></i> Carnets
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
    <!-- Modal Crea / Edidar Año academico -->
    <div class="modal fade" id="anioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="!editar" class="modal-title" id="exampleModalLabel">Crear Año</h5>
                    <h5 v-else class="modal-title" id="exampleModalLabel">Editar Año</h5>
                    <button type="button" class="close" v-on:click="cerrarAnioModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Nombre</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control" id="comprobante" v-model="anio_modelo.nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Descripción</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control" id="comprobante" v-model="anio_modelo.descripcion">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Fecha Inicio</label>
                                <div class="col-sm-8">
                                    <input type="date"  class="form-control" id="comprobante" v-model="anio_modelo.fecha_inicio">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Fecha Fin</label>
                                <div class="col-sm-8">
                                    <input type="date"  class="form-control" id="comprobante" v-model="anio_modelo.fecha_fin">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comprobante"class="col-sm-4 col-form-label">Estado</label>
                                <div class="col-sm-8">
                                    <input type="text"  class="form-control" id="comprobante" v-model="anio_modelo.estado">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarAnioModal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarAnio" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Listar Aulas -->
    <div class="modal fade" id="aulasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Aulas del Año @{{anio_modelo.nombre}}</h5>
                    <div class="btn-group"  role="group" aria-label="Basic example" style="margin-left: 100px!important">
                        <button type="button" class="btn btn-primary btn-sm" v-on:click="crearAula">
                            <i class="fas fa-plus"></i> Crear Aula
                        </button>
                    </div>
                    <button type="button" class="close" v-on:click="cerrarAulasModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa">
                    <div class="row" style="margin: auto!important;">
                        <div class="'col-md-12">
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nivel - Grado° Sección</th>
                                        <th scope="col">Total Vacantes</th>
                                        <th scope="col">Vacante Disponibles</th>
                                        <th scope="col">Vacante Ocupadas</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(aula,i) in lista_aulas">
                                        <td>@{{i+1}}</td>
                                        <td>@{{aula.nombre_completo}}</td>
                                        <td>@{{aula.total_vacantes}}</td>
                                        <td>@{{aula.vacantes_disponibles}}</td>
                                        <td>@{{aula.vacantes_ocupadas}}</td>
                                        <td>
                                            <div class="btn-group"  role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary btn-sm" v-on:click="editarAula(aula)">
                                                    <i class="fas fa-edit" ></i> Editar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarAulasModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Crea / Editar Aula -->
    <div class="modal fade" id="aulaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="!editar" class="modal-title" id="exampleModalLabel">Crear Aula</h5>
                    <h5 v-else class="modal-title" id="exampleModalLabel">Editar Aula</h5>
                    <button type="button" class="close" v-on:click="cerrarAulaModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Seleccione Local</span>
                                </div>
                                <select class="custom-select"  name=""  v-model="aula_modelo.local_id">
                                   <option value="">SELECCIONE LOCAL</option>
                                   <option value="1">PRINCIPAL</option>
                                   <option value="2">ANEXO</option>
                                   <option value="4">POLIDOCENCIA PRÓCERES</option>
                                   <option value="5">POLIDOCENCIA SAN MARTÍN</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Nivel</span>
                                </div>
                                <select class="custom-select"  name=""  v-model="aula_modelo.nivel_id">
                                   <option value="">SELECCIONE NIVEL</option>
                                   <option value="1">PRIMARIA</option>
                                   <option value="2">SECUNDARIA</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >GRADO</span>
                                </div>
                                <select class="custom-select"  name=""  v-model="aula_modelo.grado_id">
                                   <option value="">SELECCIONE GRADO</option>
                                   <option value="1">PRIMERO</option>
                                   <option value="2">SEGUNDO</option>
                                   <option value="3">TERCERO</option>
                                   <option value="4">CUARTO</option>
                                   <option value="5">QUINTO</option>
                                   <option value="6">SEXTO</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Sección</span>
                                </div>
                                <select class="custom-select"  name=""  v-model="aula_modelo.seccion_id">
                                   <option value="">SELECCIONE SECCIÓN</option>
                                   <option value="1">A</option>
                                   <option value="2">B</option>
                                   <option value="3">C</option>
                                   <option value="4">D</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Total Vacantes</span>
                                </div>
                                <input  type="text" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="aula_modelo.total_vacantes">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Observación</span>
                                </div>
                                <input  type="tex" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="aula_modelo.observacion">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarAulaModal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarAula" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Lista de Conceptos -->
    <div class="modal fade" id="conceptosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Conceptos del Año @{{anio_modelo.nombre}}</h5>
                    <div class="btn-group"  role="group" aria-label="Basic example" style="margin-left: 100px!important">
                        <button type="button" class="btn btn-primary btn-sm" v-on:click="crearConcepto">
                            <i class="fas fa-plus"></i> Crear Concepto
                        </button>
                    </div>
                    <button type="button" class="close" v-on:click="cerrarConceptosModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa">
                    <div class="row" style="margin: auto!important;">
                        <div class="'col-md-12">
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Concepto</th>
                                        <th scope="col">Monto</th>
                                        <th scope="col">Nivel</th>
                                        <th scope="col">Local</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(concepto,i) in lista_conceptos_anio">
                                        <td>@{{i+1}}</td>
                                        <td>@{{concepto.concepto}}</td>
                                        <td>S/ @{{concepto.monto}}</td>
                                        <td>@{{concepto.nivel.nivel}}</td>
                                        <td>@{{concepto.local.nombre}}</td>
                                        <td>
                                            <div class="btn-group"  role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary btn-sm" v-on:click="editarConcepto(concepto)">
                                                    <i class="fas fa-edit" ></i> Editar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarConceptosModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Crea / Editar Concepto -->
    <div class="modal fade" id="conceptoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="!editar" class="modal-title" id="exampleModalLabel">Crear Concepto</h5>
                    <h5 v-else class="modal-title" id="exampleModalLabel">Editar Concepto</h5>
                    <button type="button" class="close" v-on:click="cerrarConceptoModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Concepto</span>
                                </div>
                                <select class="custom-select"  name=""  v-model="concepto_modelo.id">
                                   <option value="">SELECCIONE CONCEPTO</option>
                                   <option v-for="concepto in lista_conceptos" :value="concepto.id">@{{concepto.concepto}}</option>
                                </select>
                            </div>
                            <div v-if="parseInt(concepto_modelo.id)<=11" class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Local</span>
                                </div>
                                <select class="custom-select"  name=""  v-model="concepto_modelo.local_id">
                                   <option value="">SELECCIONE LOCAL</option>
                                   <option value="1">PRINCIPAL</option>
                                   <option value="2">ANEXO</option>
                                   <option value="4">POLIDOCENCIA PRÓCERES</option>
                                   <option value="5">POLIDOCENCIA SAN MARTÍN</option>
                                </select>
                            </div>
                            <div v-if="parseInt(concepto_modelo.id)<=11" class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Nivel</span>
                                </div>
                                <select class="custom-select"  name=""  v-model="concepto_modelo.nivel_id">
                                   <option value="">SELECCIONE NIVEL</option>
                                   <option value="1">PRIMARIA</option>
                                   <option value="2">SECUNDARIA</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Monto</span>
                                </div>
                                <input  type="text" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="concepto_modelo.monto">
                            </div>
                            <div v-if="parseInt(concepto_modelo.id)<=11" class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Fecha Vencimiento</span>
                                </div>
                                <input  type="date" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" v-model="concepto_modelo.fecha_vencimiento">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarConceptoModal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarConcepto" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Lista de Carnets -->
    <div class="modal fade" id="carnetsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Carnets del Año @{{anio_modelo.nombre}}</h5>
                    <div class="btn-group"  role="group" aria-label="Basic example" style="margin-left: 100px!important">
                        <button type="button" class="btn btn-primary btn-sm" v-on:click="crearCarnet" >
                            <i class="fas fa-plus"></i> Crear carnet
                        </button>
                    </div>
                    <button type="button" class="close" v-on:click="cerrarCarnetsModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa">
                    <div class="row" style="margin: auto!important;">
                        <div class="'col-md-12">
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Carnet</th>
                                        <th scope="col">Nivel</th>
                                        <th scope="col">Local</th>
                                        <th scope="col">Ubicación</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(carnet,i) in lista_carnets">
                                        <td>@{{i+1}}</td>
                                        <td>
                                            <img :src="carnet.path" alt="" style="width: 40px;">
                                        </td>
                                        <td>@{{carnet.nivel.nivel}}</td>
                                        <td>@{{carnet.local.nombre}}</td>
                                        <td>@{{carnet.parte}}</td>
                                        <td>
                                            <div class="btn-group"  role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary btn-sm" v-on:click="editarCarnet(carnet)">
                                                    <i class="fas fa-edit" ></i> Editar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarCarnetsModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Crea / Editar Carnet -->
    <div class="modal fade" id="carnetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="!editar" class="modal-title" id="exampleModalLabel">Crear Carnet</h5>
                    <h5 v-else class="modal-title" id="exampleModalLabel">Editar Carnet</h5>
                    <button type="button" class="close" v-on:click="cerrarCarnetModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa">
                    <div class="row ">
                        <div class="col-md-12">
                            <img id="carnet_imagen" :src="carnet_modelo.path" alt="" style="margin-left: 150px !important; height: 200px !important;">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Imagen</span>
                                </div>
                                <input type="file" class="form-control" v-on:change="precargarImagen($event)" accept="image/*">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Local</span>
                                </div>
                                <select class="custom-select"  name=""  v-model="carnet_modelo.local_id">
                                   <option value="">SELECCIONE LOCAL</option>
                                   <option value="1">PRINCIPAL</option>
                                   <option value="2">ANEXO</option>
                                   <option value="4">POLIDOCENCIA PRÓCERES</option>
                                   <option value="5">POLIDOCENCIA SAN MARTÍN</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Nivel</span>
                                </div>
                                <select class="custom-select"  name=""  v-model="carnet_modelo.nivel_id">
                                   <option value="">SELECCIONE NIVEL</option>
                                   <option value="1">PRIMARIA</option>
                                   <option value="2">SECUNDARIA</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" >Ubicacion</span>
                                </div>
                                <select class="custom-select"  name=""  v-model="carnet_modelo.parte">
                                   <option value="">SELECCIONE UBICACIÓN</option>
                                   <option value="FRENTE">FRENTE</option>
                                   <option value="REVERSO">REVERSO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" v-on:click="cerrarCarnetModal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarCarnet" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{asset('js/anioAcademico/index.js')}}"></script>
@endsection
