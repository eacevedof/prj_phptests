<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentConsole
 * @file component_console.php
 * @version 1.0.0
 * @date 03-03-2017 15:40
 * @observations
 */
namespace TheFramework\Components\Console;

class ComponentConsole 
{
    private $sPathLogs;
    private $sPathClass;
    private $sClassName;
    private $sMethod;
    private $arArguments;
    
    private $isError;
    private $arErrors;
    
    public function __construct($argv) 
    {
        $this->set_arguments($argv);
        $this->sPathLogs = realpath(dirname(__FILE__));
        //$this->debug($argv);die;
    }
    
    private function get_namespace($sPathClass)
    {
        $sContent = file_get_contents($sPathClass);
        $arLines = explode("\n",$sContent);
        foreach($arLines as $sLine)
            if(strstr($sLine,"namespace"))
            {
                $sNameSpace = str_replace("namespace","",$sLine);
                $sNameSpace = str_replace(";","",$sNameSpace);
                $sNameSpace = trim($sNameSpace);
                return $sNameSpace;
            }
            
        //die("namespace $sNameSpace");
        return "";
    }
    
    public function run()
    {
        try
        {
            if(is_file($this->sPathClass))
            {
                include_once $this->sPathClass;
                $arIncFiles = get_included_files();

                if(in_array($this->sPathClass,$arIncFiles))
                {
                    $sNameSpace = $this->get_namespace($this->sPathClass);
                    $sFullClass = "\\$this->sClassName";
                    if($sNameSpace)
                        $sFullClass = "\\$sNameSpace\\$this->sClassName";
                    //die("fullclass:$sFullClass");
                    if(class_exists($sFullClass))
                    {
                        if($this->arArguments)
                            $oObject = new $sFullClass($this->arArguments);
                        else
                            $oObject = new $sFullClass();

                        if(is_object($oObject))
                        {
                            if(method_exists($oObject,$this->sMethod))
                            {
                                $oObject->{$this->sMethod}();
                            }
                            else
                            {
                                $this->add_error("Method does not exist: $this->sMethod in $sFullClass");
                                $this->log("Method does not exist: $this->sMethod in $sFullClass");                          
                            }
                        }
                        else
                        {
                            $this->add_error("Not an object:  \$oObject");
                            $this->log("Not an object:  \$oObject");
                        }                        
                    }
                    //clase no encontrada
                    else
                    {
                        $this->add_error("Class not found: $this->sClassName");
                        $this->log("Class not found: $this->sClassName");                        
                    }
                }
                //no se ha incluido
                else
                {
                    $this->add_error("File not included: $this->sPathClass");
                    $this->log("File not included: $this->sPathClass");
                }
            }
            //no existe
            else
            {
                $this->add_error("File does not exist: $this->sPathClass");
                $this->log("File does not exist: $this->sPathClass");
            }
        }
        catch (Exeption $oE )
        {
            $this->add_error("Exception: {$oE->getMessage()}");
            $this->log("Exception: {$oE->getMessage()}");
        }
        
        if($this->isError)
        {
            $this->show_errors();
        }
    }//run()
    
    private function log($sContent,$sTitle="")
    {
        if(!is_string($sContent))
            $sContent = var_export($sContent,1);
        $this->save($sContent,$sTitle);
    }        
    
    private function merge($sContent,$sTitle)
    {
        $sReturn = "::".date("Ymd-His")."::\n";
        if($sTitle) $sReturn .= $sTitle.":\n";
        if($sContent) $sReturn .= $sContent."\n\n";
        return $sReturn;
    }
    
    private function save($sContent,$sTitle=NULL)
    {
        $sToday = date("Ymd");
        $sPathFile = $this->sPathLogs."/console_$sToday.log";
        if(is_file($sPathFile))
            $oCursor = fopen($sPathFile,"a");
        else
            $oCursor = fopen($sPathFile,"x");

        if($oCursor !== FALSE)
        {
            $sToSave = $this->merge($sContent,$sTitle);
            fwrite($oCursor,""); //Grabo el caracter vacio
            if(!empty($sToSave)) fwrite($oCursor,$sToSave);
            fclose($oCursor); //cierro el archivo.
        }
        else
        {
            return FALSE;
        }
        return TRUE;        
    }  
    
    public function debug($mxVar){echo "<pre>".var_export($mxVar,1);}   
    
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
    
    public function set_pathclass($sPath){$this->sPathClass=$sPath;}
    public function set_classname($sClassName){$this->sClassName=$sClassName;}
    public function set_method($sMethod){$this->sMethod=$sMethod;}
    public function set_arguments($argv){
        $this->arArguments=$argv;
        unset($this->arArguments[0]);//run.php
        unset($this->arArguments[1]);//path_class
        unset($this->arArguments[2]);//classname
        unset($this->arArguments[3]);//method
    }
    
}//ComponentConsole