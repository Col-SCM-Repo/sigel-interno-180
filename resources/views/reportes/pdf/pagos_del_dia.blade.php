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
        PAGOS DEL {{$fecha}}
    </h1>
    <h2>
        <strong>Usuario:</strong> {{Auth::user()->nombres()}}
    </h2>
    <table class="table table-striped">
        <thead>
          <tr>
            <th class="border" scope="col">#</th>
            <th class="border" scope="col">Fecha</th>
            <th class="border" scope="col">Número</th>
            <th class="border" scope="col">Observación</th>
            <th class="border" scope="col">Monto</th>
          </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $i=0;
            @endphp
            @foreach ($pagos as $pago)
                <tr >
                    <th class="border">{{$i+1}}</th>
                    <td class="border" >{{$pago['fecha']}}</td>
                    <td class="border" >{{$pago['numero']}}</td>
                    <td class="border" >{{$pago['observacion']}}</td>
                    <td class="border" >S/ {{$pago['monto']}}</td>
                </tr>
                @php
                    $total += $pago['monto'];
                    $i++;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: #ececec">
                <td class="border" colspan="4">
                    Total
                </td>
                <td class="border">
                   S/ {{$total}}
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

