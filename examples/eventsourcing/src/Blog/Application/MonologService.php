<?php
namespace App\Blog\Application;

use EventSourcing\IDomainEvent;
use EventSourcing\IDomainEventSubscriber;
use App\Blog\Domain\Ports\IUserRepository;
use App\Blog\Domain\Events\PostWasPublishedEvent;

final class MonologService implements IDomainEventSubscriber
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    private function emailOnPostPublished(IDomainEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;

        $emailTo = $this->userRepository->ofIdOrFail($domainEvent->authorId())->email();
        echo "sending email ...<br/>";
        mb_send_mail(
            $emailTo,
            "Your post with id {$domainEvent->postId()} has been published",
            "Congrats!"
        );
    }

    public function onDomainEvent(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        $this->emailOnPostPublished($domainEvent);
        return $this;
    }
}