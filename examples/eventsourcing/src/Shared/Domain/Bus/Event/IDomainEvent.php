<?php
namespace App\Shared\Domain\Bus\Event;

interface IDomainEvent
{
    public function occurredOn(): int;
}