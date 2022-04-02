<?php
namespace App\Publishing\Domain;

interface ICommandHandler
{
    public function execute($command): IEntity;
}