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

