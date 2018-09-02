<?php
namespace DesignPatterns\SrtaDeveloper\App\Domain\Service;

class MailerFactory
{
    private $adapter;

    public function __construct(MailerAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function sendRegistrationEmail($email)
    {
        $this->adapter->send($email,"Bienvenido usuario","Texto del cuerpo del mensaje");
    }//sendRegistrationEmail

}//MailerFactory