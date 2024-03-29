<?php
namespace App\Shared\Domain\Bus\Command;

//https://github.com/CodelyTV/php-ddd-example/tree/main/src/Shared/Domain/Bus/Command/CommandBus.php
interface ICommandBus
{
    public function subscribe(string $command, ICommandHandler $handler): void;

    //sin tipado de retorno porque puede que el servicio devuelva algun dato
    public function publish(ICommand $command);
}