<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name Helper Style
 * @date 21-02-2013 09:45
 * @file helper_style.php
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperStyle extends TheFrameworkHelper
{
    private $_class_warning = ""; //yellow
    private $_class_error = ""; //red
    private $_class_success = ""; //green
    private $_class_tips = ""; //blue
    
    private $_class_default = "";
    private $_class_inverse = "";
    
    public function __construct(){$this->_type = "style"; }
    
    //**********************************
    //             SETS
    //**********************************
    public function set_class_warning($value){$this->_class_warning=$value;}
    public function set_class_error($value){$this->_class_error=$value;}
    public function set_class_success($value){$this->_class_success=$value;}
    public function set_class_tips($value){$this->_class_tips=$value;}
    public function set_class_default($value){$this->_class_default=$value;}
    public function set_class_inverse($value){$this->_class_inverse=$value;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_class_warning(){return $this->_class_warning;}
    public function get_class_error(){return $this->_class_error;}
    public function get_class_success(){return $this->_class_success;}
    public function get_class_tips(){return $this->_class_tips;}
    public function get_class_default(){return $this->_class_default;}
    public function get_class_inverse(){return $this->_class_inverse;}
}