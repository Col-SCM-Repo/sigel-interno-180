<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Secciones por Anio y Nivel</title>
        <link rel="stylesheet" href="#">
        <style>
            .border {
                border: 1px solid black;
                text-align:center
            }
        </style>
    </head>
    <body >
        <h1 style="text-align: center;">Lista de Secciones de {{$nivel}} - {{$anio}}</h1>
        <h3 style="text-align: center;">Total de alumnos matriculados en {{$nivel}} : {{$vacantes_ocupadas}}</h3>

        <table style="width: 100%;">
            <thead>
              <tr>
                <th class="border" scope="col">Grado</th>
                <th class="border" scope="col">Seccion</th>
                <th class="border" scope="col">Total Vacantes</th>
                <th class="border" scope="col">Vacantes Disponibles</th>
                <th class="border" scope="col">Vacantes Ocupadas</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($secciones as $seccion)
                    <tr >
                        <td class="border">{{$seccion['grado']}}</td>
                        <td class="border">{{$seccion['seccion']}}</td>
                        <td class="border">{{$seccion['total_vacantes']}}</td>
                        <td class="border">{{$seccion['vacantes_disponibles']}}</td>
                        <td class="border"><b>{{$seccion['vacantes_ocupadas']}}</b></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="border" colspan="2"><b>Total</b></td>
                    <td class="border"><b>{{$total_vacantes}}</b></td>
                    <td class="border"><b>{{$vacantes_disponibles}}</b></td>
                    <td class="border"><b>{{$vacantes_ocupadas}}</b></td>
                </tr>
            </tfoot>
        </table>
        <p style="text-align: right;"><b>Fecha de consulta:</b>  {{date('d/m/Y H:i:s')}}</p>
    </body>
</html>
