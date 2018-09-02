<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\SrtaDeveloper\App\Infrastructure\Doctrine\ORM\DoctrineORMUserAccountManager
 * @file DoctrineORMUserAccountManager.php
 * @version 1.0.0
 * @date 02-09-2018 17:21
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\SrtaDeveloper\App\Infrastructure\Doctrine\ORM;

use  DesignPatterns\SrtaDeveloper\App\Infrastructure\Doctrine\ORM\DoctrineORMUserAccount;
use DesignPatterns\SrtaDeveloper\App\Domain\UserAccountRepositoryInterface;
use DesignPatterns\SrtaDeveloper\App\Domain\UserAccountFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;


class DoctrineORMUserAccountManager implements UserAccountRepositoryInterface, UserAccountFactoryInterface
{
    private $on;

    public function __construct(EntityManagerInterface $on)
    {
        $this->on = $on;
    }//__construct

    public function findById($id){return $this->on->findById($id);}

    public function findByEmail($email){return $this->on->findById(["email"=>$email]);}

    public function createUserAccount($email,$password,$firsname,$lastname)
    {
        //....
    }//createUserAccount

}//DoctrineORMUserAccountManager