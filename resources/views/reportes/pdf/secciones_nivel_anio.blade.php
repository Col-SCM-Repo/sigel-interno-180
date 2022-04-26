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
        <h1 style="text-align: center;">Lista de Secciones de {{$nivel->nivel}} - {{$anio->nombre}}</h1>
        <h3 style="text-align: center;">Total de alumnos matriculados en {{$nivel->nivel}} : {{$vacantes_ocupadas}}</h3>

        <table style="width: 100%;">
            <thead>
              <tr>
                <th scope="col">Nivel - Grado - Seccion</th>
                <th scope="col">Total Vacantes</th>
                <th scope="col">Vacantes Disponibles</th>
                <th scope="col">Vacantes Ocupadas</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($aulas as $aula)
                    @if ($aula->vacantes_ocupadas>0)
                        <tr >
                            <td class="border">{{$aula->nombre_completo}}</td>
                            <td class="border">{{$aula->total_vacantes}}</td>
                            <td class="border">{{$aula->vacantes_disponibles}}</td>
                            <td class="border"><b>{{$aula->vacantes_ocupadas}}</b></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="border"><b>Total</b></td>
                    <td class="border"><b>{{$total_vacantes}}</b></td>
                    <td class="border"><b>{{$vacantes_disponibles}}</b></td>
                    <td class="border"><b>{{$vacantes_ocupadas}}</b></td>
                </tr>
            </tfoot>
        </table>
        <p style="text-align: right;"><b>Fecha de consulta:</b>  {{date('d/m/Y H:i:s')}}</p>
    </body>
</html>
