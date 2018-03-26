<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Db\ComponentDbMysql 
 * @file component_db_mysql.php v1.1.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace TheFramework\Components\Db;

class ComponentDbMysql 
{
    /**
     * @var mysqli
     */
    private static $oConn;    
    private $sDbServer;
    private $sDbUser;
    private $sDbPassword;
    private $sDbName;
    private $arMessages;

    private $isError;
    private $isPersistent;
    
    public function __construct($sDbName,$sDbPass,$sDbUser="root",$sDbServer="localhost") 
    {
        $this->sDbServer = $sDbServer;
        $this->sDbUser = $sDbUser;
        $this->sDbPassword = $sDbPass;
        $this->sDbName = $sDbName;
        $this->arMessages = [];
        $this->isError = FALSE;
        $this->isPersistent = FALSE;
    }
    
    private function is_configok()
    {
        $isOk = TRUE;
        $isOk = ($isOk && $this->sDbServer);
        $isOk = ($isOk && $this->sDbUser);
        $isOk = ($isOk && $this->sDbName);
        return $isOk;
    }
    
    private function conn_open()
    {
        if(!$this->is_configok())
        {
            $sMessage= "conn_open.error in config";
            $this->add_message($sMessage);
        }
        try
        {
            self::$oConn = new \mysqli($this->sDbServer
                    ,$this->sDbUser, $this->sDbPassword, $this->sDbName);
            //bug(self::$oConn);
            self::$oConn->set_charset("utf8mb4");
            if(self::$oConn->connect_error)
            {
                $sMessage = "conn_open.mysqli_connect error:".self::$oConn->connect_error();
                $this->add_message($sMessage);
            }
        }
        catch (mysqli_sql_exception $oE)
        {
            $sMessage = "Exception:".$oE->getMessage();
            $this->add_message($sMessage);
        }
    }
    
    private function add_message($sMessage,$sType="error")
    {
        if($sType==="error")
            $this->isError = TRUE;
        $this->arMessages[$sType][] = $sMessage;
    }
    
    private function conn_close()
    {
        if(self::$oConn->ping() && !$this->isPersistent)
            self::$oConn->close();
    }
    
    public function query($sSQL)
    {
        if(trim($sSQL))
        {
            $this->conn_open();
            if(self::$oConn->ping())
            {
                $oResult = self::$oConn->query($sSQL);
                $arRows = [];
                while($arRow = $oResult->fetch_assoc()) 
                    $arRows[] = $arRow;
                $oResult->free();
                return $arRows;
            }
            $this->conn_close();   
        }
        else 
        {
            $sMessage = "query.sql empty";
            $this->add_message($sMessage);
        }
        return [];
    }//query
    
    public function is_persistent($isOn=TRUE){$this->isPersistent=$isOn;}
    public function set_server($sValue){$this->sDbServer=$sValue;}
    public function set_user($sValue){$this->sDbUser=$sValue;}
    public function set_password($sValue){$this->sDbPassword=$sValue;}
    public function set_dbname($sValue){$this->sDbName=$sValue;}
    public function get_errors(){return isset($this->arMessages["error"])?$this->arMessages["error"]:[];}
    
}//ComponentDbMysql