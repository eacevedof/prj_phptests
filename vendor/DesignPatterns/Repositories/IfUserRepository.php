<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Repositories
 * @file IfUserRepository.php
 * @version 1.0.0
 * @date 27-08-2018 17:00
 * @observations
 *  Ejemplo
 */
namespace DesignPatterns\Repositories;

interface IfUserRepository 
{
    public function buscar_por_email(String $sEmail);
    public function crear(Array $arDatos);
    public function actualizar(Array $arDatos,String $id);
    public function borrar(String $id);
    public function buscar_por_id(String $id);
    public function todos();
}//IfUserRepository