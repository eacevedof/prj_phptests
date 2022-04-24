<?php
namespace App\Blog\Application;

use App\Blog\Infrastructure\Monolog;
use App\Shared\Domain\Bus\Event\IEvent;
use App\Shared\Domain\Bus\Event\IEventSubscriber;
use App\Blog\Domain\Events\PostWasPublishedEvent;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;

final class MonologService implements IEventSubscriber
{
    private function logOnPostPublished(IEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;

        $emailTo = (new UserRepository())->ofIdOrFail($domainEvent->authorId())->email();
        $title = (new PostRepository())->ofIdOrFail($domainEvent->postId())->title();
        echo "monologging ...<br/>";
        (new Monolog())->log("Post with title {$title} published by user {$emailTo}");
    }

    public function onDomainEvent(IEvent $domainEvent): IEventSubscriber
    {
        $this->logOnPostPublished($domainEvent);
        return $this;
    }
}