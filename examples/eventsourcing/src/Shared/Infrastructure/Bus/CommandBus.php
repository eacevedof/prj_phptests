<?php
namespace App\Shared\Infrastructure\Bus;

use App\Shared\Domain\Bus\Command\ICommandBus;
use App\Shared\Domain\Bus\Command\ICommandHandler;
use App\Shared\Domain\Bus\Command\ICommand;

use \InvalidArgumentException;

final class CommandBus implements ICommandBus
{
    private array $handlers;
    private static ?CommandBus $instance = null;

    private function __construct()
    {
        $this->handlers = [];
    }

    public static function instance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function subscribe(string $command, ICommandHandler $handler): void
    {
        $this->handlers[$command] = $handler;
    }

    public function publish(ICommand $command)
    {
        $commandHandler = $this->handlers[get_class($command)] ?? "";
        if (!$commandHandler) throw new InvalidArgumentException();
        //usa el invoke
        return $commandHandler($command);
    }

    public function __clone()
    {
        throw new \BadMethodCallException("Clone is not supported");
    }

    public function unsubscribe(string $command): self
    {
        unset($this->handlers[$command]);
        return $this;
    }
}

