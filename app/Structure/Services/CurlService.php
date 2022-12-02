<?php
namespace App\Structure\Services;

use Exception;

class CurlService
{
    private $url;
    public $handler;

    public function __construct( string $url, bool $init = false )
    {
        $this->url = $url;
        if( $init ){
            self::init();
        }
    }

    public function init(){
        $this->handler = curl_init();
        curl_setopt( $this->handler, CURLOPT_URL, $this->url);
        curl_setopt( $this->handler, CURLOPT_RETURNTRANSFER, true );
    }

    public function setOptions ( $options ){
        foreach ( $options as $key => $option )
            curl_setopt( $this->handler, $key , $option);
        dd($this->handler);
    }

    /*  public function appendData( array $data_array ){
        $data = http_build_query( $data_array );
        curl_setopt( $this->handler, CURLOPT_POSTFIELDS, $data );
    } */

    public function execute (){
        $response = curl_exec( $this->handler );
        if(curl_errno( $this->handler )) throw new Exception( 'Ocurrio un error al enviar peticion, '. curl_error($this->handler));
        self::close();
        return json_decode($response, true);
    }

    public function close(){
        curl_close( $this->handler );
    }

    public function getTokenAuthentication (  ) {

    }


}


