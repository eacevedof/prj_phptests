<?php
namespace App\Publishing\Application;

use App\Publishing\Domain\Event\PostWasPublishedCommand;
use App\Publishing\Domain\ICommandHandler;
use App\Publishing\Domain\IEntity;
use EventSourcing\IDomainEvent;

final class LoggerDecorator
{
    public function __construct(ICommandHandler $commandHandler, $monolog)
    {
        $this->commandHandler = $commandHandler;
        $this->monolog = $monolog;
    }

    public function execute(IDomainEvent $command): IEntity
    {
        $this->monolog->log(serialize($command));
        return $this->commandHandler->execute($command);
    }
}

$decorator = new LoggerDecorator(new PublishCommandHandler(

));
$decorator->execute(new PostWasPublishedCommand(1, 1));