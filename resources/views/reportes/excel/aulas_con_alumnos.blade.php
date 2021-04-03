<?php
header('Content-type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
header('Content-Disposition:attachment; filename=LISTA DE ALUMNOS DE '. $seccion.' - '.$anio . '.xls');
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
       LISTA DE ALUMNOS DE {{$seccion}} - {{$anio}}
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
            @foreach ($alumnos as $alumno)
                <tr >
                    <th class="border" scope="row">{{$alumno['matricula_id']}}</th>
                    <td class="border" >{{$alumno['nombres']}}</td>
                    <td class="border" >{{$alumno['dni']}}</td>
                    <td class="border" >{{$alumno['apoderado']['nombres']}}</td>
                    <td class="border" >{{$alumno['apoderado']['celular']}} / {{$alumno['apoderado']['telefono']}}</td>
                    <td class="border" >{{$alumno['direccion']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

