<?php
namespace App\Blog\Application;

use App\Blog\Application\Commands\ICommand;
use App\Blog\Domain\ICommandHandler;
use App\Blog\Domain\IEntity;
use App\Blog\Domain\PostRepository;
use App\Blog\Domain\UserRepository;
//use App\Blog\Domain\Events\PostWasPublishedEvent;
use App\Blog\Infrastructure\Monolog;

final class LoggerDecorator
{
    private ICommandHandler $commandHandler;
    private Monolog $monolog;

    public function __construct(ICommandHandler $commandHandler, Monolog $monolog)
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

/*
$decorator = new LoggerDecorator(new PostPublishCommandHandler(
    new PostRepository(),
    new UserRepository()
));
$decorator->execute(new PostWasPublishedEvent(1, 1));
*/