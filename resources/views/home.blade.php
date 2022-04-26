@extends('layouts.app')
@section('titulo',"SIGEL")
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <div class="container">
                        @if (Auth::user()->USU_CARGO != 'AUXILIAR')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-light" >
                                        <div class="card-body">
                                            <h5 class="card-title text-center">Pagos y Matrículas</h5>
                                            <div class="row justify-content-center">
                                                <div class="col-auto">
                                                    <i class="fas fa-receipt fa-5x" ></i>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-file-alt fa-5x"></i>
                                                </div>
                                            </div>
                                            <br>
                                            <a href="{{route('index.alumnos')}}" type="button" class="btn btn-primary btn-block">
                                                <i class="fas fa-sign-in-alt"></i> Ingresar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light" >
                                        <div class="card-body">
                                            <h5 class="card-title text-center">Notas Academicas</h5>
                                            <div class="row justify-content-center">
                                                <div class="col-auto">
                                                    <i class="fas fa-file-alt fa-5x"></i>
                                                </div>
                                            </div>
                                            <br>
                                            <a href="{{route('index.alumno.modulo_notas')}}" type="button" class="btn btn-success btn-block">
                                                <i class="fas fa-sign-in-alt"></i> Ingresar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <h3>Proximamente ...</h3>
                        @endif
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="card bg-light" >
                                    <div class="card-body">
                                        <h5 class="card-title text-center">RR. HH.</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-5x"></i>
                                            </div>

                                        </div>
                                        <br>
                                        <a href="{{ Auth::user()->USU_CARGO != 'AUXILIAR'? route('rrhh.index') : route('rrhh.alumnos')}}" type="button" class="btn btn-dark btn-block" >
                                            <i class="fas fa-sign-in-alt"></i> Ingresar
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->USU_CARGO != 'AUXILIAR')
                                <div class="col-md-6">
                                    <div class="card bg-light" >
                                        <div class="card-body">
                                            <h5 class="card-title text-center">Logistica</h5>
                                            <div class="row justify-content-center">
                                                <div class="col-auto">
                                                    <i class="fas fa-boxes fa-5x"></i>
                                                </div>
                                            </div>
                                            <br>
                                            <a href="#" type="button" class="btn btn-info btn-block text-white disabled" >
                                                <i class="fas fa-sign-in-alt"></i> Ingresar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
