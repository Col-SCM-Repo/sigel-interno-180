<?php
header('Content-type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
header('Content-Disposition:attachment; filename=LISTA DE ALUMNOS DE '. $vacante->nivel->nivel .' - '. $vacante->grado->grado.'° '. $vacante->seccion->seccion.' - '.$vacante->anio->nombre . '.xls');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        .border{
            border: 1px #000 solid;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">
       LISTA DE ALUMNOS DE {{$vacante->nivel->nivel .' - '. $vacante->grado->grado.'° '. $vacante->seccion->seccion.' - '.$vacante->anio->nombre}}
    </h1>
    <table class="table table-striped">
        <thead>
          <tr>
            <th class="border" scope="col">Cod. Matrícula</th>
            <th class="border" scope="col">Alumno</th>
            <th class="border" scope="col">DNI</th>
            <th class="border" scope="col">Apoderado</th>
            <th class="border" scope="col">Cel. / Telf. Apoderado</th>
            <th class="border" scope="col">Dirección Alumno</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($matriculas as $matricula)
                <tr >
                    <th class="border" scope="row">{{$matricula->id}}</th>
                    <td class="border" >{{$matricula->nombres_alumno}}</td>
                    <td class="border" >{{$matricula->alumno->dni}}</td>
                    <td class="border" >{{$matricula->pariente->apellidos .', ' .$matricula->pariente->nombres}}</td>
                    <td class="border" >{{$matricula->pariente->celular}} / {{$matricula->pariente->telefono}}</td>
                    <td class="border" >{{$matricula->alumno->direccion}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

