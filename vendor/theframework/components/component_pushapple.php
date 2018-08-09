<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentPushapple
 * @file component_pushapple.php
 * @version 1.0.0
 * @date 09-08-2018 17:41
 * @observations
 */
namespace TheFramework\Components;

class ComponentPushapple 
{
    private $isError;
    private $arErrors;

    public function __construct() 
    {

    }
    
  
    
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function add_from($sKey,$sValue){$this->arFrom[$sKey] = $sValue;}
    public function add_to($sKey,$sValue){$this->arTo[$sKey] = $sValue;}
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
}//class ComponentPushapple

