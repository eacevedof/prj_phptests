<?php
namespace App\Publishing\Application;

use DesignPatterns\Repositories\UserRepository;
use EventSourcing\IDomainEvent;
use EventSourcing\IDomainEventSubscriber;
use App\Publishing\Domain\Event\PostWasPublishedEvent;

final class NotifyService implements IDomainEventSubscriber
{
    private function emailOnPostPublished(IDomainEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;

        $emailTo = (new UserRepository)->ofIdOrFail($domainEvent->authorId())->email();
        echo "...sending email";
        mb_send_mail(
            $emailTo,
            "Your post with id {$domainEvent->postId()} has been published",
            "Congrats!"
        );
    }

    public function handle(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        $this->emailOnPostPublished();
        return $this;
    }
}