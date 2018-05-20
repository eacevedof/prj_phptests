<?php
/**
 * ip_banned.php 1.2.0 20/05/2018 09:35
 * Recupera todas las ips de access.log y las muestra por pantalla
 * 
 */
$arBanned = [
    "31.204.150.58","36.89.21.211","40.125.165.226","43.252.221.97","45.115.172.132","54.158.245.85","62.24.109.128"
    ,"77.72.83.17","89.45.53.26","89.45.60.136","93.117.153.225","109.185.92.204","118.67.222.174","118.179.154.118"
    ,"119.10.72.41","120.77.36.71","143.255.242.157","143.137.162.134","151.243.10.237","171.100.81.74","177.39.14.82"
    ,"185.87.48.86","185.12.60.215","185.24.127.17","185.40.200.209","187.56.166.235","187.144.241.196","187.175.17.164"
    ,"188.212.242.116","189.225.152.27","189.129.98.232","190.94.144.2","190.94.140.67","190.94.136.36","190.94.148.186","190.94.141.122"
    ,"190.94.139.155","190.94.139.4","190.94.144.17","191.100.9.3","191.100.11.79","191.100.11.26","191.193.225.144","201.238.154.133"
    ,"201.238.155.23","201.110.29.224","201.68.62.8","201.238.155.99"
    ,"31.184.193.154","46.165.141.61","58.87.119.37","71.6.202.198","86.107.216.130","91.240.109.1","91.80.151.241","103.79.228.110"
    ,"103.214.171.3","115.69.219.98","122.114.57.243","139.162.190.133","139.162.119.197","141.212.122.81","172.104.108.109"
    ,"185.122.144.166","187.150.216.119","187.110.212.32","189.163.125.102","189.50.199.76","190.94.140.234","190.94.139.195"
    ,"191.255.88.88","200.232.155.210","207.102.138.158","220.178.5.101","220.116.181.213"
];
//$arBanned = [];
$sIpFrom = $_SERVER["REMOTE_ADDR"];
$sDirDS = dirname(__FILE__).DIRECTORY_SEPARATOR;
$sPathLog = $sDirDS."access.log";
if(is_file($sPathLog) && isset($_GET["showips"]))
{
    echo "<pre>your ip: $sIpFrom ";
    echo "";
    $sContent = file_get_contents($sPathLog);
    $arLines = explode("\n",$sContent);
    
    $arIps = [];
    foreach($arLines as $i=>$sLine)
    {
        $iPos = strpos($sLine," - - [");
        if($iPos!==FALSE)
        {
            $sIp = substr($sLine,0,$iPos);
            if(!(in_array($sIp,array_column($arIps,"ip")) || in_array($sIp,$arBanned))) 
            {
                //$sWs = "http://api.ipinfodb.com/v3/ip-city/?key=$your_key&ip=$sIp&format=json";
                $sWs = "http://www.geoplugin.net/json.gp?ip={$sIp}";
                $sJson = file_get_contents($sWs);
                $arData = json_decode($sJson,TRUE);
                //print_r($arData);die;
                $arIps[] = ["ip"=>$sIp,"country"=>$arData["geoplugin_countryName"]];
                sleep(1);
            }//if new ip
        }//if(pos)
    }//foreach($arLines)
   
    uasort($arIps,function($a1,$b1){
        //print_r($a1);print_r($b1);
        $a = explode(".",$a1["ip"]);
        $a = (int)$a[0];
        $b = explode(".",$b1["ip"]);
        $b = (int)$b[0];
        
        if($a == $b) return 0;
        return ($a < $b) ? -1 : 1;
    });//uasort
    
    print_r($arIps);
    echo "==============";
    echo "add to array:";
    echo "==============";
    echo "\"".implode("\",\"", array_column($arIps,"ip"))."\"";
    echo "";
    //print_r($arIps);
    exit();
}//showips

if(in_array($sIpFrom,$arBanned)) die("Your ip $sIpFrom is banned");
