<?php
namespace App\Shared\Infrastructure\Repositories;

use App\Shared\Domain\EventStoreEntity;
use App\Shared\Domain\Bus\Event\IEvent;

/**
 * [Carlos Buenosvinos - Logging domain events](https://youtu.be/V2_Jnjp8PfE)
 */
final class EventStoreRepository
{
    public function append(IEvent $aEvent): void
    {
        $eventStoreEntity = new EventStoreEntity(
            get_class($aEvent),
            $aEvent->occurredOn(),
            serialize($aEvent),
        );
        $this->_save($eventStoreEntity);
    }

    private function _save(EventStoreEntity $eventStoreEntity): void
    {
        echo "saving event: ". print_r($eventStoreEntity, 1);
    }
}