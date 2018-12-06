<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Motosceni\ComponentTickets 
 * @file component_tickets.php 2.0.0
 * @date 03-08-2018 21:00 SPAIN
 * @observations
 */
namespace TheFramework\Components\Motosceni;

use TheFramework\Components\Motosceni\BehaviourTickets;

class ComponentTickets 
{
    private $sToken;
    private $sAction;
    private $arKeyval;

    private $isError;
    private $arErrors;    
    
    public function __construct($sToken="") 
    {
        $this->isError = FALSE;
        $this->arErrors = [];
        $this->arKeyval = [];
        $this->sToken = $sToken;
        $this->sAction = "";
    }//__construct
    
    public function get_data()
    {
        $sJson = "{}";
        switch($this->sAction)
        {
            case "get-orders":
                $sJson = $this->get_orders();
            break;

            case "get-detail":
                $sJson = $this->get_detail($this->arKeyval["id_order"]);
            break;
        
            default:
                $sJson = "{\"error\":\"wrong action\"}";
        }
        return $sJson;
    }//get_data

    public function get_orders()
    {
        $oBehav = new BehaviourTickets();
        $arRows = $oBehav->get_orders_20();

        $arJson = [];
        foreach($arRows as $i=>$arRow)
            $arJson[] = json_encode($arRow);
        
        return "[".implode(",",$arJson)."]";
    }//get_orders

    public function get_detail($idOrder)
    {
        if(!is_integer($idOrder))
            return "{\"error\":\"wrong id_order\"}";
        $oBehav = new BehaviourTickets();
        $arRows = $oBehav->get_order_detail($idOrder);

        $arJson = [];
        foreach($arRows as $i=>$arRow)
            $arJson[] = json_encode($arRow);

        return "[".implode(",",$arJson)."]";            
    }//get_detail

    public function show_data(){echo $this->get_data();}
    
    public function is_tokenok()
    {
        $sToday = "ceni-".date("Ymd");
        $sMd5 = md5($sToday);
        $isToken = ($sMd5===$this->sToken);
        if(!$isToken) $this->add_error ("Wrong token: $this->sToken - $sMd5");
        return $isToken;
    }//is_tokenok
    
    public function debug($mxVar)
    {
        $sVar = var_export($mxVar,1);
        echo $sVar;
    }//debug

    public function add_keyval($sKey,$mxVal){$this->arKeyval[$sKey] = $mxVal;}
    public function set_action($value){$this->sAction=$value;}

    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}    
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){if($this->arErrors) echo "<pre>".var_export($this->arErrors,1);}

}//ComponentTickets
