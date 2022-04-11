<?php
namespace App\Blog\Application\Commands;

interface ICommandBus
{
    public function dispatch(ICommand $command): void;
}