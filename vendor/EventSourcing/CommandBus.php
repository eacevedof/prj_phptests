<?php
namespace EventSourcing;

final class CommandBus
{
    private array $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    public function addHandler(string $commandName, Object $handler): self
    {
        $this->handlers[$commandName] = $handler;
        return $this;
    }

    public function handle(Object $command): self
    {
        $commandHandler = $this->handlers[get_class($command)];
        if (!$commandHandler) {
            //thwor error
        }
        return $commandHandler->handle($command);
    }

    public function addDecorator(): self
    {
        //hace el mapeo de eventos y sus disparadores. Sugiere tactician
    }
}