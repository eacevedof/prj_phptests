<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Db\ComponentDbSqlserver 
 * @file component_db_sqlserver.php v1.0.1
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace TheFramework\Components\Db;

class ComponentDbSqlserver 
{

    public function query()
    {
        $arDb["server"] = "EALEXEI-W7\MSSQLSERVER2012";
        //$arDb["server"] = "";
        $arDb["database"] = "crm3_flamagas";
        $arDb["user"] = "sa";
        $arDb["password"] = "Sasql2012";
           
        //bug($arDb);
        try
        {
            //https://stackoverflow.com/questions/38671330/error-with-php7-and-sql-server-on-windows
            $db = new \PDO("sqlsrv:Server={$arDb["server"]};Database={$arDb["database"]};ConnectionPooling=0"
                            ,$arDb["user"],$arDb["password"]);
            $db->setAttribute(\PDO::SQLSRV_ATTR_ENCODING, \PDO::SQLSRV_ENCODING_SYSTEM);
            $query =  "select * from core_users";
            foreach ($db->query($query) as $row)
            {
                print_r($row);
            }
        }
        catch(PDOException $oE)
        {
            echo "exception";
            //bug($oE->getMessage());
        }
    }
    
}//ComponentDbSqlserver


/*include("DB.php");
ini_set("mssql.datetimeconvert",0);*/

class crm {
 function db_connect($dsn="") {
		if($dsn=="") {
			//$dsn=$GLOBALS['config_dbtype'].":";
			//if($GLOBALS['config_dbuser']) $dsn.=$GLOBALS['config_dbuser'];
			//if($GLOBALS['config_dbpass']) $dsn.=":".$GLOBALS['config_dbpass'];
			//if($GLOBALS['config_dbuser']) $dsn.="@";
			//if($GLOBALS['config_dbtype']=="oci8") $dsn.=$GLOBALS['config_dbname'];
			//else $dsn.=$GLOBALS['config_dbhost']."/".$GLOBALS['config_dbname'];
			//$dsn.="host="$GLOBALS['config_dbhost'].";dbname=".$GLOBALS['config_dbname'];
		  $dsn="sqlsrv:Server=".$GLOBALS['config_dbhost'].";Database=".$GLOBALS['config_dbname'];
		}
		
		try {
    	$db = new PDO($dsn, $GLOBALS['config_dbuser'], $GLOBALS['config_dbpass']);
    	$db->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_SYSTEM);
			$this->db=$db;
			return $db;
		} catch (PDOException $e) {
			array_push($GLOBALS['global_error'],"01");
			writelog("error","crm::db_connect() - ".$dsn);
    	echo 'Falló la conexión: ' . $e->getMessage();
		}
}
 
 function disconnect($db,$res) {
  if(is_object($res)&&method_exists($res,"free")) $res->free();
  if(is_object($db)&&method_exists($db,"disconnect")) $db->disconnect();
}}

class recordset extends crm {
  var $row;
  var $start_fetch;

 function query($db,$sql_query,$op="") {
 	
	$res=$db->query(stripslashes($sql_query));
	$errorInfo=$res->errorInfo();
	if($errorInfo[0]!=0){
		if($op=="sync") {
    	array_push($GLOBALS['global_error'],"02");
    	writelog("sync",$sql_query);
   	}
   	else {
    	array_push($GLOBALS['global_error'],"02");
    	$log="recordset::query()"; if($op!="") $log.=" - ".$op; $log.=" - ".$sql_query." - ".$errorInfo[2];
    	writelog("error",$log);
  	}
	}
  elseif($op!=""&&$op!="integrity"&&$op!="sync") {
   if(ereg("^INSERT INTO ([^ ]+)",$sql_query,$reg)) writelog("bd_ask",$op." - ".$sql_query,$reg[1]);
   elseif(ereg("^UPDATE ([^ ]+)",$sql_query,$reg)) writelog("bd_ask",$op." - ".$sql_query,$reg[1]);
   elseif(ereg("^DELETE FROM ([^ ]+)",$sql_query,$reg)) writelog("bd_ask",$op." - ".$sql_query,$reg[1]);
  }
  return $res;
 }
/* function commit($db) {
  if(is_object($db)) {
   if($db->commit()!=DB_OK) writelog("sync","Error BD[commit]");
 }}

 function autoCommit($db,$stat) {
  if(is_object($db)) {
   if($db->autoCommit($stat)!=DB_OK) writelog("sync","Error BD[autocommit]");
 }}
*/
 function numRows($res) {
   return $res->rowCount();
 }

 function fetch_row($res,$num_row=NULL) {
		$this->row=$res->fetch(PDO::FETCH_ASSOC);
  	return $this->row;
 }

 function result($res,$field_name){
	$errorInfo=$res->errorInfo();
	if($errorInfo[0]!=0){
		array_push($GLOBALS['global_error'],"03");
  }
  else {
 		if($this->row==NULL) $this->row=$this->fetch_row($res);
		return(rtrim($this->row[$field_name]));
 	}
 }
 
 function freeResult($res) {
   $res->closeCursor();
 }
}
