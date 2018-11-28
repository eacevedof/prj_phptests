<?php
namespace TheFramework\Components\Db;

//ComponentCrud 2.0.0 - 28/11/2018
class ComponentCrud
{
    private $sSQL;
    private $sSQLComment;
    private $sTable; //Tabla sobre la que se realizará el crud
    private $arInsertFV;
    
    private $arUpdateFV;
    private $arPksFV;
    private $arGetFields;
    
    private $oDB;
    
    public function __construct($oDB=NULL)
    { 
        $this->arInsertFV = array();
        $this->arUpdateFV = array();
        $this->arPksFV = array();
        $this->arGetFields = array();
        $this->oDB = $oDB;
    }
    
    public function autoinsert($sTable=NULL,$arFieldVal=array())
    {
        //Limpio la consulta 
        $this->sSQL = "-- autoinsert";
        
        if($this->sSQLComment)
            $sSQLComment = "/*$this->sSQLComment*/";
        
        if(!$sTable)
            $sTable = $this->sTable;
        
        if($sTable)
        {
            if(!$arFieldVal)
                $arFieldVal = $this->arInsertFV;
            
            if($arFieldVal)
            {    
                $sSQL = "$sSQLComment INSERT INTO ";
                $sSQL .= "$sTable ( ";

                $arFields = array_keys($arFieldVal);
                $sSQL .= implode(",",$arFields);

                $arValues = array_values($arFieldVal);
                //los paso a entrecomillado
                foreach ($arValues as $i=>$sValue)
                {
                    if($sValue===NULL)
                        $arAux[] = "NULL";
                    else
                        $arAux[] = "'$sValue'";
                }

                $sSQL .= ") VALUES (";
                $sSQL .= implode(",",$arAux);
                $sSQL .= ")";
                
                $this->sSQL = $sSQL;
                if(is_object($this->oDB))
                    $this->oDB->exec($this->sSQL);
            }//si se han proporcionado correctamente los datos campo=>valor
        }//se ha proporcionado una tabla
    }//autoinsert
    
    public function autoupdate($sTable=NULL,$arFieldVal=array(),$arPksFV=array())
    {
        //Limpio la consulta 
        $this->sSQL = "-- autoupdate";
        
        if($this->sSQLComment)
            $sSQLComment = "/*$this->sSQLComment*/";
        
        if(!$sTable)
            $sTable = $this->sTable;
        
        if($sTable)
        {
            if(!$arFieldVal)
                $arFieldVal = $this->arUpdateFV;
            if(!$arPksFV)
                $arPksFV = $this->arPksFV;
            
            if($arFieldVal && $arPksFV)
            {    
                $sSQL = "$sSQLComment UPDATE $sTable ";
                $sSQL .= "SET ";

                //creo las asignaciones de campos set extras
                $arAux = array();
                foreach($arFieldVal as $sField=>$sValue)
                {    
                    if($sValue===NULL)
                        $arAux[] = "$sField=NULL";
                    else
                        $arAux[] = "$sField='$sValue'";
                }

                $sSQL .= implode(",",$arAux);
                
                //condiciones con las claves
                $arAux = array();
                foreach($arPksFV as $sField=>$sValue)
                {    
                    if($sValue===NULL)
                        $arAux[] = "$sField IS NULL";
                    else
                        $arAux[] = "$sField='$sValue'";
                }
                
                $sSQL .= " WHERE ".implode(" AND ",$arAux);
                
                $this->sSQL = $sSQL;
                if(is_object($this->oDB))
                    $this->oDB->exec($this->sSQL);
            }//si se han proporcionado correctamente los datos campo=>valor y las claves
        }//se ha proporcionado una tabla
    }//autoupdate
    
    public function autodelete_logic($sTable=NULL,$arPksFV=array())
    {
        //Limpio la consulta 
        $this->sSQL = "-- autodelete_logic";
        
        if($this->sSQLComment)
            $sSQLComment = "/*$this->sSQLComment*/";
        
        if(!$sTable)
            $sTable = $this->sTable;
        
        if($sTable)
        {
            if(!$arPksFV)
                $arPksFV = $this->arPksFV;
            
            if($arPksFV)
            {    
                //@todo
                $sSQL = "$sSQLComment UPDATE $sTable ";
                $sSQL .= "SET  ";

                //condiciones con las claves
                $arAnd = array();
                foreach($arPksFV as $sField=>$sValue)
                {    
                    if($sValue===NULL)
                        $arAnd[] = "$sField IS NULL";
                    else
                        $arAnd[] = "$sField='$sValue'";
                }
                
                $sSQL .= " WHERE ".implode(" AND ",$arAnd);
                
                $this->sSQL = $sSQL;
                if(is_object($this->oDB))
                    $this->oDB->exec($this->sSQL);
            }//si se han proporcionado correctamente las claves
        }//se ha proporcionado una tabla
    }//autodelete_logic    
    
    public function autoundelete_logic($sTable=NULL,$arPksFV=array())
    {
        //Limpio la consulta 
        $this->sSQL = "-- autoundelete_logic";
        
        if($this->sSQLComment)
            $sSQLComment = "/*$this->sSQLComment*/";
        
        if(!$sTable)
            $sTable = $this->sTable;
        
        if($sTable)
        {
            if(!$arPksFV)
                $arPksFV = $this->arPksFV;
            
            if($arPksFV)
            {    
                $codUserSession = getPostParam("userId");
                $sNow = date("Ymdhis");
                $sSQL = "$sSQLComment UPDATE $sTable 
                        SET Delete_Date=NULL
                        ,Delete_User=NULL
                        ,Modify_Date='$sNow'
                        ,Modify_User='$codUserSession'
                        ";

                //condiciones con las claves
                $arAnd = array();
                foreach($arPksFV as $sField=>$sValue)
                {    
                    if($sValue===NULL)
                        $arAnd[] = "$sField IS NULL";
                    else
                        $arAnd[] = "$sField='$sValue'";
                }
                
                $sSQL .= " WHERE ".implode(" AND ",$arAnd);
                
                $this->sSQL = $sSQL;
                if(is_object($this->oDB))
                    $this->oDB->exec($this->sSQL);
            }//si se han proporcionado correctamente las claves
        }//se ha proporcionado una tabla
    }//autoundelete_logic  
    
    public function autodelete($sTable=NULL,$arPksFV=array())
    {
        //Limpio la consulta 
        $this->sSQL = "-- autodelete";
        
        if($this->sSQLComment)
            $sSQLComment = "/*$this->sSQLComment*/";
        
        if(!$sTable)
            $sTable = $this->sTable;
        
        if($sTable)
        {
            if(!$arPksFV)
                $arPksFV = $this->arPksFV;
            
            if($arPksFV)
            {    
                $sSQL = "$sSQLComment DELETE FROM $sTable ";
                //condiciones con las claves
                $arAnd = array();
                
                foreach($arPksFV as $sField=>$sValue)
                {    
                    if($sValue===NULL)
                        $arAnd[] = "$sField IS NULL";
                    else
                        $arAnd[] = "$sField='$sValue'";
                }                
                
                $sSQL .= " WHERE ".implode(" AND ",$arAnd);
                
                $this->sSQL = $sSQL;
                if(is_object($this->oDB))
                    $this->oDB->exec($this->sSQL);
            }//si se han proporcionado correctamente las claves
        }//se ha proporcionado una tabla
    }//autodelete 
    
    public function get_selectfrom($sTable=NULL,$arFields=array(),$arPksFV=array())
    {
        //Limpio la consulta 
        $this->sSQL = "-- get_values";
        
        if($this->sSQLComment)
            $sSQLComment = "/*$this->sSQLComment*/";
        
        if(!$sTable)
            $sTable = $this->sTable;
        
        if($sTable)
        {
            if(!$arFields)
                $arFields = $this->arGetFields;
            if(!$arPksFV)
                $arPksFV = $this->arPksFV;
            
            if($arFields && $arPksFV)
            {    
                $sSQL = "$sSQLComment SELECT ";
                $sSQL .= implode(",",$arFields)." ";
                $sSQL .= "FROM $sTable";
                
                //condiciones con las claves
                $arAux = array();
                foreach($arPksFV as $sField=>$sValue)
                {    
                    if($sValue===NULL)
                        $arAux[] = "$sField IS NULL";
                    else
                        $arAux[] = "$sField='$sValue'";
                }
                
                $sSQL .= " WHERE ".implode(" AND ",$arAux);
                
                $this->sSQL = $sSQL;
                if(is_object($this->oDB))
                    return $this->oDB->query($this->sSQL);
            }//si se han proporcionado correctamente los datos campo=>valor y las claves
            return NULL;
        }//se ha proporcionado una tabla
    }//get_selectfrom
    
    private function extract_top_sql($sSQL)
    {
        $sTop = NULL;
        $sSQL = strtolower($sSQL);
        //puede ser select top x select distinct top 
        $sTopPatern = "/select[\s]+top[\s]+[\d]+[\s]/";
        preg_match($sTopPatern,$sSQL,$arMatch);
        //si no hay coincidencias es probable que haya un distinct asi que se extrae con distinct
        if(!$arMatch[0])
        {
            $sTopPatern = "/select[\s]+distinct[\s]+top[\s]+[\d]+[\s]/";
            preg_match($sTopPatern,$sSQL,$arMatch);
        }

        if($arMatch[0])
        {
            $sTop = explode("top",$arMatch[0]);
            $sTop = trim($sTop[1]);
        }
        return $sTop;
    }

    public function explode_sql($sSQL)
    {
        $arExploded = array();

        $sDistinct = strstr($sSQL,"select distinct ");
        $sTop = strstr($sSQL," top ");
        $sWhere = strstr($sSQL,"where ");
        $sGroupBy = strstr($sSQL,"group by ");
        $sOrderBy = strstr($sSQL,"order by ");

        if($sDistinct) $sDistinct = "distinct";
        else $sDistinct = NULL;

        if($sTop) $sTop = $this->extract_top_sql($sSQL);
        else $sTop = NULL;

        //SELECT y FROM siempre existen en una sentencia SQL
        $sFields = explode("from ",$sSQL);
        //var_dump($sFields);
        $sFields = explode("select ",$sFields[0]);
        //quito la sentencia top
        $sFields = str_replace("top $sTop ","",$sFields[1]);
        //si existiera distinct se elimina
        $sFields = str_replace("distinct","",$sFields);
        $sFields = trim($sFields);

        //Recuperacion de relaciones INNER LEFT ...
        $sHierarchy = explode("from ",$sSQL);
        if($sWhere)
            $sHierarchy = explode("where ",$sHierarchy[1]);
        //No hay clausula where busco proxima marca "group by"
        else
        {
            if($sGroupBy)
                $sHierarchy = explode("group by ",$sHierarchy[1]);
            else//no hay group by
                if($sOrderBy) 
                    $sHierarchy = explode("order by ",$sHierarchy[1]);
        }
        $sHierarchy = $sHierarchy[0];

        //Recuperacion de condiciones AND , OR despues de WHERE y antes de GROUP BY Y ORDER BY
        if($sWhere) 
        {    
            $sWhere = explode("where ",$sSQL);
            if($sGroupBy)
                $sWhere = explode("group by ",$sWhere[1]);
            elseif($sOrderBy)//no hay group by
                $sWhere = explode("order by ",$sWhere[1]);
            else
                $sWhere[0]=$sWhere[1];
        }

        $sWhere = $sWhere[0];

        //Recuperacion de agrupaciones
        if($sGroupBy)
        {
            $sGroupBy = explode("group by ",$sSQL);
            if($sOrderBy) 
                $sGroupBy = explode("order by ",$sGroupBy[1]);
        }
        $sGroupBy = $sGroupBy[0];

        //Recuperacion de agrupaciones
        if($sOrderBy)
            $sOrderBy = explode("order by ",$sSQL);
        $sOrderBy = $sOrderBy[1];

        $arExploded["distinct"] = $sDistinct;
        $arExploded["top"] = $sTop;
        $arExploded["fields"] = $sFields;
        $arExploded["joins"] = $sHierarchy;
        $arExploded["where"] = $sWhere;
        $arExploded["group by"] = $sGroupBy;
        $arExploded["order by"] = $sOrderBy;

        return $arExploded;
    }

    public function implode_sql($arSQL)
    {
        $sDistinct = $arSQL["distinct"];
        $sTop = $arSQL["top"];
        $sFields = trim($arSQL["fields"]);
        $sJoins = trim($arSQL["joins"]);
        $sWhere = trim($arSQL["where"]);
        $sGroupBy = trim($arSQL["group by"]);
        $sOrderBy = trim($arSQL["order by"]);

        $sSQL = "select ";
        if($sDistinct) $sSQL .= "$sDistinct ";
        if($sTop) $sSQL .= "top $sTop ";
        $sSQL .= "$sFields ";
        $sSQL .= "from ";
        $sSQL .= "$sJoins ";
        if($sWhere) $sSQL .= "where $sWhere ";
        if($sGroupBy) $sSQL .= "group by $sGroupBy ";
        if($sOrderBy) $sSQL .= "order by $sOrderBy";
        return $sSQL;
    }

    public function replace_fields($arReplace,$sFields)
    {
        foreach($arReplace as $sSearch=>$sReplace)
            $sFields = str_replace($sSearch,$sReplace,$sFields);
        return $sFields;
    }
        
    public function set_table($sTable=NULL){$this->sTable=$sTable;}
    public function set_comment($sComment){$this->sSQLComment = $sComment;}
    
    public function set_insert_fv($arFieldVal=array()){$this->arInsertFV = array(); if(is_array($arFieldVal)) $this->arInsertFV=$arFieldVal;}
    public function add_insert_fv($sFieldName,$sValue){$this->arInsertFV[$sFieldName]=$sValue;}

    public function set_pks_fv($arFieldVal=array()){$this->arPksFV = array(); if(is_array($arFieldVal)) $this->arPksFV=$arFieldVal;}
    public function add_pk_fv($sFieldName,$sValue){$this->arPksFV[$sFieldName]=$sValue;}
    
    public function set_update_fv($arFieldVal=array()){$this->arUpdateFV = array(); if(is_array($arFieldVal)) $this->arUpdateFV=$arFieldVal;}
    public function add_update_fv($sFieldName,$sValue){$this->arUpdateFV[$sFieldName]=$sValue;}
    
    public function set_getfields($arFields=array()){$this->arGetFields = array(); if(is_array($arFields)) $this->arGetFields=$arFields;}
    public function add_getfield($sFieldName){$this->arGetFields[]=$sFieldName;}

    public function get_sql(){return $this->sSQL;}
    
    /**
     * @param string $sTable Tabla sobre la que se va a comprobar. Por defecto this.sTable
     * 1: Delete_Date IS NOT NULL (con borrado logico)<br/>
     * 0: Delete_Date IS NULL (sin borrado logico)<br/>
     * NULL: No aplica filtro por fecha solo claves<br/>
     * @param int $isDeleted
     * @return boolean
     */
    public function is_intable($sTable=NULL,$isDeleted=1)
    {
        if(!$sTable) $sTable = $this->sTable;
        
        $sSQL = "-- is_intable
                SELECT id FROM $sTable WHERE ";

        $arAnd = array();
        foreach($this->arPksFV as $sFieldName=>$sFieldValue)
            $arAnd[] = "$this->sTable.$sFieldName='$sFieldValue'";

        if($isDeleted===1)
            $arAnd[] = "$this->sTable.Delete_Date IS NOT NULL";
        elseif($isDeleted===0)
            $arAnd[] = "$this->sTable.Delete_Date IS NULL";
        
        $sSQL .= implode(" AND ",$arAnd);
        $this->sSQL = $sSQL;
        
        $arRow = [];
        if(is_object($this->oDB))
            $arRow = $this->oDB->query($this->sSQL);
        
        return (boolean)$arRow[0];
    }
    
    /**
     * Obtiene el ultimo entero + 1 de un campo tipo contador
     * @param type $sFieldName
     */
    public function get_nextcode($sFieldName="Num_Line")
    {
        if($this->sTable && $sFieldName)
        {
            $sSQL = "/*crud.get_nextcode*/
            SELECT MAX($sFieldName) AS imax
            FROM $this->sTable 
            WHERE 1=1 
            AND ISNUMERIC($sFieldName)=1
            ";
            
            $arAux = array();
            foreach($this->arPksFV as $sField=>$sValue)
            {    
                if($sValue===NULL)
                    $arAux[] = "$sField IS NULL";
                else
                    $arAux[] = "$sField='$sValue'";
            }
            
            if($arAux)
                $sSQL .= " AND ".implode(" AND ",$arAux);
            
            $iMax = NULL;
            $this->sSQL = $sSQL;
            if(is_object($this->oDB))
                $iMax = $this->oDB->query($this->sSQL);            
            if(!$iMax) $iMax = 0;
            $iMax++;
            return $iMax;
        }
        return NULL;
    }//get_nextcode()
    
}//Crud 2.0.0