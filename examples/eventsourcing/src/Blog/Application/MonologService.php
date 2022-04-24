<?php
namespace App\Blog\Application;

use App\Blog\Infrastructure\Monolog;
use App\Blog\Domain\Bus\Event\IDomainEvent;
use App\Blog\Domain\Bus\Event\IDomainEventSubscriber;
use App\Blog\Domain\Events\PostWasPublishedEvent;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;

final class MonologService implements IDomainEventSubscriber
{
    private function logOnPostPublished(IDomainEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;

        $emailTo = (new UserRepository())->ofIdOrFail($domainEvent->authorId())->email();
        $title = (new PostRepository())->ofIdOrFail($domainEvent->postId())->title();
        echo "monologging ...<br/>";
        (new Monolog())->log("Post with title {$title} published by user {$emailTo}");
    }

    public function onDomainEvent(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        $this->logOnPostPublished($domainEvent);
        return $this;
    }
}