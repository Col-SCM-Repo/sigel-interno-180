<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Cronograma de Pagos</title>
        <link rel="stylesheet" href="#">
        <style>
            body{
            }
            .border {
                border: 1px solid black;
                font-size:0.65em;
                text-align:center
            }
        </style>
    </head>
    <body style="font-family: sans-serif">

        <table style="width: 100%; margin-top: 175px">
            <tr>
                <td style="font-size:0.6em; text-align:center"><b>FECHA DE MATRICULA:</b></td>
                <td style="font-size:0.6em; text-align:left">{{date('d-m-Y H:i:s',strtotime($matricula->fecha()))}}</td>

                <td style="font-size:0.6em; text-align:center"><b>CODIGO:</b></td>
                <td style="font-size:0.6em; text-align:left">{{$matricula->id()}}</td>
            </tr>
        </table>
<br><br>
        <table style="margin-left:50px ;width: 100%">
            <tr>
                <td style="font-size:0.75em; text-align:left"><b>Apellidos y Nombres:</b></td>
                <td style="font-size:0.75em; text-align:left" colspan="3">{{$alumno->apellidos() . ', '. $alumno->nombres()}}</td>
            </tr>
            <tr>
                <td style="font-size:0.75em; text-align:left"><b>I.E. Procedencia:</b></td>
                <td style="font-size:0.75em; text-align:left" colspan="3">{{$matricula->IEProcedencia->nombre()}}</td>
            </tr>
            <tr>
                <td style="font-size:0.75em; text-align:left"><b>Nivel:</b></td>
                <td style="font-size:0.75em; text-align:left">{{$matricula->Vacante->Nivel->nivel()}}</td>
                <td style="font-size:0.75em; text-align:left"><b>Grado y Sección:</b></td>
                <td style="font-size:0.75em; text-align:left">{{$matricula->Vacante->Grado->grado()}}° {{$matricula->Vacante->Seccion->seccion()}}</td>
            </tr>
            <tr>
                <td style="font-size:0.75em; text-align:left"><b>Lugar de Nacimiento:</b></td>
                <td style="font-size:0.75em; text-align:left">{{$alumno->DistritoNacimiento->region()}} - {{$alumno->DistritoNacimiento->provincia()}} - {{$alumno->DistritoNacimiento->distrito()}} </td>
                <td style="font-size:0.75em; text-align:left"><b>F. de Nacimiento:</b></td>
                <td style="font-size:0.75em; text-align:left">{{date('d-m-Y',strtotime($alumno->fecha_nacimiento()))}}</td>
            </tr>
            <tr>
                <td style="font-size:0.75em; text-align:left"><b>DNI:</b></td>
                <td style="font-size:0.75em; text-align:left">{{$alumno->dni()}}</td>
                <td style="font-size:0.75em; text-align:left"><b>Sexo:</b></td>
                <td style="font-size:0.75em; text-align:left">{{$alumno->genero()=='F'?'FEMENINO':'MASCULINO'}}</td>
            </tr>
            <tr>
                <td style="font-size:0.75em; text-align:left"><b>Dirección:</b></td>
                <td style="font-size:0.75em; text-align:left" colspan="3">{{$alumno->direccion()}}</td>
            </tr>
            <tr>
                <td style="font-size:0.75em; text-align:left"><b>Teléfono:</b></td>
                <td style="font-size:0.75em; text-align:left">{{$alumno->telefono()}}</td>
                <td style="font-size:0.75em; text-align:left"><b>Celular:</b></td>
                <td style="font-size:0.75em; text-align:left">{{$alumno->celular()}}</td>
            </tr>
        </table>
        <br><br><br>
        <table style="margin-left:50px ;width: 100%">
            <tr>
                <th class="border"></th>
                <th class="border">Padre</th>
                <th class="border">Madre</th>
                <th class="border">Apoderado ({{$responsable->relacion}})</th>
            </tr>
            <tr>
                <td class="border"><b>Apellidos</b></td>
                <td class="border">{{$padre->apellidos}}</td>
                <td class="border">{{$madre->apellidos}}</td>
                <td class="border">{{$responsable->apellidos}}</td>
            </tr>
            <tr>
                <td class="border"><b>Nombres</b></td>
                <td class="border">{{$padre->nombres}}</td>
                <td class="border">{{$madre->nombres}}</td>
                <td class="border">{{$responsable->nombres}}</td>
            </tr>
            <tr>
                <td class="border"><b>DNI</b></td>
                <td class="border">{{$padre->dni}}</td>
                <td class="border">{{$madre->dni}}</td>
                <td class="border">{{$responsable->dni}}</td>
            </tr>
            <tr>
                <td class="border"><b>Grado Inst</b></td>
                <td class="border">{{$padre->grado_instruccion}}</td>
                <td class="border">{{$madre->grado_instruccion}}</td>
                <td class="border">{{$responsable->grado_instruccion}}</td>
            </tr>
            <tr>
                <td class="border"><b>Ocupación</b></td>
                <td class="border">{{$padre->ocupacion}}</td>
                <td class="border">{{$madre->ocupacion}}</td>
                <td class="border">{{$responsable->ocupacion}}</td>
            </tr>
            <tr>
                <td class="border"><b>Centro Lab</b></td>
                <td class="border">{{$padre->centro_laboral}}</td>
                <td class="border">{{$madre->centro_laboral}}</td>
                <td class="border">{{$responsable->centro_laboral}}</td>
            </tr>
            <tr>
                <td class="border"><b>Fecha Nac</b></td>
                <td class="border">{{$padre->fecha_nacimiento}}</td>
                <td class="border">{{$madre->fecha_nacimiento}}</td>
                <td class="border">{{$responsable->fecha_nacimiento}}</td>
            </tr>
            <tr>
                <td class="border"><b>Estado Civil</b></td>
                <td class="border">{{$padre->estado_civil}}</td>
                <td class="border">{{$madre->estado_civil}}</td>
                <td class="border">{{$responsable->estado_civil}}</td>
            </tr>
            <tr>
                <td class="border"><b>Dirección</b></td>
                <td class="border">{{$padre->direccion}}</td>
                <td class="border">{{$madre->direccion}}</td>
                <td class="border">{{$responsable->direccion}}</td>
            </tr>
            <tr>
                <td class="border"><b>Telefono</b></td>
                <td class="border">{{$padre->telefono}}</td>
                <td class="border">{{$madre->telefono}}</td>
                <td class="border">{{$responsable->telefono}}</td>
            </tr>
            <tr>
                <td class="border"><b>Celular</b></td>
                <td class="border">{{$padre->celular}}</td>
                <td class="border">{{$madre->celular}}</td>
                <td class="border">{{$responsable->celular}}</td>
            </tr>
        </table>
    </body>
</html>
