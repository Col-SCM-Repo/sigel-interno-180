@extends('layouts.app')

@section('content')
<div id="pagos" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">AULAS</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 " style="margin-bottom: 10px">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="comprobante"class="col-sm-4 col-form-label">Fecha Inicial</label>
                                        <div class="col-sm-8">
                                            <input type="date"  class="form-control" id="fecha_inicial" v-model="fecha_inicial">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="comprobante"class="col-sm-4 col-form-label">Fecha Final</label>
                                        <div class="col-sm-8">
                                            <input type="date"  class="form-control" id="fecha_final" v-model="fecha_final">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group"  role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-dark" v-on:click="obtenerPagos"><i class="fas fa-search " ></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="pagos.length>0" class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Lista de Pagos</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group"  role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-light" v-on:click="descargarPDF" style="color: red"><i class="fas fa-file-csv " ></i> Exportar PDF</button>
                                        <button type="button" class="btn btn-light" v-on:click="descargarExcel"  style="color: green"><i class="fas fa-file-csv " ></i> Exportar EXCEL</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Alumno</th>
                                    <th scope="col">Tipo Comprobante</th>
                                    <th scope="col">Serie</th>
                                    <th scope="col">Numero</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Opciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(pago,i) in pagos">
                                        <th scope="row">@{{i+1}}</th>
                                        <td >@{{pago.fecha}}</td>
                                        <td >@{{pago.concepto}}</td>
                                        <td >@{{pago.alumno}}</td>
                                        <td >@{{pago.tipo}}</td>
                                        <td >@{{pago.serie}}</td>
                                        <td >@{{pago.numero}}</td>
                                        <td >S/@{{pago.monto}}</td>
                                        <td >@{{pago.usuario}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-dark" v-on:click="verBoleta(pago.id)"><i class="far fa-eye" ></i> Boleta | Factura </button>
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
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/pagos/pagos_entre_fechas.js')}}"></script>
@endsection
