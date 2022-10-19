<?php
header("Content-type:   application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body{
            padding: 20px;
        }
        td{
            padding: 80px 10px;
        }

        *{
            font-size: 20px;
        }

        .text-uppercase{
            text-transform: uppercase
        }

        .text-center{
            text-align: center
        }

        .text-right{
            text-align: right
        }

        .bold{
            font-weight: 900;
        }
    </style>
</head>
<body>
        
<table>
    <tr>
        <th></th>
        <th colspan="2" class="text-center"><h3>REPORTE DE MARCACIÓN</h3></th>
    </tr>
    <tr>
        <td></td>
        <td colspan="2" class="text-right bold"><strong>PERSONAL:</strong>  {{ $data->personal->nombre }}</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2" class="text-right bold"><strong>DEPARTAMENTO:</strong>  {{ $data->personal->departamento }}</td>
    </tr>
    <tr>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">
            <table border="1" style="border-collapse: collapse; #333">
                <thead >
                    <tr>
                        <th colspan="5" class="text-center" style="background: #3CE">
                            REPORTE DE MARCACIONES
                        </th>
                    </tr>
                    <tr>
                        <th style="background: #3CE" class="text-uppercase text-center" >Dia</th>
                        <th style="background: #3CE" class="text-uppercase text-center" >Turno</th>
                        <th style="background: #3CE" class="text-uppercase text-center" >Fecha</th>
                        <th style="background: #3CE" class="text-uppercase text-center" >Hora</th>
                        <th style="background: #3CE" class="text-uppercase text-center" >Local</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data->marcaciones)>0)
                        @foreach ($data->marcaciones as $marcacion)
                            <tr>
                                <td> {{ $marcacion->nDia }} </td>
                                <td> {{ $marcacion->nTurno }} </td>
                                <td> {{ $marcacion->nFecha }} </td>
                                <td> {{ $marcacion->nHora }} </td>
                                <td> {{ $marcacion->nLocal }} </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" rowspan="3"> No se encontro marcaciones</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td></td>
        <td></td>
        <td>Fecha de reporte: {{date("Y/m/d H:i:s a")}}</td>
    </tr>

</table>




</body>
</html>

