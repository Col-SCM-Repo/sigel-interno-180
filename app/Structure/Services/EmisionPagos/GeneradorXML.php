<?php
namespace App\Structure\Services\EmisionPagos;

use Sabre\Xml\Service;

abstract class GeneradorXML
{
    /* abstract protected function crearNodoEmisor( $ruc_emisor, $nombre_comercial, $razon_social, $direccion , $urbanizacion, $ciudad, $departamento, $distrito, $ubigeo);

    abstract protected function crearNodoReceptor( $nombre_comercial, $razon_social, $dni, $direccion,$email ,$ciudad, $departamento, $distrito, $urbanizacion); */

    abstract function generarContenidoXML( $pago );

    abstract function crearArchivoXML( $pago, object $configuracion=null );


    protected function escribirXml( array $contenido_xml, $nombre_archivo='archivo_xml_generado_default.xml', string $raiz = 'Invoice'){    // Devuelve el texto del XML
        $servicio = new Service();

        // Creando atributos del nodo raiz
        $servicio->namespaceMap['urn:oasis:names:specification:ubl:schema:xsd:Invoice-2'] = '';
        $servicio->namespaceMap['urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2'] = 'cac';
        $servicio->namespaceMap['urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2'] = 'cbc';
        $servicio->namespaceMap['urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2'] = 'ext';

        $file = fopen( "archivos_XML/$nombre_archivo" , 'w+b');
        fwrite($file, $servicio->write( $raiz, $contenido_xml ) );
        fclose($file);
        return $nombre_archivo;
    }

    protected function crearNodo( string $nombre_nodo, array $atributos, $valor  ){
        return [ 'name'=> $nombre_nodo, 'attributes'=>$atributos, 'value'=>$valor ];
    }

}
