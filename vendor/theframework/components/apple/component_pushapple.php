<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Apple\ComponentPushapple 
 * @file component_pushapple.php
 * @version 2.1.0
 * @date 10-08-2018 08:06
 * @observations
 */
namespace TheFramework\Components\Apple;

class ComponentPushapple 
{
    private $isError;
    private $arErrors;

    private $sDeviceToken = "";
    private $sPassphrase = "some-passw";
    private $sPemCertificate = "file.pem";
    private $sUrlApn = "https://pushtry.com/";
    private $sPathDirpemDS = ""; //c:/procesos/wfManagerGereparto/push_alert/
    
    public function __construct() 
    {
        $this->sPathDirpemDS = __DIR__."/";
    }//__construct
    
    public function load_dev()
    {
        $this->sDeviceToken =  (isset($_GET["device"])?$_GET["device"]:"9f48cab8a0e0b8a49ee194c5c77532fc9aec07a14357ae2f9c9c12cb784301f3");
        $this->sPassphrase = (isset($_GET["pass"])?$_GET["pass"]:"pushchat");
        $this->sPemCertificate = "ckdev.pem";
        $this->sUrlApn = "ssl://gateway.sandbox.push.apple.com:2195";
        $this->sMessage = "TEST: esto es un mensaje a enviar FIN.".date("Y-m-d H:i:s");        
    }
    
    public function load_prod()
    {
        //javi
        $this->sDeviceToken =  (isset($_GET["device"])?$_GET["device"]:"9f48cab8a0e0b8a49ee194c5c77532fc9aec07a14357ae2f9c9c12cb784301f3");
        $this->sPassphrase = (isset($_GET["pass"])?$_GET["pass"]:"");
        $this->sPemCertificate = "ckprod.pem";
        $this->sUrlApn = "ssl://gateway.push.apple.com:2195";
        $this->sMessage = "PRODUCTION: esto es un mensaje a enviar FIN.";
    }
    
    public function send_push()
    {
        //$this->load_dev();
        //$this->load_prod();
        
        $sUrlApple = $this->sUrlApn;
        $sPassphrase = $this->sPassphrase;
        $sFilePem = $this->sPathDirpemDS.$this->sPemCertificate;  
        $sFilePem = realpath($sFilePem);
        
        $this->log("send_push() -  ".date("Y-m-d H:i:s"));
        $this->log("alert: $this->sMessage");
        $this->log("{url: $sUrlApple,\npassphrase: $sPassphrase,\nfilepem: $sFilePem,\ndevicetoken: $this->sDeviceToken}");
        $iError = NULL; //Numero de error del socket
        $sError = ""; //mensaje de error
        
        $oStreamContext = stream_context_create();
        $this->log($oStreamContext,"oStreamContext 1");
        //ck.pem: Certificado generado para entorno de desarrollo. La dif de desarr y prod es q el de des caduca en 3 meses
        stream_context_set_option($oStreamContext,"ssl","local_cert",$sFilePem);
        //stream_context_set_option($oStreamContext,"ssl","passphrase",$sPassphrase);

        $this->log($oStreamContext,"oStreamContext 2");
        $this->log("stream_socket_client(..):$sUrlApple");
        //Open a connection to the APNS (Apple push notification service) server
        $oStreamToApple = stream_socket_client($sUrlApple,$iError,$sError,60
                                    ,STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $oStreamContext);
        $this->log("after stream_sockek_client(..)");
        $this->log($oStreamToApple,"streamtoapple");
        if(!$oStreamToApple)
        {
            $this->log("Error: Failed to connect: iError:$iError, sError:$sError");
            $this->add_error("stream_socket_client(): Failed to connect: iError:$iError, sError:$sError".PHP_EOL);
            return;
        }

        $this->log($iError,"iError");
        $this->log($sError,"sError");
        $this->log("Connected to APNS".PHP_EOL);
        //Create the payload body
        $arPayload["aps"] = array("alert"=>$this->sMessage,"sound"=>"default");
        //parametros personalizados
        $arPayload["codekey"] = "P";
        $arPayload["numr"] = "0000000074";
        //Encode the payload as JSON
        $sJsonPayload = json_encode($arPayload);
        $this->log($sJsonPayload,"payload");
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
  
    public function set_pathpemdir($sValue){$this->sPathDirpemDS=$sValue;}
    public function set_pathpemfile($sValue){$this->sPemCertificate=$sValue;}
    public function set_password($sValue){$this->sPassphrase=$sValue;}
    public function set_message($sValue){$this->sMessage=$sValue;}
    
    private function log($mxVar,$sTitle=""){echo "<pre> - $sTitle: ".var_export($mxVar,1)."</pre>";}
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>Errors:<br/>\n".var_export($this->arErrors,1)."</pre>";}
}//class ComponentPushapple

