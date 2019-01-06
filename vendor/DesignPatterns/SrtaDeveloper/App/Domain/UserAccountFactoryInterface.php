<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\SrtaDeveloper\App\Domain\UserAccountFactoryInterface
 * @file UserAccountFactoryInterface.php
 * @version 1.0.0
 * @date 02-09-2018 17:21
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\SrtaDeveloper\App\Domain;

interface UserAccountFactoryInterface
{
    public function createUserAccount($email,$password,$firstname,$lastname);
}//UserAccountFactoryInterface