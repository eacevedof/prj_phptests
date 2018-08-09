<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Apple\ComponentPushapple 
 * @file component_pushapple.php
 * @version 1.0.0
 * @date 09-08-2018 13:06
 * @observations
 */
namespace TheFramework\Components\Apple;

class ComponentPushapple 
{
    private $isError;
    private $arErrors;

    //private $sDeviceToken = "c7223d8a00fe114c74ce8bbe4cb27cc7f3d11ccabfcd20c737d459a085d4fef2";//Ipad mini
    private $sDeviceToken = "587cbe29da44b6ebde27eb2123e7d7434c4db4c4168233665ec78a28f082488a";//Iphone Daniela
    //private $sDeviceToken = "2a4d9174cbd46df28b1016241643e9db188e3f0a96df56e88d6091e9c3afb3a1";//Ipad Prod    
    //private $sDeviceToken = "e0a19e36938ac4afce7ee58a03e38b8fee23ca8d8746392c09e039c42e0e409e";//Iphone Prod
    private $sPassphraseDev = "pushchat";
    private $sCertificateDev = "ckdev.pem";
    //(TEST) ssl://gateway.sandbox.push.apple.com:2195, (PROD) ssl://gateway.push.apple.com:2195
    private $sUrlDev = "ssl://17.188.137.58:2195";//PROD: ssl://17.110.226.90:2195
    private $sPathPemDev = ""; //c:/procesos/wfManagerGereparto/push_alert/ web.test
    
    public function __construct() 
    {
        //$this->sUrlDev = "ssl://gateway.sandbox.push.apple.com:2195";
        $this->sMessage = "TEST: esto es un mensaje a enviar FIN.";
        $this->sPathPemDev = __DIR__."/";
        $this->load_prod();
    }
    
    public function load_prod()
    {
        $this->sDeviceToken = "e0a19e36938ac4afce7ee58a03e38b8fee23ca8d8746392c09e039c42e0e409e";
        $this->sPassphraseDev = "";
        $this->sCertificateDev = "ckprod.pem";
        $this->sUrlDev = "ssl://gateway.push.apple.com:2195";
        $this->sMessage = "PRODUCTION: esto es un mensaje a enviar FIN.";
    }
    
    public function send_push()
    {
        $sUrlApple = $this->sUrlDev;
        $sPassphrase = $this->sPassphraseDev;
        $sFilePem = $this->sPathPemDev.$this->sCertificateDev;  
        $sFilePem = realpath($sFilePem);
        
        $this->log("send_push()");
        $this->log("alert: $this->sMessage");
        $this->log("[[  url:$sUrlApple, passphrase:$sPassphrase, filepem:$sFilePem, devicetoken:$this->sDeviceToken ]]");
        $iError = NULL; //Numero de error del socket
        $sError = ""; //mensaje de error
        
        $oStreamContext = stream_context_create();
        //ck.pem: Certificado generado para entorno de desarrollo. La dif de desarr y prod es q el de des caduca en 3 meses
        stream_context_set_option($oStreamContext,"ssl","local_cert",$sFilePem);
        stream_context_set_option($oStreamContext,"ssl","passphrase",$sPassphrase);

        $this->log("stream_socket_client(..):$sUrlApple");
        //Open a connection to the APNS (Apple push notification service) server
        $oStreamToApple = stream_socket_client($sUrlApple,$iError,$sError,60
                                    ,STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $oStreamContext);
        $this->log("after stream_sockek_client(..)");

        if(!$oStreamToApple)
        {
            $this->log("Error: Failed to connect: iError:$iError, sError:$sError");
            $this->add_error("stream_socket_client(): Failed to connect: iError:$iError, sError:$sError".PHP_EOL);
            return;
        }

        $this->log("Connected to APNS".PHP_EOL);
        //Create the payload body
        $arPayload["aps"] = array("alert"=>$this->sMessage,"sound"=>"default");
        //Encode the payload as JSON
        $sJsonPayload = json_encode($arPayload);
        //Build the binary notification.chr():Ascii value, Pack(): Pack data into binary string. H:Hex, n:unsigned short (always 16 bit, big endian byte order)
        $sBinMessage = chr(0).pack("n",32).pack("H*",$this->sDeviceToken).pack("n",strlen($sJsonPayload)).$sJsonPayload;
        //Send it to the server
        $isWritten = fwrite($oStreamToApple,$sBinMessage,strlen($sBinMessage));

        if(!$isWritten)
            $this->add_error("fwrite(..): Message not deliveried ($isWritten).");
        else
            $this->log("Message successfully delivered".PHP_EOL);
        //Close the connection to the server
        fclose($oStreamToApple);
        $this->log("END: send_push()");
    }//send_push()    
  
    private function log($mxVar){echo "<pre> - ".var_export($mxVar,1)."</pre>";}
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function add_from($sKey,$sValue){$this->arFrom[$sKey] = $sValue;}
    public function add_to($sKey,$sValue){$this->arTo[$sKey] = $sValue;}
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
}//class ComponentPushapple

