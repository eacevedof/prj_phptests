<?php
namespace EventSourcing;

final class DomainEventPublisher
{
    private array $subscribers;
    private static ?DomainEventPublisher $instance = null;
    private int $id = 0;

    public static function instance(): self
    {
        if (null === self::instance) {
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

    public function ofId(int $id): ?IDomainEventSubscriber
    {
        return $this->subscribers[$id] ?? null;
    }

    public function unsubscribe(int $id): self
    {
        unset($this->subscribers[$id]);
        return $this;
    }

    public function publish(IDomainEvent $domainEvent): self
    {
        foreach($this->subscribers as $subscriber)
        {
            if ($subscriber->isSubscribedTo($domainEvent)){
                $subscriber->handle($domainEvent);
            }
        }
        return $this;
    }

    /**
     * https://youtu.be/kFJljyhOWpg?list=PLfgj7DYkKH3Cd8bdu5SIHGYXh_bPV2idP&t=317
     * @param $eventName
     * @param $callback
     */
    public function addListener($eventName, $callback)
    {}
}