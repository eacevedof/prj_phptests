<?php
/**
 * @file: post_controller.php
 * @info: [Rigor Talks - Playlist](https://www.youtube.com/watch?v=aKcmbOZV9mA&list=PLfgj7DYkKH3Cd8bdu5SIHGYXh_bPV2idP&index=1)
 */
include_once("app/bootstrap.php");

use App\Publishing\Application\PublishCommandHandler;
use App\Publishing\Domain\PostRepository;
use App\Publishing\Domain\UserRepository;
use EventSourcing\DomainEventPublisher;
use App\Publishing\Domain\Event\PostWasPublishedCommand;
use EventSourcing\IDomainEventSubscriber;
use EventSourcing\IDomainEvent;
//use App\Publishing\Domain\Event\PostWasPublishedCommand;

final class PostController implements IDomainEventSubscriber
{
    public function publish(): void
    {
        DomainEventPublisher::instance()->subscribe($this);

        $postWasPublished = new PostWasPublishedCommand(1, 1);
        //ejecuto el servicio
        (new PublishCommandHandler(
            new PostRepository(),
            new UserRepository()
        ))->execute($postWasPublished);
    }

    public function handle(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        if (get_class($domainEvent) !== PostWasPublishedCommand::class) return $this;


        return $this;
    }
}

(new PostController())->publish();