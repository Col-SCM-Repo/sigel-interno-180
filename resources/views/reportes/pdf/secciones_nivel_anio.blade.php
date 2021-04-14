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
        <h3 style="text-align: center;">Lista de Secciones de {{$nivel}} - {{$anio}}</h3>
        @php
            $total_vacante = 0;
            $vacantes_ocupadas =0;
            $vacantes_disponibles = 0;
        @endphp
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
                    @php
                        $total_vacante += $seccion['total_vacantes'];
                        $vacantes_ocupadas +=   $seccion['vacantes_ocupadas'];
                        $vacantes_disponibles += $seccion['vacantes_disponibles'];
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="border" colspan="2"><b>Total</b></td>
                    <td class="border"><b>{{$total_vacante}}</b></td>
                    <td class="border"><b>{{$vacantes_disponibles}}</b></td>
                    <td class="border"><b>{{$vacantes_ocupadas}}</b></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
