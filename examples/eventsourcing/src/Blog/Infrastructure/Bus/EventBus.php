<?php
namespace App\Blog\Infrastructure\Bus;

use App\Blog\Domain\Bus\Event\IEventBus;
use App\Blog\Domain\Bus\Event\IDomainEventSubscriber;
use App\Blog\Domain\Bus\Event\IDomainEvent;

final class EventBus implements IEventBus
{
    private array $subscribers;
    private static ?DomainEventBus $instance = null;
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
            $subscriber->onDomainEvent($domainEvent);
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