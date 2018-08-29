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

use DesignPatterns\Gof\Factory\Conexion;

class Main 
{
    public static function main(Array $arArgs=[])
    {
        $arConx = ["usuario1","usuario2","usuario3","usuario4","usuario5"];
        

        //emulamos las peticiones de distintos usuarios
        foreach($arConx as $sUser)
        {
            echo "INICIO {usuario:$sUser}\n";
            $oConx = Conexion::get_instancia();
            $oConx->conectar();
            $oConx->desconectar();
            echo "FIN {usuario:$sUser}\n";
        }
        
        \dg::p("Main.main() executed!!");
    }//main
    
}//Main