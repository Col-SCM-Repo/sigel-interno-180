@extends('reportes.pdf.rrhh.template')
@section('title','Reporte Alumnos')


@section('styles')
    <style>
        *{
            font-size: 14px;
        }
        footer{
            width: 80%;
            position: fixed; 
            border:  2px solid #030303; 
            bottom: 2.3cm; 
            left: 3cm; 
            text-align: center;
        }
        
        #img-header img{
            position: absolute;
            width: 6em;
            top: 2em;
            right: 10em;
        }

        .text-center{
            text-align: center;
        }

        table, tr, td, th{
            border: 1px solid #888;
        }
        .page_break {
            page-break-before: always;
        }
        .text-right{
            text-align: right;
        }
        .small{
            font-size:0.75rem;         }
    </style>

@endsection

@section('informacion_reporte')


<div>
    <table border="1" style=" width: 450px; text-align: center; padding: 1em; margin: auto; ">
        <tr>
            <th colspan="4" style="text-transform: uppercase" class="background_shadow">
                CONTROL DE ASISTENCIA
            </th>
        </tr>
        <tr>
            <td class="background_shadow" style="width: 100px;">NIVEL </td> 
            <td style="width: 90px; text-align: left; padding-left: .5rem;">  {{$nivel}}  </td>
            <td rowspan="3" class="background_shadow" style="width: 150px"> FECHA DEL REPORTE:</td>
            <td rowspan="3" style="text-transform: uppercase; text-align: center; padding-left: .5rem;" > 
                {{$fecha}}
            </td>
        </tr>
        <tr>
            <td class="background_shadow">GRADO</td>
            <td style="text-align: left; padding-left: .5rem;" class="text-center"> {{$grado}} </td>
        </tr>
        <tr>
            <td class="background_shadow">SECCION</td>
            <td style="text-align: left; padding-left: .5rem;" class="text-center"> {{$seccion}} </td>
        </tr>
        <tr>
            <td class="background_shadow">GENERADO POR:</td>
            <td colspan="3" style="text-transform: uppercase"> {{Auth::user()->USU_APELLIDOS.', '.Auth::user()->USU_NOMBRES  }}  </td>
        </tr>
    </table>
</div>
<br>
@endsection

@section('content')
<br>
<br>
<div style="border-top: 2px solid #888;  width: 100% " ></div>
<br>

<h3>Turno Mañana </h3>
<br>

<br>
<p class="text-right small"> Alumnos asistentes {{$asist_maniana}} de {{ count($alumnos_asistencia_maniana)}}   </p>
<br>

<table class="table table-striped table-sm table-light table-striped "  border="1" >
    <thead>
        <tr>
            <th style="width: 25px;">Nº</th>
            <th style="width: 70px;">Fecha</th>
            <th style="width: 70px;">Hora</th>
            <th style="width: 250px;">Nombre</th>
            <th style="width: 70px;">Estado</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody class="">
        @foreach ($alumnos_asistencia_maniana as $index=>$alumno)
                @if ($alumno->asistio)
                    <tr style="background: #E5F1E5;">
                        <td class="text-center" > {{ $index+1 }} </td>
                        <td class="text-center" > {{ $alumno->fecha  }} </td>
                        <td class="text-center" > {{ $alumno->hora  }} </td>
                        <td style="text-align: left"> {{ $alumno->nombre }} </td>
                        <td class="text-center"> ASISTIÓ </td>
                        <td style="background: white; height: 1.5rem;"></td>

                    </tr>
                @else
                    <tr style="background: #FBF5EB">
                        <td class="text-center" > {{ $index+1 }} </td>
                        <td class="text-center" > - </td>
                        <td class="text-center" > - </td>
                        <td style="text-align: left"> {{ $alumno->nombre }} </td>
                        <td class="text-center"> FALTA </td>
                        <td style="background: white; height: 1.5rem;"></td>

                    </tr>
                @endif 
        @endforeach
    </tbody>
</table>
<br>
<p style="width: 100%; text-align: right; font-size: 0.75em">Fecha de generacion del reporte: {{date("Y/m/d H:i:s a")}}</p>
<div class="page_break"></div>

<br>
<br>

<h3>Turno Tarde </h3>
<br>
<br>
<p class="text-right small"> Alumnos asistentes {{$asist_tarde}} de {{ count($alumnos_asistencia_tarde)}}   </p>
<br>

<table class="table table-striped table-sm table-light table-striped "  border="1" >
    <thead>
        <tr>
            <th style="width: 25px;">Nº</th>
            <th style="width: 70px;">Fecha</th>
            <th style="width: 70px;">Hora</th>
            <th style="width: 250px;">Nombre</th>
            <th style="width: 70px;">Estado</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody class="">
        @foreach ($alumnos_asistencia_tarde as $index=>$alumno)
                @if ($alumno->asistio)
                    <tr style="background: #E5F1E5;">
                        <td class="text-center" > {{ $index+1 }} </td>
                        <td class="text-center" > {{ $alumno->fecha  }} </td>
                        <td class="text-center" > {{ $alumno->hora  }} </td>
                        <td style="text-align: left"> {{ $alumno->nombre }} </td>
                        <td class="text-center"> ASISTIÓ </td>
                        <td style="background: white; height: 1.5rem;"></td>

                    </tr>
                @else
                    <tr style="background: #FBF5EB">
                        <td class="text-center" > {{ $index+1 }} </td>
                        <td class="text-center" > - </td>
                        <td class="text-center" > - </td>
                        <td style="text-align: left"> {{ $alumno->nombre }} </td>
                        <td class="text-center"> FALTA </td>
                        <td style="background: white; height: 1.5rem;"></td>
                    </tr>
                @endif 
        @endforeach
    </tbody>
</table>
<br>


<p style="width: 100%; text-align: right; font-size: 0.75em">Fecha de generacion del reporte: {{date("Y/m/d H:i:s a")}}</p>
@endsection


