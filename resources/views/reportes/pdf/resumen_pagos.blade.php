<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body{
                font-size: 0.6em;
                text-align: center;
                margin-left: -170px;
            }
        </style>
    </head>
    <body>
        <h1  style="margin-top: 35px;">
            PAGOS DEL DÍA
        </h1>
        <h2 >
            <strong>Fecha:</strong> {{date('d/m/Y',strtotime($fecha))}}
        </h2>
        <h2 >
            <strong>Cajero:</strong> {{Auth::user()->nombres()}}
        </h2>
        <h2 >
            <strong>Total Efectivo:</strong> S/ {{number_format($total_efectivo, 2, '.', ' ')}}
        </h2>
        <h2 >
            <strong>Total Deposito:</strong> S/ {{number_format($total_deposito, 2, '.', ' ')}}
        </h2>
        <h2 >
            <strong>Total:</strong> S/ {{number_format(($total_deposito + $total_efectivo), 2, '.', ' ')}}
        </h2>
        <h2 >
            <strong>Nro. Tickects:</strong> {{$cant}}
        </h2>
    </body>
</html>
