<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Cronograma de Pagos</title>
        <link rel="stylesheet" href="#">
        <style>
            body{
                font-size:0.7em;

            }
            .border {
                border: 1px solid black;
                text-align:center
            }
        </style>
    </head>
    <body style="font-family: sans-serif">
        <h2  style="text-align: center;margin-top: 175px">CRONOGRAMA DE PAGOS</h2>
        <table style="width: 100%; border: 1px solid black;" >
            <tr>
                <td style=" text-align:center"><b>AÑO:</b></td>
                <td style=" text-align:left">{{$anio}}</td>
            </tr>
            <tr>
                <td style=" text-align:center"><b>ALUMNO:</b></td>
                <td style=" text-align:left">{{$alumno->apellidos() . ', '. $alumno->nombres()}}</td>
            </tr>
        </table>
        <br><br>
        <table style="width: 100%">
            <tr>
                <th class="border"><b>Item</b></th>
                <th class="border">Concepto</th>
                <th class="border">Monto S/.</th>
                <th class="border">Fecha Vencimiento</th>
                <th class="border">Estado</th>
            </tr>
            @foreach ($cronogramas as $cronograma)
                <tr>
                    <td class="border">{{$cronograma->item}}</td>
                    <td class="border">{{$cronograma->concepto}}</td>
                    <td class="border">{{$cronograma->monto}}</td>
                    <td class="border">{{date('d-m-Y',strtotime($cronograma->fecha_vencimiento))}}</td>
                    <td class="border">{{$cronograma->estado}}</td>
                </tr>
            @endforeach
        </table>
        <h4><b>Observación</b></h4>
        <p>
            <i>
                Para constancia y fiel cumplimiento de todo lo estipulado, firmo el presente documento.
            </i>
        </p>
        <p style="text-align: right">CAJAMARCA, {{ $fecha_hoy->day . ' de '. $fecha_hoy->monthName . ' de ' . $fecha_hoy->year}} </p>

        <br><br><br>
        <table style="margin-left:50px ; width: 90%;">
            <tr>
                <td style="font-size:0.9em; text-align:center"><br><br><br><br>____________________________</td>
                <td style="font-size:0.9em; text-align:center"><br><br><br><br>____________________________</td>
            </tr>
            <tr>
                <td style="font-size:0.9em; text-align:center">Huella Digital</td>
                <td style="font-size:0.9em; text-align:center">Firma
                    <br>
                     {{$matricula->Patentesco->Apoderado->apellidos().', '.$matricula->Patentesco->Apoderado->nombres()}}
                     <br>
                     {{$matricula->Patentesco->Apoderado->dni()}}
                </td>
            </tr>
        </table>
        <p><b>Usuario:</b> {{$matricula->Usuario->nombres()}}</p>
    </body>
</html>
