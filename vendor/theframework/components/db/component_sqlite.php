<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Db\ComponentDbSqlite 
 * @file component_db_sqlite.php v2.0.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace TheFramework\Components\Db;

class ComponentDbSqlite 
{
    /**
     * @var PDO
     */
    private static $oPDO;
    private $sDbName;
    private $sPathFolder;
    private $sPathFile;
    
    private $isError;
    private $isPersistent;
    private $iAffectedRows;
    
    const DS = DIRECTORY_SEPARATOR;
    
    public function __construct($sPathFolder="",$sDbName="app.sqlite3") 
    {
        $this->sPathFolder = $sPathFolder;
        $this->sDbName = $sDbName;
        
        if(!$this->sPathFolder) $this->sPathFolder = TFW_PATH_APPLICATIONDS."appdb";
        if(!$this->sDbName) $this->sDbName = "app.sqlite3";
        $this->isPersistent = TRUE;
    }

    private function is_configok()
    {
        $isOk = TRUE;
        $isOk = ($isOk && $this->sDbName);
        $isOk = ($isOk && is_file($this->sPathFile));
        return $isOk;
    }
    
    private function conn_open()
    {
        //pathfile
        $this->set_pathfile();
        if(!$this->is_configok())
        {
            $sMessage= "conn_open.error in config. Db:$this->sPathFile";
            $this->add_message($sMessage);
            return;
        }
        //data source name
        $sDSN = "sqlite:$this->sPathFile,charset=utf8mb4";
        try
        {
            //pr($sDSN,"DSN");
            self::$oPDO  = new \PDO($sDSN);
            self::$oPDO->setAttribute(\PDO::ATTR_TIMEOUT,3600);
        }
        catch (\PDOException $oE)
        {
            $sMessage = "PDO Exception: DSN:$sDSN, message:".$oE->getMessage();
            $this->add_message($sMessage);
        }
    }//conn_open
    
    public function execute($sSQL)
    {
        $isAffected = FALSE;
        
        if(trim($sSQL))
        {
            if($this->is_noterror())
            {
                $this->conn_open();
                if($this->is_noterror())
                {
                    $this->iAffectedRows = self::$oPDO->exec($sSQL);
                    if($this->iAffectedRows===FALSE)
                    {
                        $this->add_message("ERROR: PDO->exec(SQL)");
                        $this->add_message($sSQL);
                    }
                    $this->conn_close();
                }//if not error
            }//if not error
        }
        else 
        {
            $sMessage = "execute.sql empty";
            $this->add_message($sMessage);
        }
        return $isAffected;
    }//execute
    
    public function query($sSQL)
    {
        if(trim($sSQL))
        {
            if($this->is_noterror())
            {
                $this->conn_open();
                if($this->is_noterror())
                {
                    if(self::$oPDO)
                    {
                        $arRows = self::$oPDO->query($sSQL);
                        $this->conn_close();                        
                        return $arRows;
                    }
                }//if not error
            }//if not error
        }
        else 
        {
            $sMessage = "query.sql empty";
            $this->add_message($sMessage);
        }
        return [];
    }//query
    
    public function conn_close(){if(!$this->isPersistent)self::$oPDO = NULL;}
    
    private function add_message($sMessage,$sType="error")
    {
        if($sType==="error")
            $this->isError = TRUE;
        $this->arMessages[$sType][] = $sMessage;
    }  
    
    private function set_pathfile()
    {
        $this->sPathFile = realpath($this->sPathFolder.self::DS.$this->sDbName);
    }
    
    public function is_persistent($isOn=TRUE){$this->isPersistent=$isOn;}
    public function set_folder($sValue){$this->sPathFolder=$sValue;}
    public function set_dbname($sValue){$this->sDbName=$sValue;}
    public function get_errors(){return isset($this->arMessages["error"])?$this->arMessages["error"]:[];}     
    private function is_noterror(){return !$this->isError;}
    public function is_error(){return $this->isError;}
    public function get_debug(){return isset($this->arMessages["debug"])?$this->arMessages["debug"]:[];}
    public function get_affected_rows(){return $this->iAffectedRows;}
    public function reset_errors(){$this->arMessages["error"]=[];$this->isError = FALSE;}
    
}//ComponentDbSqlite