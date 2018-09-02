<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\SrtaDeveloper\App\Infrastructure\Doctrine\ORM\InMemoryUserAccountManager
 * @file InMemoryUserAccountManager.php
 * @version 1.0.0
 * @date 02-09-2018 17:21
 * @observations TESTS
 *  Ejemplo []()
 */
namespace DesignPatterns\SrtaDeveloper\App\Infrastructure\Doctrine\ORM;

use DesignPatterns\SrtaDeveloper\App\Domain\UserAccountRepositoryInterface;
use DesignPatterns\SrtaDeveloper\App\Domain\UserAccountFactoryInterface;
use DesignPatterns\SrtaDeveloper\App\Domain\UserAccount;


class InMemoryUserAccountManager implements UserAccountRepositoryInterface, UserAccountFactoryInterface
{
    private $userAccounts;

    public function __construct()
    {
        $this->userAccounts = array();
    }

    public function findByEmail($email)
    {
        //...
    }

}//InMemoryUserAccountManager