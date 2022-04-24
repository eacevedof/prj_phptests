<?php
namespace App\Shared\Domain;

use \DomainException;

abstract class AbsDomainError extends DomainException
{
    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }

    abstract public function errorCode(): string;

    abstract protected function errorMessage(): string;
}