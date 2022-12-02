@extends('layouts.app')
@section('titulo',"SIGEL")

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">MENU LOGISTICA</div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">

                            <div class="col-sm-6 col-md-4">
                                <div class="card bg-light" >
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Pendiente ..</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-auto">
                                                <i class="fas fa-file-word fa-5x  "></i>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-file-pdf fa-5x "></i>
                                            </div>
                                        </div>
                                        <br>
                                        <a href="" type="button" class="btn btn-primary btn-block">
                                            <i class="fas fa-sign-in-alt"></i> Ingresar
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4">
                                <div class="card bg-light" >
                                    <div class="card-body">
                                        <h5 class="card-title text-center"> Materiales </h5>
                                        <div class="row justify-content-center">
                                            <div class="col-auto">
                                                <i class="fas fa-dolly fa-5x  "></i>
                                            </div>
                                        </div>
                                        <br>
                                        <a href="" type="button" class="btn btn-success btn-block disabled">
                                            <i class="fas fa-sign-in-alt"></i> Ingresar
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4">
                                <div class="card bg-light" >
                                    <div class="card-body">
                                        <h5 class="card-title text-center"> OTROS </h5>
                                        <div class="row justify-content-center">
                                            <div class="col-auto">
                                                <i class="fa fa-truck fa-5x" aria-hidden="true"></i>
                                            </div>

                                        </div>
                                        <br>
                                        <a href="" type="button" class="btn btn-dark btn-block disabled" >
                                            <i class="fas fa-sign-in-alt"></i> Ingresar
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                       {{--  <br>
                        <div class="row ">

                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
