<?php
/**
 * @file: php_di.php
 * @info: ensayos con el inyector de dependencias php-di 6.0: http://php-di.org/
 */
include("vendor/autoload.php");

class Mailer 
{
    public function mail($recipient, $content)
    {
        echo "<pre/> mail: {recipient: $recipient, content: $content} sent";
    }
}

class UserManager
{
    private $mailer;
    
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function register($email,$password)
    {
        //check user register
        $this->mailer->mail($email,"Hello and Welcome your pass is $password!");
    }
}

//tipical approach
$mailer = new Mailer();
$usermanager = new UserManager($mailer);
$usermanager->register("desti@mai.com", "123");

use DI\Container;
$container = new Container();

//se pide una instancia de UserManager que tenga en el constructor una instancia de Mailer
//esto se hace usando ReflectionClass, que es un helper que devuelve todos los datos de la estructura
//de una clase. Aplica autowiring (escanea todo el código)
$usermanager = $container->get("UserManager");
$usermanager->register("dimail@di.di", "456789");

