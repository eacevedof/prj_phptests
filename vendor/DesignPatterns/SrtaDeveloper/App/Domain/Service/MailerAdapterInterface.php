<?php
namespace DesignPatterns\SrtaDeveloper\App\Domain\Service;

interface MailerAdapterInterface
{
    public function send($email,$subject,$body);
}