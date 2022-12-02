<?php
namespace App\Structure\Services\EmisionPagos;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BoletaElectronica extends GeneradorXML
{
    protected function crearItemBoleta( $numero_item, $codigo, $descripcion, $precio_unitario, $unidades, &$monto_total ){
        $costo_item = $precio_unitario*$unidades;
        $monto_total += $costo_item;
        return
        // cac:InvoiceLine (Datos del detalle o Ítem de la Boleta)
        self::crearNodo('cac:InvoiceLine', [], [
            self::crearNodo('cbc:ID', [], $numero_item),                 // Secuencial (numero - item)  Número de orden del Ítem
            self::crearNodo('cbc:Note', [], 'UNIDAD'),        //  (Descripción de la unidad)
            self::crearNodo('cbc:InvoicedQuantity', ['unitCode'=>'ZZ','unitCodeListAgencyName'=>'United Nations Economic Commission for Europe','unitCodeListID'=>'UN/ECE rec 20'], $unidades), // @unitCode (Codigo unidad de medida del ítem)        (Cantidad del item)                    UNIDADES
            self::crearNodo('cbc:LineExtensionAmount', ['currencyID'=>'PEN'], number_format(  $costo_item, 2, '.', '') ),   //  @currencyID (Valor de venta del ítem y Moneda),  ' Valor referencial unitario por ítem' * ' Cantidad del ítem' - ' Monto descuento del ítem (Código 00)' + ' Monto cargo del ítem (Código 47)' ].
            self::crearNodo('cac:PricingReference', [],       //  Precio de venta unitario del ítem
                self::crearNodo('cac:AlternativeConditionPrice', [], [
                    self::crearNodo('cbc:PriceAmount', ['currencyID'=>'PEN'], number_format($precio_unitario, 2,'.', '')),       //(Precio de venta unitario del ítem y Moneda)
                    self::crearNodo('cbc:PriceTypeCode', ['listAgencyName'=>'PE:SUNAT','listName'=>'Tipo de Precio','listURI'=>'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16'], '01') //  (Código de precio)
                ])
            ),
            self::crearNodo('cac:TaxTotal', [], [             // Monto total impuestos del ítem 'Monto del IGV o IVAP del ítem' con código de tributo '1000' o '1016' + 'Monto ISC del ítem' + 'Monto Otros tributos del ítem' + 'Monto ICBPER del ítem'
                self::crearNodo('cbc:TaxAmount', ['currencyID'=>'PEN'], '0.00'),          //  (Monto total impuestos del ítem y Moneda)
                self::crearNodo('cac:TaxSubtotal', [], [
                    self::crearNodo('cbc:TaxableAmount', ['currencyID'=>'PEN'], number_format($precio_unitario*$unidades,2,'.', '')), // (Monto base IGV o IVAP del itemy Moneda)
                    self::crearNodo('cbc:TaxAmount', ['currencyID'=>'PEN'], '0.00'),      // (Monto del IGV o IVAP del ítem y Moneda)
                    self::crearNodo('cac:TaxCategory', [], [
                        self::crearNodo('cbc:Percent', [], '0.00'),                       // (Porcentaje IGV o IVAP del item
                        self::crearNodo('cbc:TaxExemptionReasonCode', ['listAgencyName'=>'PE:SUNAT','listName'=>'Afectacion del IGV','listURI'=>'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07'], '30'),  //  (Afectación IGV o IVAP del item)
                        self::crearNodo('cac:TaxScheme', [], [
                            self::crearNodo('cbc:ID', ['schemeAgencyName'=>'PE:SUNAT','schemeName'=>'Codigo de tributos','schemeURI'=>'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05'], '9998'),          // Código de tributo del ítem)
                            self::crearNodo('cbc:Name', [], 'INA'),           // (Nombre de tributo)
                            self::crearNodo('cbc:TaxTypeCode', [], 'FRE'),    // (Código internacional de tributo)
                        ])
                    ]),
                ])
            ]),
            self::crearNodo('cac:Item', [], [
                self::crearNodo('cbc:Description', [], $descripcion),   // Descripcion del item
                self::crearNodo('cac:SellersItemIdentification', [], [
                    self::crearNodo('cbc:ID', [], $codigo)              // Código de producto
                ])
            ]),
            self::crearNodo('cac:Price', [],
                self::crearNodo('cbc:PriceAmount',['currencyID'=>'PEN'], number_format($precio_unitario, 2, '.', '') )    //  Valor unitario del ítem
            ),
        ]);
    }

    protected function crearNodoEmisor( $ruc_emisor, $nombre_comercial, $razon_social, $direccion ,
                            $urbanizacion='URBANIZACION', $ciudad='Cajamarca', $departamento='Cajamarca', $distrito='Cajamarca', $ubigeo='060101' ){
        // cac:AccountingSupplierParty ( Tipo y Número de RUC del Emisor)
        return  self::crearNodo('cac:AccountingSupplierParty',[], [
                    self::crearNodo('cac:Party', [],[
                        self::crearNodo('cac:PartyIdentification', [],
                            self::crearNodo('cbc:ID',
                            ['schemeAgencyName'=>'PE:SUNAT','schemeID'=>'6','schemeName'=>'Documento de Identidad','schemeURI'=>'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06'],
                            $ruc_emisor)
                        ),
                        self::crearNodo('cac:PartyName', [],
                            self::crearNodo('cbc:Name', [], $nombre_comercial)
                        ),
                        self::crearNodo('cac:PartyLegalEntity', [], [
                            self::crearNodo('cbc:RegistrationName', [], $razon_social),
                            self::crearNodo('cac:RegistrationAddress', [], [
                                self::crearNodo('cbc:ID', ['schemeAgencyName'=>'PE:INEI','schemeName'=>'Ubigeos'], $ubigeo),
                                self::crearNodo('cbc:AddressTypeCode', ['listAgencyName'=>'PE:SUNAT', 'listName'=>'Establecimientos anexos'], '0000'),
                                self::crearNodo('cbc:CitySubdivisionName', [], $urbanizacion),
                                self::crearNodo('cbc:CityName', [], $ciudad),
                                self::crearNodo('cbc:CountrySubentity', [], $departamento),
                                self::crearNodo('cbc:District', [], $distrito),
                                self::crearNodo('cac:AddressLine', [],
                                    self::crearNodo('cbc:Line', [],  $direccion )),
                                self::crearNodo('cac:Country', [],
                                    self::crearNodo('cbc:IdentificationCode', ['listAgencyName'=>'United Nations Economic Commission for Europe', 'listID'=>'ISO 3166-1', 'listName'=>'Country'], 'PE' )),
                            ]),
                        ]),
                    ]),
                ]);
    }

    protected function crearNodoReceptor( $nombre_comercial, $razon_social, $dni, $direccion='',$email='' ,$ciudad='Cajamarca', $departamento='Cajamarca', $distrito='Cajamarca', $urbanizacion='' ){
        return
        // cac:AccountingCustomerParty (Datos del receptor de la Boleta) schemeID: 1=DNI, 6=ruc
        self::crearNodo('cac:AccountingCustomerParty', [],
            self::crearNodo('cac:Party', [], [
                self::crearNodo('cac:PartyIdentification', [],
                    self::crearNodo('cbc:ID', ['schemeAgencyName'=>'PE:SUNAT','schemeID'=>'1','schemeName'=>'Documento de Identidad','schemeURI'=>'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06'], $dni )
                ),
                self::crearNodo('cac:PartyName', [],
                    self::crearNodo('cbc:Name', [], $nombre_comercial)
                ),
                self::crearNodo('cac:PartyLegalEntity', [], [
                    self::crearNodo('cbc:RegistrationName', [], $razon_social ),
                    self::crearNodo('cac:RegistrationAddress', [], [
                        self::crearNodo('cbc:ID', ['schemeAgencyName'=>'PE:INEI', 'schemeName'=>'Ubigeos'], '060101'),
                        self::crearNodo('cbc:CitySubdivisionName', [], $urbanizacion), // URBANIZACION
                        self::crearNodo('cbc:CityName', [], $ciudad),
                        self::crearNodo('cbc:CountrySubentity', [], $departamento),
                        self::crearNodo('cbc:District', [], $distrito),
                        self::crearNodo('cac:AddressLine', [],
                            self::crearNodo('cbc:Line', [], $direccion) // RECEPTOR_DIRECCION
                        ),
                        self::crearNodo('cac:Country', [],
                            self::crearNodo('cbc:IdentificationCode', ['listAgencyName'=>'United Nations Economic Commission for Europe', 'listID'=>'ISO 3166-1', 'listName'=>'Country'], 'PE' )
                        )
                    ])
                ]),
                self::crearNodo('cac:Contact', [],
                    self::crearNodo('cbc:ElectronicMail', [], $email)
                ),
            ])
        );
    }

    protected function crearNodoFirmaDigital(){
        //Signature (Firma digita)
        return  self::crearNodo('cac:Signature',[], [
                    self::crearNodo('cbc:ID', [], 'IDSignKG'),
                    self::crearNodo('cac:SignatoryParty', [],[
                        self::crearNodo('cac:PartyIdentification', [], self::crearNodo('cbc:ID', [], 'RUC DEL EMISOR')),
                        self::crearNodo('cac:PartyName', [],
                            self::crearNodo('cbc:Name', [], 'RAZON SOCIAL EMISOR')
                        )
                    ]),
                    self::crearNodo('cac:DigitalSignatureAttachment', [],
                        self::crearNodo('cac:ExternalReference', [],
                            self::crearNodo('cbc:URI', [], '#SignST')
                        )
                    ),
                ]);
    }

    /* function crearNodosItem( $pagos, &$monto_total ){
        $pagos_nodos=[];

        // cac:InvoiceLine (Datos del detalle o Ítem de la Boleta)
        return  self::crearNodo('cac:InvoiceLine', [], [
                    self::crearNodo('cbc:ID', [], 1),                 // Secuencial (numero - item)  Número de orden del Ítem
                    self::crearNodo('cbc:Note', [], 'UNIDAD'),        //  (Descripción de la unidad)
                    self::crearNodo('cbc:InvoicedQuantity', ['unitCode'=>'ZZ','unitCodeListAgencyName'=>'United Nations Economic Commission for Europe','unitCodeListID'=>'UN/ECE rec 20'], 1), // @unitCode (Codigo unidad de medida del ítem)        (Cantidad del item)                    UNIDADES
                    self::crearNodo('cbc:LineExtensionAmount', ['currencyID'=>'PEN'], '10.00'),   //  @currencyID (Valor de venta del ítem y Moneda),  ' Valor referencial unitario por ítem' * ' Cantidad del ítem' - ' Monto descuento del ítem (Código 00)' + ' Monto cargo del ítem (Código 47)' ].
                    self::crearNodo('cac:PricingReference', [],       //  Precio de venta unitario del ítem
                        self::crearNodo('cac:AlternativeConditionPrice', [], [
                            self::crearNodo('cbc:PriceAmount', ['currencyID'=>'PEN'], '10.00'),       //(Precio de venta unitario del ítem y Moneda)
                            self::crearNodo('cbc:PriceTypeCode', ['listAgencyName'=>'PE:SUNAT','listName'=>'Tipo de Precio','listURI'=>'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16'], '01') //  (Código de precio)
                        ])
                    ),
                    self::crearNodo('cac:TaxTotal', [], [             // Monto total impuestos del ítem 'Monto del IGV o IVAP del ítem' con código de tributo '1000' o '1016' + 'Monto ISC del ítem' + 'Monto Otros tributos del ítem' + 'Monto ICBPER del ítem'
                        self::crearNodo('cbc:TaxAmount', ['currencyID'=>'PEN'], '0.00'),          //  (Monto total impuestos del ítem y Moneda)
                        self::crearNodo('cac:TaxSubtotal', [], [
                            self::crearNodo('cbc:TaxableAmount', ['currencyID'=>'PEN'], '10.00'), // (Monto base IGV o IVAP del itemy Moneda)
                            self::crearNodo('cbc:TaxAmount', ['currencyID'=>'PEN'], '0.00'),      // (Monto del IGV o IVAP del ítem y Moneda)
                            self::crearNodo('cac:TaxCategory', [], [
                                self::crearNodo('cbc:Percent', [], '0.00'),                       // (Porcentaje IGV o IVAP del item
                                self::crearNodo('cbc:TaxExemptionReasonCode', ['listAgencyName'=>'PE:SUNAT','listName'=>'Afectacion del IGV','listURI'=>'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07'], '30'),  //  (Afectación IGV o IVAP del item)
                                self::crearNodo('cac:TaxScheme', [], [
                                    self::crearNodo('cbc:ID', ['schemeAgencyName'=>'PE:SUNAT','schemeName'=>'Codigo de tributos','schemeURI'=>'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05'], '9998'),          // Código de tributo del ítem)
                                    self::crearNodo('cbc:Name', [], 'INA'),           // (Nombre de tributo)
                                    self::crearNodo('cbc:TaxTypeCode', [], 'FRE'),    // (Código internacional de tributo)
                                ])
                            ]),
                        ])
                    ]),
                    self::crearNodo('cac:Item', [], [
                        self::crearNodo('cbc:Description', [], 'DESCRIPCION1'),   // Descripcion del item
                        self::crearNodo('cac:SellersItemIdentification', [], [
                            self::crearNodo('cbc:ID', [], 'CODIGO1')              // Código de producto
                        ])
                    ]),
                    self::crearNodo('cac:Price', [],
                        self::crearNodo('cbc:PriceAmount',['currencyID'=>'PEN'], '10.00' )    //  Valor unitario del ítem
                    ),
                ]);
    } */

    public function generarContenidoXML ( $pago ){
        // Estructura
        $data = [];
        $data['ID'] = $pago->MP_PAGO_SERIE.'-'.$pago->MP_PAGO_NRO;                // Formato [B][A-Z0-9]{3}-[0-9]{1,8}
        $data['IssueDate'] = date('Y-m-d', strtotime($pago->MP_PAGO_FECHA) );  // Fecha de emision ('2019-06-10')
        $data['TipoOperacion'] = '03';

        $data['EMISOR_RUC'] = '20453661971';
        $data['EMISOR_NOMBRE_COMERCIAL'] = 'IEP. SEGUNDO CABRERA MUÑOZ';
        $data['EMISOR_RAZON_SOCIAL'] = 'COMPLEJO EDUCATIVO CABRERA E.I.R.L.';
        $data['EMISOR_DIRECCION'] = 'Jr. Los Próceres 309';

        if( $pago->RESPONSABLE_PAGO_ID  ){
            $apoderado = $pago->ResponsablePago;
            $responsable_nombre = $apoderado->MP_APO_APELLIDOS.' '.$apoderado->MP_APO_NOMBRES;
            $responsable_dni    = $apoderado->MP_APO_NRODOC;
        }
        else{
            $alumno = $pago->Matricula->Alumno;
            $responsable_nombre = $alumno->MP_ALU_APELLIDOS.' '.$alumno->MP_ALU_NOMBRES;
            $responsable_dni = $alumno->MP_ALU_DNI;
        }

        $data['RECEPTOR_RAZON_SOCIAL'] = $responsable_nombre;
        $data['RECEPTOR_NOMBRE_COMERCIAL'] = $responsable_nombre;
        $data['RECEPTOR_DNI'] = $responsable_dni;

        // INFORMACION DEL PAGO
        $data['BOLETA_MONTO_PAGADO'] = $pago->MP_PAGO_MONTO;
        $data['BOLETA_MONTO_LETRAS'] = $pago->MP_PAGO_LEE_MONTO;   // FORMATO [ CUATROCIENTOS SESENTA Y UN CON 56 /100 NUEVOS SOLES ]
        $data['NUMERO_ITEMS'] = 1;

        if( $pago->MP_CRO_ID ){
            $data['CODIGO'] = $pago->CronogramaPago->ConceptoPago->Concepto->MP_CON_ID;
            $data['DESCRIPCION'] = $pago->CronogramaPago->ConceptoPago->Concepto->MP_CON_CONCEPTO.' - '.$pago->Matricula->Vacante->Grado->grado().'° '.$pago->Matricula->Vacante->Seccion->seccion().' '. $pago->Matricula->Vacante->Nivel->nivel();
        }
        else{
            $data['CODIGO'] = $pago->ConceptoPago->Concepto->MP_CON_ID;
            $data['DESCRIPCION'] = $pago->ConceptoPago->Concepto->MP_CON_CONCEPTO;
        }
-
        $monto_total = 0;
        $nodosItems = self::crearItemBoleta(1,$data['CODIGO'], $data['DESCRIPCION'], $pago->monto(), 1, $monto_total );

        return [
                self::crearNodo('cbc:UBLVersionID',[], '2.1'),
                self::crearNodo('cbc:CustomizationID',[], '2.0'),
                self::crearNodo('cbc:ID',[], $data['ID']),
                self::crearNodo('cbc:IssueDate',[], $data['IssueDate']),
                self::crearNodo('cbc:InvoiceTypeCode',[   'listID'=>'0101','listSchemeURI'=>'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo51', 'name'=>'Tipo de Operacion'], $data['TipoOperacion']),
                self::crearNodo('cbc:Note',['languageLocaleID'=>'1000'], $data['BOLETA_MONTO_LETRAS']),
                self::crearNodo('cbc:DocumentCurrencyCode',['listAgencyName'=>'United Nations Economic Commission for Europe', 'listID'=>'ISO 4217 Alpha', 'listName'=>'Currency'], 'PEN'),
                self::crearNodo('cbc:LineCountNumeric',[], $data['NUMERO_ITEMS'] ),
                //Signature (Firma digita)
                self::crearNodoFirmaDigital(),
                // cac:AccountingSupplierParty ( Tipo y Número de RUC del Emisor)
                self::crearNodoEmisor($data['EMISOR_RUC'], $data['EMISOR_NOMBRE_COMERCIAL'], $data['EMISOR_RAZON_SOCIAL'], $data['EMISOR_DIRECCION'] ),
                // cac:AccountingCustomerParty (Datos del receptor de la Boleta) schemeID: 1=DNI, 6=ruc
                self::crearNodoReceptor( $data['RECEPTOR_NOMBRE_COMERCIAL'], $data['RECEPTOR_RAZON_SOCIAL'], $data['RECEPTOR_DNI']),
                // cac:TaxTotal ( Monto total impuestos del ítem) suma: 'Monto del IGV o IVAP del ítem' con código de tributo '1000' o '1016' + 'Monto ISC del ítem' + 'Monto Otros tributos del ítem' + 'Monto ICBPER del ítem
                self::crearNodo('cac:TaxTotal', [], [
                    self::crearNodo('cbc:TaxAmount', ['currencyID'=>'PEN'], '0.00'),                                          // Monto total impuestos del ítem y Moneda)
                    self::crearNodo('cac:TaxSubtotal', [], [
                        self::crearNodo('cbc:TaxableAmount', [ 'currencyID' => 'PEN'], number_format($monto_total,2,'.','')),    // Monto base IGV o IVAP del itemy Moneda
                        self::crearNodo('cbc:TaxAmount', [ 'currencyID' => 'PEN'], 0.00),                                     // Monto del IGV o IVAP del ítem y Moneda)
                        self::crearNodo('cac:TaxCategory', [],                                                                // Porcentaje IGV o IVAP del item)
                            self::crearNodo('cac:TaxScheme', [], [
                                self::crearNodo('cbc:ID', [ 'schemeAgencyID'=>'6', 'schemeID'=>'UN/ECE 5153' ], '9998'),      // Código de tributo del ítem
                                self::crearNodo('cbc:Name', [], 'INA'),                                                       // Nombre de tributo) (INAFECTA)
                                self::crearNodo('cbc:TaxTypeCode', [], 'FRE'),                                                // Código internacional de tributo
                            ])
                        ),
                    ]),
                ]),

                // cac:LegalMonetaryTotal (Total Descuentos (Que no afectan la base) )
                self::crearNodo('cac:LegalMonetaryTotal', [], [
                    self::crearNodo('cbc:LineExtensionAmount', [ 'currencyID'=>'PEN' ], number_format($monto_total,2,'.','')),   // total valor de venta = Valor de venta del ítem +Monto descuento global + Montó cargo global
                    self::crearNodo('cbc:TaxInclusiveAmount', [ 'currencyID'=>'PEN' ], number_format($monto_total,2,'.','')),    // Corresponde al total precio de venta = : 'Total Valor de Venta' + 'Sumatoria total ISC' + 'Sumatoria total Otros Tributos' + 'Sumatoria total ICBPER' + [(sumatoria de los 'Monto base IGV o IVAP del ítem' con 'Código de tributo del ítem' igual a '1000' - 'Monto descuento global (Código 02)' + 'Montó cargo global (Cargo 49)') * 'Porcentaje del IGV o IVAP del item'/100]
                    self::crearNodo('cbc:PayableAmount', [ 'currencyID'=>'PEN' ], number_format($monto_total,2,'.','')),         // Importe total del comprobante, = 'Total precio venta' +' Total cargos' - 'Total descuentos' - 'Total anticipos' + 'Monto redondeo del importe total'
                ]),
                $nodosItems
            ];
    }


    public function crearArchivoXML( $pago, object $configuracion=null ){ // Retorna el nombre del archivo a generar
        /* return $pago; */

        $serie_pago = $pago->MP_PAGO_SERIE;
        $serie_nro =  $pago->MP_PAGO_NRO;
       /*  $serie_fecha_emision =  date('YYYY-MM-DD', strtotime($pago->MP_PAGO_FECHA)); */

        $nombre_archivo ="20453661971-03-$serie_pago-$serie_nro.xml";
        $carpeta_temp = '';

        if( $configuracion ){

            /* if( $configuracion->archivo_comprimido ) $carpeta_temp=time().''; */

            if($configuracion->ruta) $carpeta_temp = $configuracion->ruta;

            if($carpeta_temp!=''){
                if( !Storage::disk('publicFile')->exists("archivos_XML/$carpeta_temp") )
                    Storage::disk('publicFile')->makeDirectory("archivos_XML/$carpeta_temp");
                $carpeta_temp = "$carpeta_temp/";
            }
        }

        $contenidoXML =  self::generarContenidoXML($pago);
        try {
            self::escribirXml($contenidoXML, $carpeta_temp.$nombre_archivo);
            return  $nombre_archivo;
        } catch (\Throwable $th) {
            return null;
        }



    }

}
