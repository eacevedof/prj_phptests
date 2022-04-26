<?php
namespace App\Shared\Domain;

final class EventStoreEntity implements IEntity
{
    private string $class;
    private int $ocurredOn;
    private string $serialized;

    public function __construct(string $class, int $occurredOn, string $serialized)
    {
        $this->class = $class;
        $this->ocurredOn = $occurredOn;
        $this->serialized = $serialized;
    }

}