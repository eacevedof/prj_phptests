<?php
namespace App\Publishing\Application;

use App\Publishing\Application\Commands\ICommand;
use App\Publishing\Domain\ICommandHandler;
use App\Publishing\Domain\IEntity;
use App\Publishing\Domain\PostRepository;
use App\Publishing\Domain\UserRepository;
use App\Publishing\Domain\Events\PostWasPublishedEvent;

final class LoggerDecorator
{
    private ICommandHandler $commandHandler;

    public function __construct(ICommandHandler $commandHandler, $monolog)
    {
        $this->commandHandler = $commandHandler;
        $this->monolog = $monolog;
    }

    public function execute(ICommand $command): IEntity
    {
        $this->monolog->log(serialize($command));
        return $this->commandHandler->execute($command);
    }
}

$decorator = new LoggerDecorator(new PublishCommandHandler(
    new PostRepository(),
    new UserRepository()
));
$decorator->execute(new PostWasPublishedEvent(1, 1));