<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\Singleton\Conexion
 * @file Conexion.php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo []()
 */
namespace Conexion\Gof\Singleton;

class Conexion
{
    /**
     * @var Conexion 
     */
    private static $oSingleton;
    
    //privado de modo que no se pueda hacer un $obj = new Conexion();
    private function __construct() {;}
    
    /**
     * devuelve la instancia única
     */
    public static function get_instancia()
    {
        if(!static::$oSingleton)
        {
            \dg::p("Conexion.get_instancia()");
            static::$oSingleton = new Conexion();
        }
        return static::$oSingleton;
    }//get_instancia
    
    public function conectar(){\dg::p("Conexion.conectar()");}
    
    public function desconectar(){\dg::p("Conexion.desconectar()");}
}//Conexion