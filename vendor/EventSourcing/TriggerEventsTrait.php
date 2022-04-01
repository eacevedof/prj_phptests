<?php
namespace EventSourcing;

trait TriggerEventsTrait
{
    private array $events = [];

    protected function trigger($event): self
    {
        $this->events[] = $event;
        return $this;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}