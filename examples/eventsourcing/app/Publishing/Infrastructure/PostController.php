<?php
namespace App\Publishing\Infrastructure;

use EventSourcing\IDomainEventSubscriber;
use EventSourcing\IDomainEvent;
use EventSourcing\DomainEventPublisher;
use \App\Publishing\Application\NotifyService;
use \App\Publishing\Application\PublishCommandHandler;
use \App\Publishing\Domain\Event\PostWasPublishedEvent;
use \App\Publishing\Domain\PostRepository;
use \App\Publishing\Domain\UserRepository;

final class PostController implements IDomainEventSubscriber
{
    use RequestTrait;
    use ViewTrait;

    public function publish(): void
    {
        $postId = $this->getPost("postId", 1);
        $userId = $this->getPost("userId", 1);

        DomainEventPublisher::instance()->subscribe($this);
        DomainEventPublisher::instance()->subscribe(new NotifyService());
        $postWasPublished = new PostWasPublishedEvent($postId, $userId);

        (new PublishCommandHandler(
            new PostRepository(),
            new UserRepository()
        ))->execute($postWasPublished);
    }

    public function handle(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        if (get_class($domainEvent) !== PostWasPublishedEvent::class) return $this;

        $this
            ->set("status", "Published")
            ->render("post-status")
        ;

        return $this;
    }
}
