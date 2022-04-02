<?php
namespace App\Publishing\Infrastructure;

use EventSourcing\IDomainEventSubscriber;
use EventSourcing\IDomainEvent;
use EventSourcing\DomainEventPublisher;

use \App\Publishing\Application\PublishCommandHandler;
use \App\Publishing\Domain\Event\PostWasPublishedEvent;
use \App\Publishing\Domain\PostRepository;
use \App\Publishing\Domain\UserRepository;

final class PostController implements IDomainEventSubscriber
{
    use RequestTrait;

    public function publish(): void
    {
        $postId = $this->getPost("postId", 1);
        $userId = $this->getPost("userId", 1);

        $id = DomainEventPublisher::instance()->subscribe($this);
        $postWasPublished = new PostWasPublishedEvent($postId, $userId);

        (new PublishCommandHandler(
            new PostRepository(),
            new UserRepository()
        ))->execute($postWasPublished);

        DomainEventPublisher::instance()->unsubscribe($id);
    }

    public function handle(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        if (get_class($domainEvent) !== PostWasPublishedEvent::class) return $this;
        echo "...persisting data";
        return $this;
    }
}
