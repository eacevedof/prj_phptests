<?php
namespace App\Blog\Domain\Bus\Event;

interface IDomainEvent
{
    public function occurredOn(): int;
}