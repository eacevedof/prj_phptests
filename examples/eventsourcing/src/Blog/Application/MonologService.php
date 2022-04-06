<?php
namespace App\Blog\Application;

use App\Blog\Utils\Monolog;
use EventSourcing\IDomainEvent;
use EventSourcing\IDomainEventSubscriber;
use App\Blog\Domain\Events\PostWasPublishedEvent;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;

final class MonologService implements IDomainEventSubscriber
{
    private function emailOnPostPublished(IDomainEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;

        $emailTo = (new UserRepository())->ofIdOrFail($domainEvent->authorId())->email();
        $title = (new PostRepository())->ofIdOrFail($domainEvent->authorId())->title();
        echo "monologging ...";
        (new Monolog())->log("Post with title {$title} published by user {$emailTo}");
    }

    public function onDomainEvent(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        $this->emailOnPostPublished($domainEvent);
        return $this;
    }
}