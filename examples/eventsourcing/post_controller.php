<?php
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
        $postWasPublished = new PostWasPublishedCommand(1, 1);
        $dispacher = DomainEventPublisher::instance();

        //$dispacher->addListener();
        $dispacher->subscribe($this);

        //ejecuto el servicio
        (new PublishCommandHandler(
            new PostRepository(),
            new UserRepository()
        ))->execute($postWasPublished);
    }

    public function isSubscribedTo(IDomainEvent $domainEvent): bool
    {
        return get_class($domainEvent) === PostWasPublishedCommand::class;
    }

    public function handle(IDomainEvent $domainEvent): IDomainEventSubscriber
    {

        return $this;
    }
}

(new PostController())->publish();