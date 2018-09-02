<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\App\Command\RegisterUserAccountCommand
 * @file RegisterUserAccountCommand.php
 * @version 1.0.0
 * @date 02-09-2018 17:21
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\App\Command;

class RegisterUserAccountCommand implements CommandInterface
{
    private $email;
    private $password;
    private $firstName;
    private $lastName;

    public function __construct($email,$password,$firstName,$lastName)
    {
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;

    }//_construct

    public function getEmail()
    {
        return $this->email;
    }


}//RegisterUserAccountCommand