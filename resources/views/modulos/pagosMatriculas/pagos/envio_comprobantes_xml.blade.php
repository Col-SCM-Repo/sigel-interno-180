@extends('layouts.moduloPagosYmatricula')

@section('styles')

    <style>
        .fs-04{ font-size: .4rem; }
        .fs-05{ font-size: .5rem; }
        .fs-06{ font-size: .6rem; }
        .fs-07{ font-size: .7rem; }

        .bg-verde-suavizado{
            background-color:#b7ebc482 !important;
        }

    </style>

@endsection

@section('content')


<div id="pagos" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ENVIO DE COMPROBANTES XML </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 " style="margin-bottom: 10px">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="comprobante"class="col-md-4 col-form-label">Fecha Inicial</label>
                                        <div class="col-md-8">
                                            <input type="date"  class="form-control" id="fecha_inicial" v-model="fecha_inicial">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="comprobante"class="col-md-4 col-form-label">Fecha Final</label>
                                        <div class="col-md-8">
                                            <input type="date"  class="form-control" id="fecha_final" v-model="fecha_final">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                   <select class="form-control" name="" id="" v-model="usuario_id">
                                       <option value="">Seleccione Usuario</option>
                                       <option value="0">TODOS</option>
                                       @foreach ($usuarios as $usuario)
                                            <option value="{{$usuario->id()}}">{{$usuario->nombres()}}</option>
                                       @endforeach
                                   </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group"  role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary btn-sm" v-on:click="obtenerPagos"><i class="fas fa-search " ></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="pagos.length>0" class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 fs-06">
                                    <h3>Lista de Pagos  <small>@{{ getNumeroSeleccionados() }} </small></h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-light btn-sm" v-on:click="descargarArchivosXML"  style="color: slategray"> <i class="fa fa-file" aria-hidden="true"></i> Descargar archivos marcados</button>
                                </div>

                                <div class="col-md-12">
                                    <table class="table table-striped table-sm  table-hover ">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th class="fs-07" scope="col">#</th>
                                                <th class="fs-07" scope="col">Fecha</th>
                                                <th class="fs-07" scope="col">Concepto</th>
                                                <th class="fs-07" scope="col">Alumno</th>
                                                <th class="fs-07" scope="col">Tipo Comprobante</th>
                                                <th class="fs-07" scope="col">Serie</th>
                                                <th class="fs-07" scope="col">Numero</th>
                                                <th class="fs-07" scope="col">Monto</th>
                                                <th class="fs-07" scope="col">Efec. / Dep</th>
                                                <th class="fs-07" scope="col">XML</th>
                                                <th class="fs-07" scope="col" >
                                                    <input type="checkbox" name="" id="cbx_todos" v-on:change="cambiarChecks($event)" >
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr v-for="(pago,i) in pagos"   >
                                                    <th class="fs-06" :class=" [ pago.check? 'bg-verde-suavizado': '' ]" scope="row">@{{i+1}}</th>
                                                    <td class="fs-06" :class=" [ pago.check? 'bg-verde-suavizado': '' ]" v-on:click="marcarCheck(i)" >  @{{pago.fecha}}    </td>
                                                    <td class="fs-06" :class=" [ pago.check? 'bg-verde-suavizado': '' ]" v-on:click="marcarCheck(i)" >  @{{pago.concepto}} </td>
                                                    <td class="fs-06" :class=" [ pago.check? 'bg-verde-suavizado': '' ]" v-on:click="marcarCheck(i)" >  @{{pago.alumno}}   </td>
                                                    <td class="fs-06" :class=" [ pago.check? 'bg-verde-suavizado': '' ]" v-on:click="marcarCheck(i)" >  @{{pago.tipo}}     </td>
                                                    <td class="fs-06" :class=" [ pago.check? 'bg-verde-suavizado': '' ]" v-on:click="marcarCheck(i)" >  @{{pago.serie}}    </td>
                                                    <td class="fs-06" :class=" [ pago.check? 'bg-verde-suavizado': '' ]" v-on:click="marcarCheck(i)" >  @{{pago.numero}}   </td>
                                                    <td class="fs-06" :class=" [ pago.check? 'bg-verde-suavizado': '' ]" v-on:click="marcarCheck(i)" >  @{{pago.monto}}    </td>
                                                    <td class="fs-06" :class=" [ pago.check? 'bg-verde-suavizado': '' ]" v-on:click="marcarCheck(i)" >  @{{pago.tipoPago}} </td>
                                                    <td class="fs-06" >
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a :href='"{{ route('matricula.generar.xml-especifico', ['pago_id'=>'']) }}/" + pago.id' target="_blank" class="btn btn-light btn-xs px-1 fs-06"> <i class="fa fa-file" aria-hidden="true"></i> XML </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" v-model="pago.check"  >
                                                    </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7">
                                                    <h3>Total</h3>
                                                </td>
                                                <td>
                                                    S/ @{{total}}
                                                </td>
                                            </tr>
                                        </tfoot>
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
@endsection

@section('scripts')
    <script src="{{asset('js/pagos/envio_comprobantes_xml.js')}}"></script>
@endsection
