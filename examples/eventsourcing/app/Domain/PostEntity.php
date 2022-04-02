<?php
namespace App\Publishing\Domain;
use EventSourcing\DomainEventPublisher;

final class PostEntity
{
    private int $id;
    private int $status;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->status = 0;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function publish(UserEntity $user): self
    {
        $this->status = 1;
        DomainEventPublisher::instance()->publish(
          new PostWasPublishedCommand(
              $this->id(),
              $user->id()
          )
        );
        return $this;
    }
}