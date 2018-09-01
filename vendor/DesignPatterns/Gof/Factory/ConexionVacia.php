<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\Factory\ConexionVacia
 * @file ConexionVacia.php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\Gof\Factory;

use DesignPatterns\Gof\Factory\IfConexion;

class ConexionVacia implements IfConexion
{

    public function conectar(){
        \dg::p("ConexionVacia.conectar");
    }

    public function desconectar(){
        \dg::p("ConexionVacia.desconectar");
    }
}//ConexionVacia