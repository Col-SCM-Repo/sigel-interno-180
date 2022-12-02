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
                    <div style="flex-grow: 1">INFORMACIÓN CODIGOS DE PLANTILLAS </div>
                </div>
                <div class="card-body">
                    <div class="container">

                        <table class="table table-sm table-hover table-striped table-bordered">
                            <thead class="bg-info">
                                <tr class="">
                                    <th scope="col" class="text-center text-uppercase">MODULO</th>
                                    <th scope="col" class="text-center text-uppercase">CAMPO</th>
                                    <th scope="col" class="text-center text-uppercase">VARIABLE</th>
                                    <th scope="col" class="text-center text-uppercase">DESCRIPCIÓN</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $nombre_modulo=>$data_modulo)
                                            @php
                                                $numeroFilas = 1+count($data_modulo);
                                                foreach ($data_modulo as $campo) $numeroFilas+= count($campo);
                                            @endphp

                                            <tr >
                                                <td scope="row" rowspan="{{$numeroFilas}}" class="pt-0 pb-0 table-primary text-uppercase text-center"> {{ $nombre_modulo }} </td>
                                            </tr>

                                                @foreach ($data_modulo as $campo=>$atributos_array)
                                                <tr>
                                                    <td rowspan="{{ count($atributos_array)+1 }}" class="pt-0 pb-0 table-success text-uppercase"> {{$campo}}  </td>
                                                </tr>

                                                            @foreach ($atributos_array as $nombre_atr => $descripcion_atr)
                                                            <tr>
                                                                <td class="pt-0 pb-0 table-warning" > {{ $nombre_atr }}</td>
                                                                <td class="pt-0 pb-0 table-warning" > {{ $descripcion_atr }}</td>
                                                            </tr>
                                                    @endforeach
                                                @endforeach

                                        @endforeach


                                    @else
                                        <tr>
                                            <td class="text-center">
                                                No se encontró información
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>




                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@endsection

