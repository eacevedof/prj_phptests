<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Db\ComponentMssql 
 * @file component_mssql.php v1.0.1
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace TheFramework\Components\Db;

class ComponentMssql 
{
    private $arConn;
    
    public function __construct($arConn=[]) 
    {
        $this->arConn = $arConn;
    }

    private function get_conn_string()
    {
        $arCon["sqlsrv:Server"] = (isset($this->arConn["server"])?$this->arConn["server"]:"");
        $arCon["Database"] = (isset($this->arConn["database"])?$this->arConn["database"]:"");
        $arCon["ConnectionPooling"] = (isset($this->arConn["pool"])?$this->arConn["pool"]:"0");
        
        $sString = "";
        foreach($arCon as $sK=>$sV)
            $sString .= "$sK=$sV;";
        
        return $sString;
    }//get_conn_string

    public function query($sSQL)
    {
        try 
        {
            $sConn = $this->get_conn_string();
            //https://stackoverflow.com/questions/38671330/error-with-php7-and-sql-server-on-windows
            $oPdo = new \PDO($sConn,$this->arConn["user"],$this->arConn["password"]);
            $oPdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION );  
            //$oPdo->setAttribute(\PDO::SQLSRV_ATTR_ENCODING, \PDO::SQLSRV_ENCODING_SYSTEM);
            $oCursor = $oPdo->query($sSQL);
            //var_dump($stmt);
            while($arRow = $oCursor->fetch(\PDO::FETCH_ASSOC))
                $arResult[] = $arRow;
        }
        catch(PDOException $oE)
        {
            echo "<pre>exception {$oE->getMessage()} : $sSQL";
            //bug($oE->getMessage());
        }
        return $arResult;
    }//query
    
    public function add_conn($k,$v){$this->arConn[$k]=$v;}
    
}//ComponentMssql
