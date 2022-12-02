<?php
namespace App\Structure\Services;

use App\Enums\AlumnoMorosoEnum;
use App\Enums\TipoComprobanteEnum;
use App\Helpers\BancoPago;
use App\Helpers\CronogramaHelper;
use App\Helpers\TipoComprobante;
use App\Mappers\AlumnoMorosoMapper;
use App\Mappers\PagoEntreFechasMapper;
use App\Mappers\PagoMapper;
use App\Structure\Repository\PagoRepository;
use App\Structure\Repository\VacanteRepository;
use App\Structure\Services\EmisionPagos\BoletaElectronica;
use App\Vacante;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ZipArchive;

class PagoService
{
    protected $_pagoMapper;
    protected $_pagoRespository;
    protected $_cronogramaService;
    protected $_conceptoPagoService;
    protected $_matriculaService;
    protected $_alumnoService;
    protected $_vacanteReposotory;
    protected $_alumnoMorosoMapper;
    protected $_pagoEntreFechasMapper;
    protected $_parentescoService;
    protected $_boletaElectronicaGenerador;
    public function __construct()
    {
        $this->_pagoMapper= new PagoMapper();
        $this->_pagoRespository= new PagoRepository();
        $this->_cronogramaService= new CronogramaService();
        $this->_conceptoPagoService= new ConceptoPagoService();
        $this->_matriculaService= new MatriculaService();
        $this->_alumnoService= new AlumnoService();
        $this->_vacanteReposotory= new VacanteRepository();
        $this->_alumnoMorosoMapper= new AlumnoMorosoMapper();
        $this->_pagoEntreFechasMapper= new PagoEntreFechasMapper();
        $this->_parentescoService = new ParentescoService();
        $this->_boletaElectronicaGenerador = new BoletaElectronica();
    }
    public function ObtenerPagosPorCronograma($cronogramaId)
    {
        $_listPagos = $this->_pagoMapper->ListModelToViewModel($this->_pagoRespository->ObtenerPagosPorCronograma($cronogramaId));
        foreach ($_listPagos as $pagoVM) {
            $pagoVM->tipo_comprobante = TipoComprobante::Atexto($pagoVM->tipo_comprobante_id);
        }
        return $_listPagos;
    }
    public function CreaViewModel($cronograma_id, $alumno_id)
    {
        $_pagoVM =  $this->_pagoMapper->ViewModel();

        $_pagoVM->fecha = date('Y-m-d');
        $_pagoVM->usuario_id = Auth::user()->id();
        $_pagoVM->serie_comprobante_id = Auth::user()->SerieComprobante()->get()->last()->id();
        $_pagoVM->serie = Auth::user()->SerieComprobante()->get()->last()->serie();

        $_pagoVM->responsables_pago = $this->_parentescoService->BuscarPorAlumnoId( $alumno_id );
        foreach ($_pagoVM->responsables_pago as $responsable_pago )
            if( $responsable_pago->responsable_defecto == true ){
                $_pagoVM->responsable_pago_id = $responsable_pago->id;
                break;
            }

        if ($cronograma_id!=0) {
            $_cronogramaVm = $this->_cronogramaService->BuscarPorId($cronograma_id);
            $_pagoVM->saldo = $_cronogramaVm->monto_cobrar;

            foreach (self::ObtenerPagosPorCronograma($cronograma_id) as $pago) $_pagoVM->saldo -= $pago->monto;
            $_pagoVM->monto = $_pagoVM->saldo;
        }


        return$_pagoVM;
    }
    public function GuardarPago($_pagoVM) // SIN REVISAR
    {
        $_pagoVM->numero = $this->_pagoRespository->ObtenerNumeracionPorserie($_pagoVM->serie)+1;
        /* if($_pagoVM->tipo_comprobante_id==TipoComprobanteEnum::BoletaElectronica || $_pagoVM->tipo_comprobante_id==TipoComprobanteEnum::FaturaElectronica){
        } */

        $cronogramaVM = null;

        if (isset($_pagoVM->cronograma_id)) {
            $cronogramaVM = $this->_cronogramaService->BuscarPorId($_pagoVM->cronograma_id);        // CORREGIRRRRRR
            if(number_format($_pagoVM->monto,2)<number_format($_pagoVM->saldo,2))  $cronogramaVM->estado='SALDO';
            else
                if(number_format($_pagoVM->monto,2)==number_format($_pagoVM->saldo,2)) $cronogramaVM->estado='CANCELADO';
        }
        $_pagoVM->banco = BancoPago::ObtenerBanco($_pagoVM->banco);

        $pago_id = $this->_pagoRespository->Crear($this->_pagoMapper->ViewModelToModel($_pagoVM));

        if( $pago_id>0 && $cronogramaVM ) $this->_cronogramaService->Actualizar($cronogramaVM);

        return $pago_id;
    }
    public function GuardarNotaCredito($_pagoVM,$pagoAnteriorId)
    {
        $_pagoAnteriorModel = $this->_pagoRespository->BuscarPorId($pagoAnteriorId);
        $_pagoVM->tipo_comprobante_id=TipoComprobanteEnum::NotaDeCredito;
        $_pagoVM->fecha_emision = date('Y-m-d\TH:i:s');
        $_pagoVM->banco = $_pagoAnteriorModel->BANCO;
        $_pagoVM->numero = $this->_pagoRespository->ObtenerNumeracionPorserie($_pagoVM->serie)+1;

        $_cronogramaVM = null;
        if (isset($_pagoAnteriorModel->CronogramaPago)) {   // Si anula pago realizado al cronograma
            $_montoPagado = 0;
            $cronograma_id = $_pagoAnteriorModel->CronogramaPago->id();

            foreach (self::ObtenerPagosPorCronograma($cronograma_id) as $pago) $_montoPagado += $pago->monto;

            $_cronogramaVM = $this->_cronogramaService->BuscarPorId($cronograma_id);
            $_cronogramaVM->estado = ( $_montoPagado - abs((double) $_pagoVM->monto) <=0 )? 'PENDIENTE': 'SALDO';
        }

        $pago_id = $this->_pagoRespository->Crear($this->_pagoMapper->ViewModelToModel($_pagoVM));
        if($pago_id>0 && $_cronogramaVM)  $this->_cronogramaService->Actualizar($_cronogramaVM);
        return $pago_id ;
    }
    public function ObtenerPagosPorOtrosConceptoPorMatricula($_matriculaId)
    {
        $_listPagosVM = $this->_pagoMapper->ListModelToViewModel($this->_pagoRespository->ObtenerPagosPorOtrosConceptoPorMatricula($_matriculaId));
        foreach ($_listPagosVM as $pagoVM) {
            $pagoVM->concepto = $this->_conceptoPagoService->ObtenerPorId($pagoVM->concepto_pago_id);
            $pagoVM->tipo_comprobante = TipoComprobante::Atexto($pagoVM->tipo_comprobante_id);
        }
        return $_listPagosVM;
    }
    public function ObtenerPagosPorFechaUsuarioActual($_fecha)
    {
        $_listPagosVM = $this->_pagoMapper->ListModelToViewModel($this->_pagoRespository->ObtenerPagosPorFechaUsuarioActual($_fecha));
        foreach ($_listPagosVM as $pagoVM) {
            $_alumnoVM = $this->_alumnoService->BuscarPorId($this->_matriculaService->ObtenerPorId($pagoVM->matricula_id)->alumno_id);
            $pagoVM->nombres_alumno = $_alumnoVM->apellidos.', '. $_alumnoVM->nombres;
            $_conceptoPagoId = $pagoVM->cronograma_id? ($this->_cronogramaService->BuscarPorId($pagoVM->cronograma_id)->concepto_pago_id):($pagoVM->concepto_pago_id);
            $pagoVM->nombre_concepto = $this->_conceptoPagoService->ObtenerPorId($_conceptoPagoId)->concepto ;
        }
        return $_listPagosVM ;
    }
    public function ObtenerAlumnosMorosos($anio_id,$nivel_id,$seccion_id,$concepto_id, $estado)
    {
        $_listaAlumnoMorososVM = array();
        if ($seccion_id == AlumnoMorosoEnum::Todos) {
            $_seccionesM = $this->_vacanteReposotory->BuscarAulasPorAnioNivel($anio_id,$nivel_id);
            foreach ($_seccionesM as $_seccionM) {
                $_listaAux = self::AgregarAlumnosMorosos($_seccionM, $concepto_id, $estado);
                foreach ($_listaAux as $_alumnoMorosoVM) {
                    array_push($_listaAlumnoMorososVM, $_alumnoMorosoVM);
                }
            }
        } else {
            $_seccionM = $this->_vacanteReposotory->BuscarPorId($seccion_id);
            $_listaAlumnoMorososVM = self::AgregarAlumnosMorosos($_seccionM, $concepto_id, $estado);
        }
        return $_listaAlumnoMorososVM;
    }
    private function AgregarAlumnosMorosos(Vacante $_seccionM,$concepto_id, $estado )
    {
        $_listaAlumnoMorososVM = array();
        foreach ($_seccionM->Matriculas as $_matriculaM ) {
            foreach ($_matriculaM->CronogramaPagos as $_cronogramaM) {
                if ($estado == AlumnoMorosoEnum::Todos  ) {
                    if ($concepto_id==AlumnoMorosoEnum::Todos && ($_cronogramaM->estado()==AlumnoMorosoEnum::Saldo||$_cronogramaM->estado()==AlumnoMorosoEnum::Pendiente)) {
                        array_push($_listaAlumnoMorososVM, $this->_alumnoMorosoMapper->ModelsToViewModel($_matriculaM,$_seccionM,$_cronogramaM));
                    } else {
                        if ($_cronogramaM->ConceptoPago->id()==$concepto_id && ($_cronogramaM->estado()==AlumnoMorosoEnum::Saldo||$_cronogramaM->estado()==AlumnoMorosoEnum::Pendiente)) {
                            array_push($_listaAlumnoMorososVM, $this->_alumnoMorosoMapper->ModelsToViewModel($_matriculaM,$_seccionM,$_cronogramaM));
                        }
                    }
                } else {
                    if ($concepto_id==AlumnoMorosoEnum::Todos && $_cronogramaM->estado()==CronogramaHelper::EstadoTexto($estado)) {
                        array_push($_listaAlumnoMorososVM, $this->_alumnoMorosoMapper->ModelsToViewModel($_matriculaM,$_seccionM,$_cronogramaM));
                    } else {
                        if($_cronogramaM->ConceptoPago->id()==$concepto_id && $_cronogramaM->estado()==CronogramaHelper::EstadoTexto($estado)){
                            array_push($_listaAlumnoMorososVM, $this->_alumnoMorosoMapper->ModelsToViewModel($_matriculaM,$_seccionM,$_cronogramaM));
                        }
                    }
                }
            }
        }
        return $_listaAlumnoMorososVM;
    }
    public function ObtenerPagosEntreFechas($_fechaInicial, $_fechaFinal, $_usuarioId)
    {
        $_listaPagosVM = array();
        if ($_usuarioId==0) {
            $_pagosAux = $this->_pagoRespository->ObtenerEntreFechas($_fechaInicial, $_fechaFinal);
        } else {
            $_pagosAux = $this->_pagoRespository->ObtenerEntreFechasPorUsuario($_fechaInicial, $_fechaFinal, $_usuarioId);
        }
        foreach ($_pagosAux as $_pagoM ) {
            array_push($_listaPagosVM, $this->_pagoEntreFechasMapper->ModelToViewModel($_pagoM));
        }
        return $_listaPagosVM;
    }
    public function ObtenerPagoPorId( $pago_id ){
        return $this->_pagoMapper->ModelToViewModel( $this->_pagoRespository->BuscarPorId($pago_id));
    }

    public function ValidarPago($_pagoVM)
    {
        $_pagoVM->banco = BancoPago::ObtenerBanco($_pagoVM->banco);
        $pagoExiste = $this->_pagoRespository->ObtenerPorBancoYOperacion($_pagoVM->banco, $_pagoVM->numero_operacion);
        if(isset($pagoExiste)){
            return $pagoExiste;
        }else{
            return null;
        }
    }

    public function GenerarComprobanteElectronicoXml( $pago_id, $configuracion = null ){
        $pago = $this->_pagoRespository->BuscarPorId($pago_id);
        if($pago)
            switch ($pago->MP_TIPCOM_ID) {
                case 2: case 8: // Boleta
                    return $this->_boletaElectronicaGenerador->crearArchivoXML(  $pago , $configuracion);

                case 5: // Nota credito

                case 9: // Facturacion electronica

                default: throw new NotFoundHttpException("El archivo XML no se encuentra implementado para el tipo de comprobante." );
            }
        throw new NotFoundHttpException("Error, no se encontro el pago [ID: $pago_id]");
    }

    public function GenerarArchivosXML_zip( $pagos_ids ){
        if( !is_array( $pagos_ids ) || ( is_array( $pagos_ids ) && count($pagos_ids) == 0  ) ) throw new BadRequestHttpException();

        $nombres_archivos_generados = [];
        $nombres_archivos_no_generados = [];

        $nombre_carpeta = time().'';
        foreach ($pagos_ids as  $key => $pago_id ) {
            try {
                $nombre_archivo = self::GenerarComprobanteElectronicoXml( $pago_id, (object)[ 'ruta'=> $nombre_carpeta ] );
                if($nombre_archivo) $nombres_archivos_generados [] = $nombre_archivo;
            } catch (Exception $err ) {
                $pago = $this->_pagoRespository->BuscarPorId($pago_id);
                $serie_pago = $pago->MP_PAGO_SERIE;
                $serie_nro =  $pago->MP_PAGO_NRO;
                $nombres_archivos_no_generados[] = "$serie_pago-$serie_nro.xml \t(".$err->getMessage().')' ;
            }
        }

        $file = fopen( "archivos_XML/$nombre_carpeta/LEEME.txt" , 'w+b');
        fwrite($file, "Archivos generados : (". ( count($nombres_archivos_generados) ) .")  \n\t* ".( implode("\n\t* ", $nombres_archivos_generados) ) );
        fwrite($file, "`\nArchivos no generados : (". ( count($nombres_archivos_no_generados) ) .")  \n\t* ".( implode("\n\t* ", $nombres_archivos_no_generados) ) );
        fclose($file);

        $nombres_archivos_generados[] = 'LEEME.txt';

        $archivo_zip = new ZipArchive();
        if( ! $archivo_zip->open("archivos_XML/$nombre_carpeta.zip", ZipArchive::CREATE ) ) throw new Exception("No se pudo crear el archivo $nombre_carpeta.zip");

        foreach ($nombres_archivos_generados as $nombre_archivo_generado)
            $archivo_zip->addFile("archivos_XML/$nombre_carpeta/$nombre_archivo_generado", $nombre_archivo_generado);

        $resultado = $archivo_zip->close();
        if( Storage::disk('publicFile')->exists("archivos_XML/$nombre_carpeta") ) Storage::disk('publicFile')->deleteDirectory("archivos_XML/$nombre_carpeta");

        return $resultado ? "$nombre_carpeta.zip": null;
    }


    public function enviarXmlToOSE( $nombre_archivo ){
        return self::obtenerTokenAuth();
    }


    private function obtenerTokenAuth( ){
        $url =  'https://ose-gw1.efact.pe:443/api-efact-ose/oauth/token';
        $user = '';
        $passwd = '';

        $authorizacion = base64_encode("client:secret");

        $body = [
            "username" =>$user,
            'password' => $passwd,
            'grant_type' => 'password'
        ];

        $curlOptions = [
            CURLOPT_HTTPHEADER => [ 'Content-Type: application/x-www-form-urlencoded', "Authorization: Basic $authorizacion"],
            CURLOPT_POST =>true,
            CURLOPT_POSTFIELDS => http_build_query( $body ),
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ];


        $request = new CurlService( $url, true );
        $request->setOptions($curlOptions);
        return [
            curl_getinfo($request->handler),
            $request->execute()
         ];


        // 'Content-Type: multipart/form-data',
        /*
        //Archivo Entrante o remplazala
    $in_file = $_FILES["fileZip"];

    //Ruta Real del Archivo Entrante
    //tambien puedes remplazar este valor por la ruta del Archivo del Servidor X
    $temp_path = realpath($in_file["tmp_name"]);

    //Construye el archivo CURLFile
    $curl_file = new CURLFile($temp_path,'file/zip','Nombre del Archivo');

    //Genera las Variables POST para enviar la Peticion CURL
    $vars = array('fileZip' => $curl_file);

    //Enlace donde se enviara el archivo
    $end_point = "https://Y.com/transferTest/";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $end_point);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);

    $result = curl_exec($curl);

    print_r($result);
        */
    }


}
