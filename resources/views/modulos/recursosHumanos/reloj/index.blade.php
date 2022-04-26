@extends('layouts.moduloRRHH')

@section('content')
<div id="app" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">BUSCAR PERSONAL</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input id="buscar" type="text" class="form-control mayus" placeholder="Ingrese NOMBRES, APELLIDOS o DNI" aria-label="Ingrese nombres" aria-describedby="basic-addon2" >
                                <button class="input-group-text btn-sm" id="basic-addon2" ><i class="fas fa-search"></i></button >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <h3>Resultados de busqueda</h3>
                                </div>
                            </div>
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">0</th>
                                        <td> Un profesor ...</td>
                                        <td> un dni111</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary btn-sm" ><i class="far fa-eye"></i> Ver accesos </button>
                                                <!-- <button type="button" class="btn btn-success btn-sm" ><i class="far fa-edit"></i> Editar</button> -->
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
    <script src="{{asset('js/reloj/index.js')}}"></script>
@endsection



