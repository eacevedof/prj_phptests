<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Motosceni\BehaviourTickets
 * @file behaviour_tickets.php 1.0.0
 * @date 03-08-2018 21:00 SPAIN
 * @observations
 */
namespace TheFramework\Components\Motosceni;

use TheFramework\Components\Db\ComponentMysql;

class BehaviourTickets 
{
    private $isError;
    private $arErrors;    
    
    private $arConn;
    
    public function __construct() 
    {
        $this->isError = FALSE;
        $this->arErrors = [];
        $arParams = include($_SERVER["DOCUMENT_ROOT"]."/app/config/parameters.php");
        $arParams = $arParams["parameters"];
        $this->arConn = ["server"=>$arParams["database_host"],"database"=>$arParams["database_name"]
                ,"user"=>$arParams["database_user"],"password"=>$arParams["database_password"]];
    }
    
    public function get_orders_20()
    {
        $sSQL= " -- BehaviourTickets.get_orders_20
        SELECT o.id_order,o.reference,o.id_cart,o.`date_add`,o.total_paid
        ,c.id_customer,c.firstname,c.lastname,c.email
        FROM cni_orders o
        LEFT JOIN cni_customer c
        ON o.id_customer = c.id_customer
        ORDER BY o.id_order DESC
        LIMIT 20
        ";
        $oDb = new ComponentMysql($this->arConn);
        $arRows = $oDb->query($sSQL);
        return $arRows;          
    }//get_orders_20

    public function get_order_detail($idOrder)
    {
        $sSQL= " -- BehaviourTickets.get_order_detail
        SELECT od.id_order_detail,od.id_order,od.product_name,od.product_quantity,od.total_price_tax_incl
        FROM cni_order_detail od
        WHERE 1=1
        AND id_order = $idOrder
        ORDER BY od.id_order ASC
        ";
        $oDb = new ComponentMysql($this->arConn);
        $arRows = $oDb->query($sSQL);
        return $arRows;  
    }//get_order_detail(idOrder)
   
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}    
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}

}//BehaviourTickets
