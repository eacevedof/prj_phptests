<?php
namespace App\Blog\Domain\Bus;

//https://github.com/CodelyTV/php-ddd-example/tree/main/src/Shared/Domain/Bus/Command/CommandBus.php
interface ICommandBus
{
    public function register(string $command, ICommandHandler $handler): void;

    //sin tipado de retorno porque puede que el servicio puede
    public function dispatch(ICommand $command);
}