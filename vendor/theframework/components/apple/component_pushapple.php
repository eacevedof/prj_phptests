<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentPushapple
 * @file component_pushapple.php
 * @version 1.0.0
 * @date 09-08-2018 17:41
 * @observations
 */
namespace TheFramework\Components;

class ComponentPushapple 
{
    private $isError;
    private $arErrors;

    private $sUrlDev;
    private $sPassphraseDev;
    private $sPathPemDev;
    private $sCertificateDev;
    
    public function __construct() 
    {
        $this->sUrlDev = "ssl://17.172.232.45:2195";
        $this->sCertificateDev = "";
    }
    
    public function send_push()
    {
        $sUrlApple = $this->sUrlDev;
        $sPassphrase = $this->sPassphraseDev;
        $sFilePem = $this->sPathPemDev.$this->sCertificateDev;  
 
        $this->log("send_push()");
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
  
    private function log($mxVar){echo var_export($mxVar,1);}
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function add_from($sKey,$sValue){$this->arFrom[$sKey] = $sValue;}
    public function add_to($sKey,$sValue){$this->arTo[$sKey] = $sValue;}
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
}//class ComponentPushapple

