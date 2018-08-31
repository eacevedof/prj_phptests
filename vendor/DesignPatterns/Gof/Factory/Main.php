<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\Factory\Main
 * @file Main.php
 * @version 1.0.0
 * @date 29-08-2018 14:04
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\Gof\Factory;

use DesignPatterns\Gof\Factory\FabricConexion;
use DesignPatterns\Gof\Factory\IfConexion;

class Main 
{
    public static function main(Array $arArgs=[])
    {
        $oFabrica = new FabricConexion();

        $oIfCnx1 = $oFabrica->get_conexion("oracle");
        $oIfCnx1->conectar();
        $oIfCnx1->desconectar();

        $oIfCnx1 = $oFabrica->get_conexion("mysql");
        $oIfCnx1->conectar();
        $oIfCnx1->desconectar();

        $oIfCnx1 = $oFabrica->get_conexion("h2");
        $oIfCnx1->conectar();
        $oIfCnx1->desconectar();        
        
        \dg::p("Main.main() executed!!");
    }//main
    
}//Main