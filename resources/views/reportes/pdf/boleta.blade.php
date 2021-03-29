<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Boleta Electronica</title>
        <link rel="stylesheet" href="#">
    </head>
    <body style="font-family: sans-serif">
        <table width="100%">
            <tr>
                <td width="30%" style="font-size:0.55em; text-align:center" colspan="2">COMPLEJO EDUCATIVO CABRERA E.I.R.L</td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="30%" style="font-size:0.55em; text-align:center" colspan="2">
                    RUC: 20453661971
                </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="30%" style="font-size:0.55em; text-align:center" colspan="2">
                    Jr. Los Próceres 309 <br>
                    Jr. San Martín 239 (ANEXO)
                </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="30%" style="font-size:0.55em; text-align:center" colspan="2">
                    Cajamarca - Cajamarca - Cajamarca
                </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="30%" style="font-size:0.55em; text-align:center" colspan="2">
                    Telf. 364459 - 364761
                </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="30%" style="font-size:0.55em; text-align:center" colspan="2">
                    <a href="http://www.colegiocabrera.edu.pe/">www.colegiocabrera.edu.pe</a>
                </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="30%" style="font-size:0.9em; text-align:center" colspan="2">
                    ---------------------------------------------
                </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="10%" style="font-size:0.55em; text-align:left">
                    Boleta Electrónica:
                </td>
                <td width="20%" style="font-size:0.55em; text-align:left">{{$pago->serie()}} -  {{$pago->numero()}}</td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="10%" style="font-size:0.55em; text-align:left">
                    Matrícula:
                </td>
                <td width="20%" style="font-size:0.55em; text-align:left">{{$pago->Matricula->id()}} </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="10%" style="font-size:0.55em; text-align:left">
                    Apellidos:
                </td>
                <td width="20%" style="font-size:0.55em; text-align:left">{{$pago->Matricula->Alumno->apellidos()}} </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="10%" style="font-size:0.55em; text-align:left">
                    Nombres:
                </td>
                <td width="20%" style="font-size:0.55em; text-align:left">{{$pago->Matricula->Alumno->nombres()}} </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="10%" style="font-size:0.55em; text-align:left">
                    Concepto:
                </td>
                <td width="20%" style="font-size:0.55em; text-align:left">
                    {{$pago->CronogramaPago->ConceptoPago->Concepto->concepto()}}
                    -
                    {{$pago->Matricula->Vacante->Grado->grado()}} °
                    {{$pago->Matricula->Vacante->Seccion->seccion()}}
                    {{$pago->Matricula->Vacante->Nivel->nivel()}}

                </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="10%" style="font-size:0.55em; text-align:left">
                    Importe:
                </td>
                <td width="20%" style="font-size:0.55em; text-align:left">S/ {{ number_format($pago->monto(),2)}} </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="10%" style="font-size:0.55em; text-align:left">
                    Fecha:
                </td>
                <td width="20%" style="font-size:0.55em; text-align:left">{{$pago->fecha()}} </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="20%" style="font-size:0.55em; text-align:center" colspan="2">
                    Representación impresa del Comprobante de
                    Venta Electrónica, esta puede ser consultada
                    y descargada desde nuestro portal Institucional <br>
                    <a href="http://www.colegiocabrera.edu.pe/">www.colegiocabrera.edu.pe</a>
                </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="30%" style="font-size:0.9em; text-align:center" colspan="2">
                    ---------------------------------------------
                </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
            <tr>
                <td width="30%" style="font-size:0.4em; text-align:center" colspan="2">
                    Fecha de consulta: {{date('Y-m-d H:i:s')}}
                </td>
                <td style="font-size:0.8em; text-align:center"></td>
            </tr>
        </table>
        <br>

    </body>
</html>
