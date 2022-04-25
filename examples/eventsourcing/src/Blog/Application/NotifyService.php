<?php
namespace App\Blog\Application;

use App\Blog\Domain\Types\UserIdType;
use App\Shared\Domain\Bus\Event\IEvent;
use App\Shared\Domain\Bus\Event\IEventSubscriber;
use App\Blog\Domain\Ports\IUserRepository;
use App\Blog\Domain\Events\PostWasPublishedEvent;

final class NotifyService implements IEventSubscriber
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    private function emailOnPostPublished(IEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;

        $emailTo = $this->userRepository->ofIdOrFail(new UserIdType($domainEvent->authorId()))->email()->value();
        echo "sending email ...<br/>";
        mb_send_mail(
            $emailTo,
            "Your post with id {$domainEvent->postId()} has been published",
            "Congrats!"
        );
    }

    public function onDomainEvent(IEvent $domainEvent): IEventSubscriber
    {
        $this->emailOnPostPublished($domainEvent);
        return $this;
    }
}