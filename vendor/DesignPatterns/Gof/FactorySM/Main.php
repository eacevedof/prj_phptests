<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\FactorySM\Main
 * @file Main.php
 * @version 1.0.0
 * @date 29-08-2018 14:04
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\Gof\FactorySM;

use DesignPatterns\Gof\FactorySM\FactorySMConexion;
use DesignPatterns\Gof\FactorySM\IfConexion;

class Main 
{
    public static function main(Array $arArgs=[])
    {
        $oFabrica = new FactorySMConexion();

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