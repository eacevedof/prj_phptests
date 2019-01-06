<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\SrtaDeveloper\App\Domain\UserAccountRepositoryInterface
 * @file UserAccountRepositoryInterface.php
 * @version 1.0.0
 * @date 02-09-2018 17:21
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\SrtaDeveloper\App\Domain;

interface UserAccountRepositoryInterface
{
    public function findById($id);
    public function findByEmail($id);
    public function add(UserAccount $userAccount);

}//UserAccountRepositoryInterface