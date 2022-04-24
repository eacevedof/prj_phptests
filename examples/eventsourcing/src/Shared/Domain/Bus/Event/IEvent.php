<?php
namespace App\Shared\Domain\Bus\Event;

interface IEvent
{
    public function occurredOn(): int;
}