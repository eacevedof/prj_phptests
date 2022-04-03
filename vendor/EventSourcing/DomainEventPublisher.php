<?php
namespace EventSourcing;

final class DomainEventPublisher
{
    private array $subscribers;
    private static ?DomainEventPublisher $instance = null;
    private int $id = 0;

    public static function instance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->subscribers = [];
    }

    public function __clone()
    {
        throw new \BadMethodCallException("Clone is not supported");
    }

    public function subscribe(IDomainEventSubscriber $subscriber): int
    {
        $id = $this->id;
        $this->subscribers[$id] = $subscriber;
        $this->id++;
        return $id;
    }

    public function publish(IDomainEvent $domainEvent): self
    {
        foreach($this->subscribers as $subscriber) {
            $subscriber->onEvent($domainEvent);
        }
        return $this;
    }

    public function ofId(int $id): ?IDomainEventSubscriber
    {
        return $this->subscribers[$id] ?? null;
    }

    public function unsubscribe(int $id): self
    {
        unset($this->subscribers[$id]);
        return $this;
    }
}