<?php
header('Content-type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
header('Content-Disposition:attachment; filename=LISTA DE ALUMNOS MOROSOS.xls');
?>
<!DOCTYPE html>
<html lang="es" >
    <head>
        <meta charset="utf-8">
        <style>
            .border {
                border: 1px solid black;
                text-align:center
            }
        </style>
    </head>
    <body >
        <h1 style="text-align: center;">Lista de Alumnos Morosos</h1>
        @php
            $i = 0;
        @endphp
        <table style="width: 100%;">
            <thead>
              <tr>
                <th class="border" scope="col">#</th>
                <th class="border" scope="col">Cod. Matricula</th>
                <th class="border" scope="col">Alumno</th>
                <th class="border" scope="col">Aula / Nivel</th>
                <th class="border" scope="col">Estado Matrícula</th>
                <th class="border" scope="col">Concepto</th>
                <th class="border" scope="col">Monto</th>
                <th class="border" scope="col">Estado</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($alumnos as $alumno)
                    <tr >
                        <th class="border" scope="row">{{$i+1}}</th>
                        <th class="border" scope="row">{{$alumno->matricula_id}}</th>
                        <td class="border">{{$alumno->apellidos.', '.$alumno->nombres}}</td>
                        <td class="border">{{$alumno->aula.' - '.$alumno->nivel}}</td>
                        <td class="border">{{$alumno->estado_matricula}}</td>
                        <td class="border">{{$alumno->concepto}}</td>
                        <td class="border">S/ {{$alumno->saldo}} </td>
                        <td class="border">{{$alumno->estado}} </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="border" colspan="6"><b>Total</b></td>
                    <td class="border"><b>S/ {{$totalSaldo}}</b></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
