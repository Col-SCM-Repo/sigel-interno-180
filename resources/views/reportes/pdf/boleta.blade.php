<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Boleta Electronica</title>
        <link rel="stylesheet" href="#">
    </head>
    <body style="font-family: sans-serif;margin-left:-30px;padding: 0; margin-top: -50px">
        <table>
            <tr>
                <td  style="font-size:0.55em; text-align:center" colspan="2">COMPLEJO EDUCATIVO CABRERA E.I.R.L</td>
            </tr>
            <tr>
                <td  style="font-size:0.55em; text-align:center" colspan="2">
                    RUC: 20453661971
                </td>
            </tr>
            <tr>
                <td  style="font-size:0.55em; text-align:center" colspan="2">
                    Jr. Los Próceres 309 <br>
                    Jr. San Martín 239 (ANEXO)
                </td>
            </tr>
            <tr>
                <td  style="font-size:0.55em; text-align:center" colspan="2">
                    Cajamarca - Cajamarca - Cajamarca
                </td>
            </tr>
            <tr>
                <td  style="font-size:0.55em; text-align:center" colspan="2">
                    Cel. 901 616 164 - 945 831 251
                </td>
            </tr>
            <tr>
                <td  style="font-size:0.55em; text-align:center" colspan="2">
                    <a href="http://www.colegiocabrera.edu.pe/">www.colegiocabrera.edu.pe</a>
                </td>
            </tr>
            <tr>
                <td  style="font-size:0.9em; text-align:center" colspan="2">
                    ---------------------------------------------
                </td>
            </tr>
        </table>
        <table >
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Boleta Electrónica:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{$pago->serie()}} -  {{$pago->numero()}}</td>
            </tr>
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Matrícula:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{$pago->Matricula->id()}} </td>
            </tr>
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Apellidos:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{$pago->Matricula->Alumno->apellidos()}} </td>
            </tr>
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Nombres:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{$pago->Matricula->Alumno->nombres()}} </td>
            </tr>
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Concepto:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">
                    {{$pago->ConceptoPago?$pago->ConceptoPago->Concepto->concepto():$pago->CronogramaPago->ConceptoPago->Concepto->concepto()}}
                    -
                    {{$pago->Matricula->Vacante->Grado->grado()}} °
                    {{$pago->Matricula->Vacante->Seccion->seccion()}}
                    {{$pago->Matricula->Vacante->Nivel->nivel()}}

                </td>
            </tr>
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Importe:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">S/ {{ number_format($pago->monto(),2)}} </td>
            </tr>
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Fecha:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{date('d/m/Y H:i:s',strtotime($pago->fecha()))}} </td>
            </tr>
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Usuario:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{$pago->Usuario->nombres()}} </td>
            </tr>
            <tr>
                <td width="60%" style="font-size:0.55em; text-align:center" colspan="2">
                    Representación impresa del Comprobante de
                    Venta <br> Electrónica, esta puede ser consultada
                    y descargada <br> desde nuestro portal Institucional <br>
                    <a href="http://www.colegiocabrera.edu.pe/">www.colegiocabrera.edu.pe</a>
                </td>
            </tr>
            <tr>
                <td  style="font-size:0.9em; text-align:center" colspan="2">
                    ---------------------------------------------
                </td>
            </tr>
            <tr>
                <td style="font-size:0.55em; text-align:center" colspan="2">
                    Fecha de consulta: {{date('Y-m-d H:i:s')}}
                </td>
            </tr>
        </table>
        <br>

    </body>
</html>
