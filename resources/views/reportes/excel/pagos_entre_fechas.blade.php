<?php
header('Content-type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
header('Content-Disposition:attachment; filename=PAGOS DE LAS FECHAS '. $fecha_inicial.' - '.$fecha_final . '.xls');
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
        PAGOS DE LAS FECHAS {{$fecha_inicial}}  - {{$fecha_final}}
    </h1>
    <table class="table table-striped">
        <thead>
            <tr>
              <th class="border" scope="col">#</th>
              <th class="border" scope="col">Fecha</th>
              <th class="border" scope="col">Concepto</th>
              <th class="border" scope="col">Alumno</th>
              <th class="border" scope="col">Tipo Comprobante</th>
              <th class="border" scope="col">Serie</th>
              <th class="border" scope="col">Numero</th>
              <th class="border" scope="col">Monto</th>
              <th class="border" scope="col">Usuario</th>
            </tr>
          </thead>
          <tbody>
              @php
                  $total = 0;
                  $i=0;
              @endphp
              @foreach ($pagos as $pago)
                  <tr >
                      <th class="border" scope="row">{{$i+1}}</th>
                      <td class="border" >{{$pago['fecha']}}</td>
                      <td class="border" >{{$pago['concepto']}}</td>
                      <td class="border" >{{$pago['alumno']}}</td>
                      <td class="border" >{{$pago['tipo']}}</td>
                      <td class="border" >{{$pago['serie']}}</td>
                      <td class="border" >{{$pago['numero']}}</td>
                      <td class="border" >S/{{$pago['monto']}}</td>
                      <td class="border" >{{$pago['usuario']}}</td>
                  </tr>
                  @php
                      $total += $pago['monto'];
                      $i++;
                  @endphp
              @endforeach
          </tbody>
          <tfoot>
              <tr style="background: #ececec">
                  <td class="border" colspan="7">
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

