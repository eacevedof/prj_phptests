<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\Factory\FabricConexion
 * @file FabricConexion.php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\Gof\Factory;

use DesignPatterns\Gof\Factory\ConexionMssql;
use DesignPatterns\Gof\Factory\ConexionMysql;
use DesignPatterns\Gof\Factory\ConexionOracle;
use DesignPatterns\Gof\Factory\ConexionPostgre;
use DesignPatterns\Gof\Factory\ConexionVacia;

class FabricConexion 
{
    public function get_conexion(String $sMotor)
    {
        if(!$sMotor) return new ConexionVacia();
        if($sMotor=="mssql") return new ConexionMssql();
        if($sMotor=="mysql") return new ConexionMysql();
        if($sMotor=="oracle") return new ConexionOracle();
        if($sMotor=="postgre") return new ConexionPostgre();
        return new ConexionVacia();
    }
}//FabricConexion