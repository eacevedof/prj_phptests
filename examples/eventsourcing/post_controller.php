<?php
/**
 * @file: post_controller.php
 * @info: [Rigor Talks - Playlist](https://www.youtube.com/watch?v=aKcmbOZV9mA&list=PLfgj7DYkKH3Cd8bdu5SIHGYXh_bPV2idP&index=1)
 */
include_once(TFW_PATHROOTDS."vendor/autoload.php");
include_once("app/bootstrap.php");

use EventSourcing\IDomainEventSubscriber;
use EventSourcing\IDomainEvent;
use EventSourcing\DomainEventPublisher;

use \App\Publishing\Infrastructure\RequestTrait;
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

(new PostController())->publish();