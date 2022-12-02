@extends('layouts.app')
@section('titulo',"SIGEL")

@section('styles')
    <style>
        .fs-0-75rem { font-size: 0.75rem; }
        .fs-1rem    { font-size: 1rem; }
        .fs-1-125rem{ font-size: 1.125rem; }
        .fs-1-2rem  { font-size: 1.2rem; }
    </style>
@endsection

@section('content')
<div class="container" id="documentos">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header d-flex">
                    <div style="flex-grow: 1">
                        DOCUMENTOS REGISTRADOS
                    </div>
                    <div class="text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle text-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              {{ $modulo_id? $modulo: 'FILTRAR' }}
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item"  href="{{ route('documentos.index', ['modulo'=>'']) }}">Mostrar todo</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item"  href="{{ route('documentos.index', ['modulo'=>'pagos y matriculas']) }}">Pagos y matriculas</a>
                              <a class="dropdown-item"  href="{{ route('documentos.index', ['modulo'=>'notas academicas']) }}">Notas Academicas</a>
                              <a class="dropdown-item"  href="{{ route('documentos.index', ['modulo'=>'recursos humanos']) }}">RR.HH</a>
                              <a class="dropdown-item"  href="{{ route('documentos.index', ['modulo'=>'logistica']) }}">Logistica</a>
                            </div>
                          </div>
                          <button class="btn btn-sm btn-primary" type="button"  v-on:click="abrirModalNuevoDocumento" title="Subir nuevo documento">
                              <i class="fa fa-plus" aria-hidden="true"></i> Nuevo documento
                          </button>
                          <a class="btn btn-sm btn-warning" href="{{ route('documentos.informacion') }}" target="_blank" title="Informacion sobre las plantillas">
                            <i class="fa fa-eye" aria-hidden="true"></i> Información
                          </a>
                    </div>
                </div>

                <div class="card-body">

                    <div class="container">
                        <div class="row">
                            <!-------------------------------- BEGIN: LISTA DOCUMENTOS -------------------------------->
                            <template v-if=" lista_documentos.length>0 ">
                                <div class="col-sm-4 col-md-3" v-for="documento in lista_documentos" >
                                    <div class="card bg-light" >
                                        <div class="card-header d-flex">
                                            <h5 class="card-title text-center fs-0-75rem mb-0" style="flex-grow: 1">@{{ documento.nombre_archivo }}</h5>
                                            <button class="btn btn-sm btn-transparent text-danger p-0" v-on:click="mensajeConfirmacionArchivo(documento.id, documento.nombre_archivo)" >
                                                <i class="fas fa-trash  "></i>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="text-primary">
                                                    <i v-if="documento.extension == 'docx' || documento.extension == 'doc'" class="fas fa-file-word fa-5x  "></i>
                                                    <i v-else-if="documento.extension == 'xls' || documento.extension == 'xlsx'" class="fas fa-file-word fa-5x  "></i>
                                                    <i v-else-if="documento.extension == 'png' || documento.extension == 'jpg'|| documento.extension == 'jpeg' || documento.extension == 'gif'" class="fas fa-file-image fa-5x  "></i>
                                                    <i v-else-if="documento.extension == 'pdf' " class="fas fa-file-word fa-5x  "></i>
                                                    <i v-else class="fas fa-file fa-5x  "></i>
                                                </div>
                                            </div>
                                            <br>
                                            <a {{-- download --}} target="_blank" :href='"{{ asset('/') }}" + documento.directorio + "/" + documento.nombre_archivo ' type="button" class="btn btn-primary btn-block btn-sm">
                                                <i class="fas fa-download  "></i> <span class="fs-0-75rem">Descargar</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <div class="text-center col-12 p-3">
                                    <span>No se encontrarón documentos</span>
                                </div>
                            </template>

                            <!-------------------------------- END: LISTA DOCUMENTOS -------------------------------->
                        </div>
                    </div>
                </div>
                <input type="hidden" id="modulo_id" value="{{$modulo_id}}">
                <input type="hidden" id="base_url" value="{{ route('documentos.index', ['modulo'=>'']) }}">
            </div>
        </div>
    </div>

    <!------------------ BEGIN: MODAL CARGA DOCUMENTOS ------------------>
    <div class="modal fade" id="modal-carga-documentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row justify-content-between" style="width: 100%">
                        <div class="col-auto">
                            <h3 class="modal-title" > @{{ (documento_seleccionado_id != null && documento_seleccionado_id != '')? 'ACTUALIZAR':'NUEVO' }} DOCUMENTO</h3>
                        </div>
                    </div>
                    <button type="button" class="close" v-on:click="cerrarModalNuevoDocumento" style="margin: -1rem -1rem -1rem 0rem!important;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" v-if="documento_seleccionado">
                    <form id="formulario-modal-documentos"  action="{{ route('documentos.guardar') }}" v-on:submit="submitSubirArchivo($event)">

                        <div class="form-group">
                          <label for="txt-nombre-archivo">Nombre:</label>
                          <input type="text" class="form-control" id="txt-nombre-archivo" name="nombre_archivo"  v-model="documento_seleccionado.nombre_archivo">
                        </div>
                        <div class="form-group">
                          <label for="select-tipo-documento">Tipo de documento:</label>
                          <select class="form-control text-uppercase" name="select_tipo_documento" id="select-tipo-documento"  v-model="documento_seleccionado.tipo_documento">
                            <option value="">SELECCIONE UN TIPO DE DOCUMENTO</option>
                            <option value="ESTATICO">   DOCUMENTO NO MODIFICABLE </option>
                            <option value="PLANTILLA">  DOCUMENTO PLANTILLA      </option>
                          </select>
                        </div>
                            <div class="form-group {{ $modulo_id != '' ? 'd-none' : '' }} "  >
                              <label for="select-modulo-sistema">Modulo del sistema al que corresponde:</label>
                              <select class="form-control text-uppercase" id="select-modulo-sistema"  v-model="documento_seleccionado.modulo_sistema_id">
                                <option value="">SELECCIONE UN MODULO</option>
                                @foreach ($modulosDisponibles_VM as $modulo_VM)
                                    <option value="{{ $modulo_VM->id }}"> {{ $modulo_VM->nombre_modulo . ($modulo_VM->nombre_submodulo!=''? '/'.$modulo_VM->nombre_submodulo : '') }}</option>
                                @endforeach
                              </select>
                            </div>
                        <div class="form-group">
                          <label for="txt-archivo-documento">Documento</label>
                          <input type="file" class="form-control-file" name="archivo_documento" id="txt-archivo-documento" >
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" v-on:click="cerrarModalNuevoDocumento">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-sm" form="formulario-modal-documentos">
                        <i class="fa fa-upload" aria-hidden="true"></i>
                        Subir archivo
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!------------------ END: MODAL CARGA DOCUMENTOS ------------------>

</div>
@endsection

@section('scripts')
    <script src="{{asset('js/modulos/logistica/documentos/documentos.js')}}"></script>
@endsection

