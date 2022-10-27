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
                <td  style="font-size:0.6em; text-align:center" colspan="2">
                    www.colegiocabrera.edu.pe
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
                    {{number_format($pago->monto(),2)<=0?'Nota de Credito':(substr($pago->serie(),0,1)=='E'?'Factura Electrónica':'Boleta Electrónica')}} :
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{$pago->serie()}} -  {{$pago->numero()}}</td>
            </tr>
            @if ( substr($pago->serie(),0,1)=='E'  )
                <tr>
                    <td width="40%" style="font-size:0.55em; text-align:left">
                        RUC:
                    </td>
                    <td width="60%" style="font-size:0.55em; text-align:left">{{$pago->MP_RUC}} </td>
                </tr>
                <tr>
                    <td width="40%" style="font-size:0.55em; text-align:left">
                        Razón social:
                    </td>
                    <td width="60%" style="font-size:0.55em; text-align:left">{{$pago->MP_RAZON_SOCIAL}} </td>
                </tr>
            @endif
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Matrícula:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{$pago->Matricula->id()}} </td>
            </tr>
            @php
                $responsable_pago = $pago->ResponsablePago;
                if($responsable_pago){
                    $apellidos_responsable = $responsable_pago->apellidos();
                    $nombres_responsable = $responsable_pago->nombres();
                    $dni_responsable = $responsable_pago->MP_APO_NRODOC ;
                }
                else{
                    $apellidos_responsable = $pago->Matricula->Alumno->apellidos();
                    $nombres_responsable = $pago->Matricula->Alumno->nombres();
                    $dni_responsable = $pago->Matricula->Alumno->MP_ALU_DNI ;
                }
            @endphp
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Responsable Pago:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{$apellidos_responsable.', '.$nombres_responsable}} </td>
            </tr>
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    DNI:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{$dni_responsable}} </td>
            </tr>
            <tr>
                <td width="40%" style="font-size:0.55em; text-align:left">
                    Alumno:
                </td>
                <td width="60%" style="font-size:0.55em; text-align:left">{{$pago->Matricula->Alumno->apellidos().', '.$pago->Matricula->Alumno->nombres()}} </td>
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
                    Fecha Emisión:
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
                <td width="60%" style="font-size:0.6em; text-align:center" colspan="2">
                    Representación impresa del Comprobante de
                    Venta <br> Electrónica, esta puede ser consultada
                    y descargada <br> desde nuestro portal Institucional <br>
                    www.colegiocabrera.edu.pe
                </td>
            </tr>
            <tr>
                <td  style="font-size:0.9em; text-align:center" colspan="2">
                    ---------------------------------------------
                </td>
            </tr>
            <tr>
                <td style="font-size:0.55em; text-align:center" colspan="2">
                    Fecha de consulta: {{date('d/m/Y H:i:s')}}
                </td>
            </tr>
        </table>
    </body>
</html>
