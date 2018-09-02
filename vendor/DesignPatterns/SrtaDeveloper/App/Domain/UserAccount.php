<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\SrtaDeveloper\App\Domain\UserAccount
 * @file UserAccount.php
 * @version 1.0.0
 * @date 02-09-2018 17:21
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\SrtaDeveloper\App\Domain;

class UserAccount 
{
    private $id;
    private $email;
    private $password;
    private $firstName;
    private $lastName;

    public function __construct($id,$email,$password,$firstName,$lastName)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;

    }//_construct

}//UserAccount