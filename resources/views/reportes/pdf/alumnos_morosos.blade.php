<!DOCTYPE html>
<html lang="es" >
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
        <h1 style="text-align: center;">Lista de Alumnos Morosos</h1>
        <table style="width: 100%;">
            <thead>
              <tr>
                <th class="border" scope="col">Cod. Matricula</th>
                <th class="border" scope="col">Alumno</th>
                <th class="border" scope="col">Aula / Nivel</th>
                <th class="border" scope="col">Concepto</th>
                <th class="border" scope="col">Monto</th>
                <th class="border" scope="col">Estado</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($alumnos as $alumno)
                    <tr >
                        <th class="border" scope="row">{{$alumno['matricula_id']}}</th>
                        <td class="border">{{$alumno['apellidos'].', '.$alumno['nombres']}}</td>
                        <td class="border">{{$alumno['aula'].' - '.$alumno['nivel']}}</td>
                        <td class="border">{{$alumno['concepto']}}</td>
                        <td class="border">{{$alumno['monto']}} </td>
                        <td class="border">{{$alumno['estado']}} </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="border" colspan="4"><b>Total</b></td>
                    <td class="border"><b>{{$total_monto}}</b></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
