<?php
namespace EventSourcing;

final class DomainEventPublisher
{
    //array del tipo DomainEventSubscriber
    private DomainEventSubscriber $subscribers;

    private static $instance = null;

    private $id = 0;

    public static function instance()
    {
        if (null === static::instance) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    private function __construct()
    {
        $this->subscribers = [];
    }

    public function __clone()
    {
        throw new \BadMethodCallException("Clone is not supported");
    }

    public function subscribe(DomainEventSubscriber $subbscriber)
    {
        $id = $this->id;
        $this->subscribers[$id] = $subbscriber;
        $this->id++;
        return $id;
    }

    public function ofId($id)
    {
        return $this->subscribers[$id] ?? null;
    }

    public function unsubscrib($id)
    {
        unset($this->subscribers[$id])
    }

    public function publish(DomainEvent $domainEvent)
    {
        foreach($this->subscribers as $subscriber)
        {
            if ($subscriber->isSubscribedTo($domainEvent)){
                $subscriber->handle($domainEvent);
            }
        }
    }
}