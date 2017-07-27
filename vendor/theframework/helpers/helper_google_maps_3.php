<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.11
 * @name Helper GoogleMaps3  
 * @date 27-10-2014 14:50
 * @file helper_google_maps_3.php
 * @requires js_google_map_3.js v1.1.4, jquery v1.7+ 
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperGoogleMaps3
{
    //=====================
    //      ATRIBUTOS
    //=====================
    //Signatura codificada. Se puede proporcionar una o se puede generar a partir de criptokey y clientid
    private $_sSignature = "";
    private $_useSignature = false;
    //Una criptokey se proporciona cuando se contrata el plan empresarial
    private $_sCriptokey = "";
    private $_useCriptoKey = false;
    //Un clientid se proporciona cuando se contrata el plan empresarial
    private $_sClientId = "";
    //Si el client id lo van a utilizar distintas apps para diferenciar las llamadas se utiliza un canal.
    private $_sChannel = "";
    
    //Apikey son las claves no empresariales
    private $_sApikey = "";
    //Indica si se cargara automaticamente el tag "<script>" con la url 
    //de googlemaps. Si se ha definido una apikey se incluye
    private $_useApikey = true;
    //Indica si se va a incluir la libreria jquery desde google. 
    //Si dispones de una copia local se puede desactivar.
    private $_useGoogleJquery = true;
    
    //FOR JS
    //Estos son parametros de configuración para el archivo: js_google_map_3.js

    //Mapa
    private $_sMapType = "'roadmap'"; //El tipo de mapa. 
    //Punto inicial de muestreo. Cuando se crea el mapa debe mostrar algún punto
    //he escogido las coord. de la Puerta del Sol (Madrid)
    private $_fLatitude = 40.41694; 
    private $_fLongitude = -3.70361;
    //El zoom
    private $_iZoom = 6;
    
    //Marcadores
    private $_arMarkers = "[]"; //Las chinchetas
    private $_useMakersNumbers = true; //Si las chinchetas mostrarán números.
    private $_sMarkerColor = "green";

    //Lineas
    //Indica si ha de pintarse lineas entre las chinchetas (Markers).
    private $_drawLines = false;
    
    //Lienzo 
    //Elemento div donde se mostrará el mapa generado.
    private $_sIdDivContainer = "'map_canvas'";
    //Configuración del tamaño del mapa y su unidad. 
    private $_iWidth = 800;
    private $_iHeight = 600;
    private $_sUnitWH = "px";
    
    //Rutas
    private $_sRouteMode = "driving";
    private $_drawRoutes = false;
    private $_sRouteColor = "green";
    private $_fRouteAlpha = 0.5;
    private $_iRouteWidth = 3;    
    //FIN FOR JS
    
    
    //FOR PHP
    //Url para calculo de distancia en km y tiempo entre dos marcadores
    // 173.194.67.95 (era 173.194.78.95) en lugar de maps.googleapis.com porque el firewall lo bloquea
    //private $_sUrlApiDistanceMatrix = "http://173.194.67.95/maps/api/distancematrix/xml?";
    private $_sUrlApiDistanceMatrix = "http://maps.googleapis.com/maps/api/distancematrix/xml?";
    //Parametros para hacer peticiones de latitud y longitud de una dirección
    //Url para enviar peticiones por get. Devolvera un objeto xml
    private $_sUrlApiGeocode = "http://maps.googleapis.com/maps/api/geocode/xml";
    //Indica si se ha de acotar la busqueda de una dirección.
    //Evita que te encuentre una dirección equivalente en otro país.
    private $_doNarrowSearch = true;
    //Coordenadas de acotación de España. Peninsula y Canarias.
    //private $_arNarrowLat = array("min"=>24.654534254781115,"max"=>45.18786629495072);
    //private $_arNarrowLong = array("min"=>-19.80908203125, "max"=>4.3828125);
    private $_arNarrowLat = array("min"=>35,"max"=>43); //Eje Y
    private $_arNarrowLong = array("min"=>-9, "max"=>4); //Eje X
    
    //TODO: Direcciones a geolocalizar. Lo dejaré para otra versión.
    private $_arAddresses = array();
    //Indica si se ha de esperar x microsegundos a que responda la url de petición
    private $_useDelay = true;
    private $_iDelayTime = 250;
    
    //Indicadores del estado de la petición de geolocalización.
    private $_is_error = false;
    private $_message = "";
    private $_arRoutes = array();
    
    /**
     * Formato del array de marcadores:
       $arMarkers[]=array
       (
            "title"=>"un titulo ", Lo que se mostrara al pasar el raton
            "content"=>"<b>Un contenido</b>", El texto dentro del popup de dialogo
            "latitude"=>"36.643271085342",
            "longitude"=>"-4.578660819468"
        );
     * @param array $arRutas Array anidado tipo tabla filas x columnas 
     * @param array $arAddresses TODO próxima entrega ;0) 
     */
    public function __construct($arRutas=array(),$arAddresses=array(),$sApikey="") 
    { 
        $this->_arRoutes = $arRutas;
        $this->_arAddresses = $arAddresses;
        if(!empty($sApikey)) $this->_sApikey = $sApikey;
    }
    
    //Pasa al objeto javascript los datos configurados en esta clase y despues
    //ejecuta load_map(), función javascript que dibuja el mapa con los datos
    //de configuración.
    public function draw_map()
    {
        //bug($this); die;
        if($this->_useGoogleJquery) $this->show_google_jquery_tag();
        //Muestra el tag <script> que importa la api v3 en js de gmaps
        $this->show_jsapi_v3_tag();
 ?>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/styledmarker/src/StyledMarker.js"></script>
<script type="text/javascript">
    //Configurando el objeto gmaps3
    //Mapa
    gmaps3.config.sMapType = <?php $this->get_maptype(); ?>;
    gmaps3.config.fLatitude = <?php $this->get_latitude(); ?>;
    gmaps3.config.fLongitude = <?php $this->get_longitude(); ?>;
    gmaps3.config.iZoom = <?php $this->get_zoom(); ?>;
    //Rutas
    gmaps3.config.arRoutes = <?php $this->show_js_array_routes(); ?>;
    gmaps3.config.useMarkersNumbers = <?php $this->is_makers_with_numbers(); ?>;
    //gmaps3.config.sMarkerColor = <?php $this->get_marker_color(); ?>;
    //Lineas
    gmaps3.config.drawLines = <?php $this->do_draw_lines(); ?>;
    //Lienzo
    gmaps3.config.sIdDivContainer = <?php $this->get_div_container(); ?>;
    gmaps3.config.iHeight = <?php $this->get_height(); ?>;
    gmaps3.config.iWidth = <?php $this->get_width(); ?>;
    gmaps3.config.sUnitWH = <?php $this->get_size_unit(); ?>;
    //Rutas
    gmaps3.config.sRouteMode = <?php $this->get_route_type(); ?>;
    gmaps3.config.drawRoutes = <?php $this->do_draw_routes(); ?>;
    gmaps3.config.sRouteColor = <?php $this->get_route_color(); ?>;
    gmaps3.config.iRouteWidth = <?php $this->get_route_width(); ?>;
    gmaps3.config.fRouteAlpha = <?php $this->get_route_alpha(); ?>;
    
    //bug(gmaps3,"gmaps3"); //La función bug es equivalente a console.debug
    //bug(gmaps3.config.arMarkers,"markers");
    jQuery(document).ready(gmaps3.load_map);
</script>
<?php
    }
    
    /** 
     * Imprime en pantalla un array javascript de dos dimensiones.
     */
    public function show_js_array_routes()
    {
        echo $this->get_js_as_array_from_routes();
    }
    
    private function get_js_as_array_from_routes()
    {
        $arJsRoutes = array();
        $sJsArray = "[";
        foreach($this->_arRoutes as $arRouteData)
        {
            $sJsRoute = "[";
            //Todos los puntos con sus datos
            $sJsRoute .= $this->get_js_as_array_table_from_markers($arRouteData["dots"]);
            //Los indices de esos puntos que indican que son las paradas
            $sJsRoute .= ",".$this->get_js_as_array_list_of_stops($arRouteData["stops"]);
            $sJsRoute .= ",".$this->get_as_js_string($arRouteData["pincolor"]);
            $sJsRoute .= ",".$this->get_as_js_string($arRouteData["tracecolor"]);
            $sJsRoute .= "]";
            $arJsRoutes[] = $sJsRoute;
        }
        if(!empty($arJsRoutes))
            $sJsArray .= implode(",",$arJsRoutes);
        //$arMarkers = $arRoutes
        $sJsArray .= "]";
        return $sJsArray;
    }
    
    private function get_js_as_array_table_from_markers($arMarkers)
    {
        if(empty($arMarkers))$arMarkers=$this->_arMarkers;
        $arItems = array();
        $sJsArray = "[";
        foreach($arMarkers as $arRow)
            $arItems[] = $this->get_as_js_array_row($arRow);

        if(!empty($arItems)) $sJsArray .= implode(",",$arItems);
        $sJsArray .= "]";
        return $sJsArray; 
    }
    
    private function get_js_as_array_list_of_stops($arStops)
    {
        $sJsArray = "[";
        $sJsArray .= implode(",", $arStops);
        $sJsArray .= "]";
        return $sJsArray; 
    }
    
    /* DEPRECATED
     * Imprime en pantalla un array javascript de dos dimensiones.
     */
    private function show_js_array_table()
    {
        echo $this->get_js_as_array_table();
    }

    /* DEPRECATED
     * Devuelve un string js con el formato de un array generado desde 
     * $this_arMarkers
     */
    private function get_js_as_array_table()
    {
        $arTable = $this->_arMarkers;
        //bug($arTable,"a pasar a js");
        $arItems = array();
        $sJsArray = "[";
        foreach($arTable as $arRow)
            $arItems[] = $this->get_as_js_array_row($arRow);

        if(!empty($arItems)) $sJsArray .= implode(",", $arItems);
        $sJsArray .= "]";
        return $sJsArray;
    }

    /**
     * Se le pasa un array de tipo columnas y lo convierte en array js
     * @param array $arRowMarker tipo array("nombre_columna"=>"valor",..,)
     * @return string Cadena de texto en formato array 
     */
    private function get_as_js_array_row($arRowMarker=array())
    {
        $arItems = array();
        $sJsArray = "[";
        foreach($arRowMarker as $key=>$sFieldValue)
        {
            switch($key) 
            {
                case "content":
                case "title":
                    $arItems[] = $this->get_as_js_string($sFieldValue);
                break;
                case "number":
                case "latitude":
                case "longitude":
                case "zindex":
                    $arItems[] = $sFieldValue;
                break;
            }
        }
        if(!empty($arItems)) $sJsArray .= implode(",", $arItems);
        $sJsArray .= "]\n";
        return $sJsArray;
        //['sTitle', fLat, fLong, iZindex, sContent, iIconNumber]
    }
    
    /**
     * Se utiliza para generar un array de substrings
     * @param string $sValue
     * @return string algo como '1'. Asi js lo entenderá como un string.
     */
    private function get_as_js_string($sValue){return "'$sValue'";}
    
    /**
     *
     * @param array $arPoint1 array("latitude"=>valor,"longitude"=>valor)
     * @param array $arPoint2 array("latitude"=>valor,"longitude"=>valor)
     * @return float distancia redondeada a dos decimales. 
     */
    public function distance_calculation(array $arPoint1, array $arPoint2)
    {
        $fX1 = $arPoint1["latitude"];
        $fY1 = $arPoint1["longitude"];
        $fX2 = $arPoint2["latitude"];
        $fY2 = $arPoint2["longitude"];
        
        if(is_numeric($fX1)&&is_numeric($fY1)&&is_numeric($fX2)&&is_numeric($fY2))
            $fX1 = sqrt(pow(($fX1 - $fX2),2) + pow(($fY1-$fY2),2));
        $fX1 = round($fX1, 2);
        return (float)$fX1;
    }
    
    /**
     * Calcula el tiempo y distancia entre dos puntos 
     * @param array $arPoint1 array(latitude, longitude)
     * @param array $arPoint2 array(latitude, longitude)
     */
    public function get_distance_and_time(array $arPoint1, array $arPoint2)
    {
        //bug($arPoint1); bug($arPoint2);
        $arTimeDistance = array("time"=>"","distance"=>"");
        $fX1 = $arPoint1["latitude"];
        $fY1 = $arPoint1["longitude"];
        $fX2 = $arPoint2["latitude"];
        $fY2 = $arPoint2["longitude"];
        
        $arParams = array();
        
        if(!empty($this->_sClientId) )$arParams["clientid"]="client=$this->_sClientId";
        if(!empty($this->_sChannel)) $arParams["channel"]="channel=$this->_sChannel";
        $arParams["sensor"] = "sensor=false";
        //La tuberia me fastidiaba la peticion. Solo se debe usar para los arrays de puntos.
        $arParams["origins"] = "origins=$fX1,$fY1"; //longitud, latitud
        $arParams["destinations"] = "destinations=$fX2,$fY2";
        $arParams["mode"] = "mode=driving";
        $arParams["language"] = "language=es-ES";
        //este parametro ayuda a diferenciar las distintas aplicaciones que hacen la petición
        
        $arParams = implode("&",$arParams);
        //http://maps.googleapis.com/maps/api/distancematrix/xml?
        $sUrlDistanceOrig = $this->_sUrlApiDistanceMatrix.$arParams;
        $sUrlDistanceSigned = $this->get_url_by_keypriority($sUrlDistanceOrig);
        //writelog("bd_ask",$sUrlDistance,"distancematrix request");
        
        //$sUrlDistance = "http://173.194.67.95/maps/api/distancematrix/xml?origins=40.356036037274,-3.686662625685&destinations=40.356083897923,-3.686544105619&mode=driving&language=es-ES&sensor=false&client=gme-telynetsa&signature=XBqNzocRJzYp0gIFi4Dx0kUoxd4=";
        $oXml = simplexml_load_file($sUrlDistanceSigned);
        //Si no ha funcionado la url con firma. Se prueba la gratuita. A veces funciona con 
        if($oXml==false) 
        {
            writelog("bd_ask",$sUrlDistanceSigned,"distancematrix error obtencion xml");
            $sUrlDistanceSigned = $sUrlDistanceOrig;
            //llamada con url gratuita
            $oXml = simplexml_load_file($sUrlDistanceSigned);
        }
        //bug($oXml,"xml distance matrix resultado $sUrlDistance"); die;
        if($oXml!=false)
        {
            $oXmlStatus = $oXml->status;
            //bug($oXmlStatus,"xmlstatus $sUrlDistance");
            //status ok. Se ha localizado la dirección
            if(strcmp($oXmlStatus,"OK") == 0)
            {
                
                $arTimeDistance["time"]["min"] = (string)$oXml->row->element->duration->text;//v3
                $arTimeDistance["time"]["sec"] = (string)$oXml->row->element->duration->value;
                $arTimeDistance["distance"]["m"] = (string)$oXml->row->element->distance->value;//v3
                //los kilomentros se redondean a dos decimales. 172m = 0.2km deberia ser 0.17 km
                //$arTimeDistance["distance"]["km"] = (string)$oXml->row->element->distance->text;//v3
                
                //fkm flotante para calculos matematicos. 
                $fDistanceInKm = ((float)$arTimeDistance["distance"]["m"])/1000;
                $fDistanceInKm = number_format($fDistanceInKm,3);
                $arTimeDistance["distance"]["fkm"] = $fDistanceInKm;
                //km en formato internacionalizacion España
                $arTimeDistance["distance"]["km"] = number_format($fDistanceInKm,2);
                $arTimeDistance["distance"]["km"] = str_replace(".",",",$arTimeDistance["distance"]["km"]);
                $arTimeDistance["distance"]["km"] .=" km";
                writelog("bd_ask",$sUrlDistanceSigned,"distancematrix ok");
            }
            //status de xml fallido
            else
            {
                $this->set_message_error("La distancia entre $arParams[origin] y $arParams[destination] no se pudo calcular. Estado=$oXmlStatus");
                writelog("bd_ask",$sUrlDistanceSigned,"distancematrix xml status fallido");
            }
        }
        //error en simplexml_load_file
        else
        {
            $this->set_message_error("No se ha podido crear xml desde: $sUrlDistanceSigned");
            writelog("bd_ask",$sUrlDistanceSigned,"distancematrix error obtencion xml");
        }
        //bug($oXml->row->element->distance,"distance object");
        //bug($arTimeDistance);
        return $arTimeDistance;
    }
    
    /*
     * Dependiendo de los datos de las chinchetas se va calculando las distancias
     * ojo, NO EL RECORRIDO.
     */
    public function sum_distance()
    {
        $arPoint1 = array("latitude"=>0,"longitude"=>0);
        $arPoint2 = array("latitude"=>0,"longitude"=>0);
        $iNumMarkers =count($this->_arMarkers);
        $fDistance = 0;
        for($i=0; $i<$iNumMarkers-1; $i++)
        {
            $arPoint1["latitude"] = $this->_arMarkers[$i]["latitude"];
            $arPoint1["longitude"] = $this->_arMarkers[$i]["longitude"];                
            $arPoint2["latitude"] = $this->_arMarkers[$i+1]["latitude"];
            $arPoint2["longitude"] = $this->_arMarkers[$i+1]["longitude"];
            $fDistance += $this->distance_calculation($arPoint1, $arPoint2);
        }
        return (float)$fDistance;
    }

    private function is_distance_in_km($sText)
    {
        if(strpos($sText,"km")!== false)
            return true;
        return false;
    }
    
    //http://gmaps-samples.googlecode.com/svn/trunk/urlsigning/UrlSigner.php-source
    //GOOGLE owns: Encode a string to URL-safe base64
    private function encodeBase64UrlSafe($value)
    {
        return str_replace(array("+", "/"), array("-", "_"), base64_encode($value));
    }

    // Decode a string from URL-safe base64
    //GOOGLE owns
    private function decodeBase64UrlSafe($value)
    {
        return base64_decode(str_replace(array("-", "_"),array("+", "/"),$value));
    }

    // Sign a URL with a given crypto key
    // Note that this URL must be properly URL-encoded
    //GOOGLE owns
    public function get_encoded_signature($sUrlEncoded,$sCryptokey)
    {
        //parse_url parte la url en sus componentes
        $arUrlComponents = parse_url($sUrlEncoded);
        $urlPartToSign = $arUrlComponents["path"] . "?" . $arUrlComponents["query"];
        // Decode the private key into its binary format
        $sBinDecodedCryptokey = $this->decodeBase64UrlSafe($sCryptokey);
        // Create a signature using the private key and the URL-encoded
        // string using HMAC SHA1. This signature will be binary.
        $sSignature = hash_hmac("sha1",$urlPartToSign, $sBinDecodedCryptokey,true);
        $sEncodedSignature = $this->encodeBase64UrlSafe($sSignature);
        return $sEncodedSignature;
    }
    
    /**
     * Crea una url codificada con la firma que le corresponde a la cryptokey
     * @param string $sUrlEncoded tipo: http://maps.google.com/maps/api/geocode/json?address=New+York&sensor=false&client=clientID
     * @param string $sCryptokey vNIXE0xscrmjlyV-12Nj_BvUPaw
     * @return string http://maps.google.com/maps/api/geocode/json?address=New+York&sensor=false&client=clientID&signature=xxxsignaturexxx
     */
    public function get_url_signed($sUrlEncoded, $sCryptokey)
    {
        $sEncodedSignature = $this->get_encoded_signature($sUrlEncoded,$sCryptokey);
        return $sUrlEncoded."&signature=".$sEncodedSignature;
    }
    
    /**
     * Si se aplica la firma devuelve la url + client + signature
     * sino se asume que la url lleva client, con esta se genera una firma y se devuelve la url pasada + signature 
     * @param string $sUrlEncoded Al menos lleva el parametro ?sensor=false. No debe llevar client=Client_ID
     * @return string url con tipo: http://..?sensor=false..&signature=encodedsignature
     */
    private function get_url_by_keypriority($sUrlEncoded)
    {
        //bug($sUrlEncoded,"url a firmar");
        if(!empty($sUrlEncoded))
        {
            //Si se proporciona la firma y se ha especificado su uso no se evalua ninguna otra condición
            if(!empty($this->_sSignature) && $this->_useSignature)
                $sUrlEncoded .= "&client=$this->_sClientId&signature=$this->_sSignature";
            //En segundo nivel se comprueba la criptokey (pago plan empresarial)
            elseif(!empty($this->_sCriptokey) && $this->_useCriptoKey)
            {
                $this->_sSignature = $this->get_encoded_signature($sUrlEncoded, $this->_sCriptokey);
                $sUrlEncoded .= "&signature=$this->_sSignature";
            }
            //Despues se verifica la apikey (gratuita)
            elseif(!empty($this->_sApikey) && $this->_useApikey)
            {
                $sUrlEncoded .= "&key=$this->_sApikey";
            }
        }
        return $sUrlEncoded;
    }

    /**
     * Imprime en pantalla la url con la apikey. 
     * Si se desea firmar hay que pasar la criptokey habilitar el objeto para su uso con use_criptokey
     * @param string $sUrlEncoded url con el clientid si se quiere imprimir con firma
     */
    public function show_url_by_keypriority($sUrlEncoded)
    {
        echo $this->get_url_by_keypriority($sUrlEncoded);
    }
    
    public function show_google_jquery_tag(){echo $this->get_google_jquery();}
    
    public function show_apikey_tag(){echo $this->get_apikey_tag();}

    //echo $this->build_url_signed("http://maps.google.com/maps/api/geocode/json?address=New+York&sensor=false&client=clientID","vNIXE0xscrmjlyV-12Nj_BvUPaw=");
//======================    
//       GETTERS
//======================
    public function get_markers(){return $this->_arMarkers;}
    public function is_makers_with_numbers()
    {
        if($this->_useMakersNumbers) echo "true";
        else echo "false";
    }
    
    public function do_draw_lines()
    {
        if($this->_drawLines) echo "true";
        else echo "false";
    }
    
    private function do_draw_routes(){if($this->_drawRoutes) echo "true"; else echo "false";}
    
    /**
     * Segun un array con datos de una dirección se recupera su latitud y longitud
     * @param array $arAddress array("pais"=>"España","direccion"=>"Conde de Peñalver 32", "zona"=>"Madrid", "cp"=>"28006");
     */
    public function get_latlong_from_address(array $arAddress)
    {
        //bug("get latlong from addres"); die;
        $arLl = array("latitude"=>"","longitude"=>"");
        
        if(!empty($arAddress))
        {
            $sUrlApiGeocode = $this->_sUrlApiGeocode;
            //Une con comas el array
            $sAddrForUrl = join(", ",$arAddress);
            //codifica el string en utf
            $sAddrForUrl = utf8_encode($sAddrForUrl);
            //codifica el string en formato url
            $sAddrForUrl = urldecode($sAddrForUrl);
            //sustituye espacios por el caracter +
            $sAddrForUrl = str_replace(" ", "+", $sAddrForUrl);
            //TODO se deberia adaptar esta url para usar la apikey privada o la firma única (signature)
            $sUrlApiGeocode = $sUrlApiGeocode."?address=".$sAddrForUrl."&sensor=false";
            //bug($sUrlApiGeocode);
            $oXml = simplexml_load_file($sUrlApiGeocode);
            //bug($oXml); die;
            
            //Dependiendo de cuanto esté ocupado el servidor de google puede tardar mas ó menos. 
            //Para asegurarnos que se cree correctamente el objeto xml con los detalles de la dirección pedida
            //forzamos a que el archivo espere unos instantes
            if($this->_useDelay) usleep($this->_iDelayTime);//microsegundos
            
            if($oXml!=false)
            {
                //bug($oXml,"oXml get_latlong_from_address");
                $oXmlStatus = $oXml->status;
                
                //status ok. Se ha localizado la dirección
                if(strcmp($oXmlStatus,"OK") == 0)
                {
                    $fLatitude = $oXml->result->geometry->location->lat;//v3
                    $fLongitude = $oXml->result->geometry->location->lng;//v3
                    $fLatitude = (float) $fLatitude;
                    $fLongitude = (float) $fLongitude;
                    //bug($fLatitude,"latitud X"); bug($fLongitude,"longitud Y");
                    if($this->_doNarrowSearch)
                    {    
                        if($this->is_in_range_latlong($fLatitude, $fLongitude))
                        {
                            $arLl["latitude"]=$fLatitude; $arLl["longitude"]=$fLongitude;
                            $this->_message = "Dirección encontrada";
                        }
                        //fuera de rango
                        else
                        {
                            //bug("fuera de rango");
                            $this->set_message_error("Dirección fuera de rango: Lat:$fLatitude, Long:$fLongitude");
                        }
                    }
                    //No se usa acotación
                    else
                    {
                        $arLl["latitude"]=$fLatitude; $arLl["longitude"]=$fLongitude;
                        $this->_message = "Dirección encontrada";
                    }
                }
                //status de xml fallido
                else
                {
                    $this->set_message_error("La dirección $sAddrForUrl no se pudo geolocalizar. Estado=$oXmlStatus");
                }
            }
            //error en simplexml_load_file
            else
            {
                $this->set_message_error("No se ha podido crear xml desde: $sUrlApiGeocode");
            }

        }
        return $arLl;
    }
    
    /**
     * Determina si las coordenadas obtenidas de una dirección está dentro de los limites
     * de acotación
     * @param float $fLatitude 
     * @param float $fLongitude
     * @return boolean 
     */
    private function is_in_range_latlong($fLatitude=0.0,$fLongitude=0.0)
    {
        //bug($this->_arNarrowLat,"lat"); bug($fLatitude,"lat"); bug($this->_arNarrowLong,"long"); bug($fLongitude,"long");
        //bug($this->compare_float($fLatitude,"<",$this->_arNarrowLat["max"]),"lat < latmax?");
        //bug($this->compare_float($this->_arNarrowLat["min"],"<",$fLatitude),"latmin > latitude?");
        //bug($this->compare_float($fLongitude,"<",$this->_arNarrowLong["max"]),"long < longmax?");
        //bug($this->compare_float($this->_arNarrowLong["min"],"<",$fLongitude),"longmin > longitude?");
        $isInRange = 
        (
            $this->compare_float($fLatitude,"<",$this->_arNarrowLat["max"]) &&
            $this->compare_float($this->_arNarrowLat["min"],"<",$fLatitude) &&

            $this->compare_float($fLongitude,"<",$this->_arNarrowLong["max"]) &&
            $this->compare_float($this->_arNarrowLong["min"],"<",$fLongitude)                 
        );
        return $isInRange;
    }
    
    /**
     * Función para comparar números en coma flotante (eaf)
     * La comparación de números en coma flotante no es tribial. No se puede 
     * utilizar por ejemplo: $float1>$float2... es decir, los operadores comunes.
     * Esta función pasa los numeros a binarios con una precision marcada
     * @param float $float1
     * @param char $cOperator =, <, >, <=, >= !=
     * @param float $float2 
     * @param integer $iPrecision 
     * @return boolean o "operator error";
     */
    private function compare_float($float1,$cOperator="=",$float2,$iPrecision=10)
    {
        //Siempre la comparación se hace de float1 con respecto a float1
        // si el resultado es: 0 son igulaes, -1 f1 menor, 1 f1 mayor
        switch (trim($cOperator)) 
        {
            case "=":
                return bccomp($float1, $float2, $iPrecision)==0;
            break;
            case "<":
                return bccomp($float1, $float2, $iPrecision)==-1;
            break;
            case ">":
                return bccomp($float1, $float2, $iPrecision)==1;
            break;
            case "!=":
                return !(compare_float($float1,"=",$float2, $iPrecision));
            break;        
            case ">=":
                return compare_float($float1,">",$float2, $iPrecision)
                    ||compare_float($float1,"=",$float2, $iPrecision);
            break;
            case "<=":
                return compare_float($float1,"<",$float2, $iPrecision)
                    ||compare_float($float1,"=",$float2, $iPrecision);
            break;

            default:
                return "operator error";
            break;
        }
    }
    
    /*
     * Devuelve el string con tag script haciendo referencia al archivo jquery del repositorio de 
     * google
     */
    public function get_google_jquery()
    {
        $sTagJquery = "<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js\"></script>\n";
        return $sTagJquery;     
    }
    
    public function get_apikey_tag()
    {
        $sApiUrl = "<script type=\"text/javascript\" src=\"noapikeysuplied\"></script>";
        //bug($this->_sApikey);
        if(!empty($this->_sApikey))
            //http://maps.googleapis.com/maps/api/js?v3&key=YOUR_API_KEY&sensor=TRUE_OR_FALSE&callback=initialize
            $sApiUrl = "<script type=\"text/javascript\" src=\"http://maps.googleapis.com/maps/api/js?v=3&sensor=false\"></script>\n";
        return $sApiUrl;
    }
    
    public function get_jsapi_v3_tag()
    {
        //https://developers.google.com/maps/documentation/business/guide#Accessing
        //url demo:   http://maps.googleapis.com/maps/api/js?v=3&client=gme-yourclientid&sensor=true_or_false&channel=yourchannel
        $sUrlJsApi = "http://maps.googleapis.com/maps/api/js?v=3&sensor=false";
        if(!empty($this->_sClientId))$sUrlJsApi .= "&client=$this->_sClientId";
        if(!empty($this->_sChannel)) $sUrlJsApi .= "&channel=$this->_sChannel";
        //no es necesario usar firma
        //$sUrlJsApi = $this->get_url_by_keypriority($sUrlJsApi);
        $sKeyTag = "<script type=\"text/javascript\" src=\"$sUrlJsApi\"></script>\n";
        return $sKeyTag;
    }
     
    public function show_jsapi_v3_tag()
    {
        echo $this->get_jsapi_v3_tag();
    }
    
    private function get_maptype(){echo $this->_sMapType;}
    private function get_div_container(){echo $this->_sIdDivContainer;}
    private function get_zoom(){echo $this->_iZoom;}
    private function get_latitude(){ echo $this->_fLatitude; }
    private function get_longitude(){ echo $this->_fLongitude; }
    private function get_height(){echo $this->_iHeight;}
    private function get_width(){echo $this->_iWidth;}
    private function get_size_unit(){echo "'$this->_sUnitWH'";}
    private function get_route_type(){echo "'$this->_sRouteMode'";}
    private function get_route_color(){echo "'$this->_sRouteColor'";}
    private function get_route_width(){echo $this->_iRouteWidth;}
    private function get_route_alpha(){echo $this->_fRouteAlpha;}
    private function get_marker_color(){echo "'$this->_sMarkerColor'";}

    public function get_message(){return $this->_message;}
    public function get_apikey(){ return $this->_sApikey;}    
    public function get_signature(){ return $this->_sSignature;}
    

//======================    
//       SETTERS
//======================
    
    //TODO Corregir en el futuro
    public function set_markers($arMarkers=array()){ $this->_arMarkers = $arMarkers; }
    public function set_markers_numbers_off($isOn=false){$this->_useMakersNumbers = $isOn;}
    
    public function set_maptype($sValue){$this->_sMapType = strtolower("'$sValue'");}
    public function set_div_container($sValue){ $this->_sIdDivContainer = "'$sValue'"; }
    public function set_zoom($iZoom){ $this->_iZoom = $iZoom; }
    public function set_latitude($fLatitude){ $this->_fLatitude = $fLatitude; }
    public function set_longitude($fLongitude){ $this->_fLongitude = $fLongitude; }
    public function draw_lines($isOn=true){ $this->_drawLines = $isOn; }
    public function set_size_container($iWidth=800,$iHeight=600)
    {
        if(!empty($iHeight))$this->_iHeight = $iHeight;
        if(!empty($iWidth)) $this->_iWidth = $iWidth;        
    }
    public function set_size_unit($sType="pt"){ $this->_sUnitWH = $sType; }
    public function add_address(array $arAddress){ $this->_arAddresses[] = $arAddress; }
    public function draw_routes($isOn=true){ $this->_drawRoutes = $isOn; }
    public function set_route_color($sColor="green"){$this->_sRouteColor = $sColor;}
    public function set_marker_color($sColor="green"){$this->_sMarkerColor = $sColor;}

    /**
     * @param string $sType driving, walking, bicycling
     */
    public function set_route_type($sType="driving"){$this->_sRouteMode = $sType;}
    
    public function set_route_width($iWidth=3){$this->_iRouteWidth = $iWidth;}
    public function set_route_alpha($fAlpha=0.5){$this->_fRouteAlpha = $fAlpha;}
    
    private function set_message_error($sMessage,$isError=true)
    {
        $this->_is_error = $isError;
        $this->_message = $sMessage;
    }
    /**
     * Solo influye para recuperar latitud y longitud de direcciones. 
     * No en el pintado de marcadores
     * @param boolean $isOn     
     */
    public function no_narrow($isOn=false){ $this->_doNarrowSearch = $isOn; }
    public function set_delay_time($iMicroSeconds){$this->_iDelayTime = $iMicroSeconds;}
    public function no_dalay($isOn=false){ $this->_useDelay = $isOn; }
    public function set_apikey($sApikey){$this->_sApikey = $sApikey;}
    public function no_auto_apikey($isOn=false){$this->_useApikey = $isOn;}
    public function no_google_jquery($isOn=false){$this->_useGoogleJquery = $isOn;}
    public function set_signature($sValue){$this->_sSignature=$sValue;}
    public function use_signature($isOn=true){$this->_useSignature = $isOn;}
    public function set_cryptokey($sValue){$this->_sCriptokey=$sValue;}
    public function use_cryptokey($isOn=true){$this->_useCriptoKey = $isOn;}    
    public function set_client_id($sId){$this->_sClientId=$sId;}
    public function set_channel($sChannelJs){$this->_sChannel=$sChannelJs;}
}
