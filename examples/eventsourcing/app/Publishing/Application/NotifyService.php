<?php
namespace App\Publishing\Application;

use App\Publishing\Domain\Ports\IUserRepository;
use EventSourcing\IDomainEvent;
use EventSourcing\IDomainEventSubscriber;
use App\Publishing\Domain\Events\PostWasPublishedEvent;

final class NotifyService implements IDomainEventSubscriber
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    private function emailOnPostPublished(IDomainEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;

        $emailTo =  $this->userRepository->ofIdOrFail($domainEvent->authorId())->email();
        echo "...sending email<br/>";
        mb_send_mail(
            $emailTo,
            "Your post with id {$domainEvent->postId()} has been published",
            "Congrats!"
        );
    }

    public function handle(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        $this->emailOnPostPublished($domainEvent);
        return $this;
    }
}