<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Db\ComponentMssql 
 * @file component_mssql.php v1.4.1
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace TheFramework\Components\Db;

class ComponentMssql 
{
    private $arConn;
    private $isError;
    private $arErrors;    
    private $iAffected;
    
    public function __construct($arConn=[]) 
    {
        $this->isError = FALSE;
        $this->arErrors = [];
        $this->arConn = $arConn;
    }

    private function get_conn_string()
    {
        $arConn["sqlsrv:Server"] = (isset($this->arConn["server"])?$this->arConn["server"]:"");
        $arConn["Database"] = (isset($this->arConn["database"])?$this->arConn["database"]:"");
        $arConn["ConnectionPooling"] = (isset($this->arConn["pool"])?$this->arConn["pool"]:"0");
        
        $sString = "";
        foreach($arConn as $sK=>$sV)
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
            $oPdo->setAttribute(\PDO::SQLSRV_ATTR_ENCODING,\PDO::SQLSRV_ENCODING_UTF8);
            //$oPdo->setAttribute(\PDO::SQLSRV_ATTR_ENCODING, \PDO::SQLSRV_ENCODING_SYSTEM);
            $oCursor = $oPdo->query($sSQL);
            if($oCursor===FALSE)
            {
                $this->add_error("exec-error: $sSQL");
            }
            else
            {
                //var_dump($stmt);
                $arResult = [];
                while($arRow = $oCursor->fetch(\PDO::FETCH_ASSOC))
                    $arResult[] = $arRow;
                $this->iAffected = count($arResult);
            }
        }
        catch(PDOException $oE)
        {
            $sMessage = "exception:{$oE->getMessage()}";
            $this->add_error($sMessage);
        }
        return $arResult;
    }//query
    
    public function exec($sSQL)
    {
        try 
        {
            $sConn = $this->get_conn_string();
            //https://stackoverflow.com/questions/19577056/using-pdo-to-create-table
            $oPdo = new \PDO($sConn,$this->arConn["user"],$this->arConn["password"]);
            $oPdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION );  
            $mxR = $oPdo->exec($sSQL);
            $this->iAffected = $mxR;
            if($mxR===FALSE)
            {
                $this->add_error("exec-error: $sSQL");
            }
        }
        catch(PDOException $oE)
        {
            $sMessage = "exception:{$oE->getMessage()}";
            $this->add_error($sMessage);
        }
    }//exec    
    
    private function add_error($sMessage){$this->isError = TRUE;$this->iAffected=-1; $this->arErrors[]=$sMessage;}    
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
    
    public function add_conn($k,$v){$this->arConn[$k]=$v;}
    public function get_affected(){return $this->iAffected;}
    
}//ComponentMssql
