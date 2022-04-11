<?php
final class CommandBus
{
    private array $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    public function addHandler(ICommand $command, ICommandHandler $handler): void
    {
        $this->handlers[] = ["command" => $command, "handler"=>$handler];
    }

    public function dispatch(ICommand $command): void
    {
        foreach ($this->handlers as $array) {
            $commandCheck = $array["command"];
            if (get_class($command) !== get_class($commandCheck)) continue;
            $handler = $array["handler"];
            $handler($command);
        }
    }
}