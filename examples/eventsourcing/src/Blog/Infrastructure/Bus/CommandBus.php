<?php
namespace App\Blog\Infrastructure\Bus;
use App\Blog\Domain\Bus\ICommandBus;
use App\Blog\Domain\Bus\ICommandHandler;
use App\Blog\Domain\Bus\ICommand;

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