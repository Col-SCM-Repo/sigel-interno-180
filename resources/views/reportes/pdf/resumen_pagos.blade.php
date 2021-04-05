<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body{
                font-size: 0.8em;
            }
        </style>
    </head>
    <body>
        <h1  style="margin-top: -30px;">
            PAGOS DEL DÍA
        </h1>
        <h2 >
            <strong>Fecha:</strong> {{date('d/m/Y',strtotime($fecha))}}
        </h2>
        <h2 >
            <strong>Cajero:</strong> {{Auth::user()->nombres()}}
        </h2>
        <h2 >
            <strong>Total:</strong> S/ {{number_format($total, 2, '.', ' ')}}
        </h2>
        <h2 style="color: red" >
            <strong>Nro. Tickects:</strong> {{$cant}}
        </h2>
    </body>
</html>

