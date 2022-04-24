<?php
namespace App\Blog\Infrastructure\Bus;

use App\Shared\Domain\Bus\Command\ICommandBus;
use App\Shared\Domain\Bus\Command\ICommandHandler;
use App\Shared\Domain\Bus\Command\ICommand;

use \InvalidArgumentException;

final class CommandBus implements ICommandBus
{
    private array $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    public function register(string $command, ICommandHandler $handler): void
    {
        $this->handlers[$command] = $handler;
    }

    public function dispatch(ICommand $command)
    {
        $commandHandler = $this->handlers[get_class($command)] ?? "";
        if (!$commandHandler) throw new InvalidArgumentException();
        //usa el invoke
        return $commandHandler($command);
    }
}