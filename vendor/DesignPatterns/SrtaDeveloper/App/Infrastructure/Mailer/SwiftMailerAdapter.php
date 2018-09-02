<?php
namespace DesignPatterns\SrtaDeveloper\Infrastructure\Mailer;

use DesignPatterns\SrtaDeveloper\App\Domain\Service\MailerAdapterInterface;

class SwiftMailerAdapter implements MailerAdapterInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($email,$subject,$body)
    {
        $message = \Swift_Message::newInstance($subject);
        $message->setTo($email);
        $message->setBody($body,"text/html");
        $this->mailer->send($message);
    }//send

}//SwiftMailerAdapter