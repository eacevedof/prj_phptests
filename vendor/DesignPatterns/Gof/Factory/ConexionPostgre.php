<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\Factory\ConexionPostgre
 * @file ConexionPostgre.php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\Gof\Factory;

use DesignPatterns\Gof\Factory\IfConexion;

class ConexionPostgre implements IfConexion
{
    private $host;
    private $puerto;
    private $usuario;
    private $contrasena;

    public function __construct()
    {
        $this->host = "localhost";
        $this->puerto = "5433";
        $this->usuario = "postgres";
        $this->contrasena = "123";
    }

    public function conectar(){
        \dg::p("ConexionPostgre.conectar");
    }

    public function desconectar(){
        \dg::p("ConexionPostgre.desconectar");
    }
}//ConexionPostgre