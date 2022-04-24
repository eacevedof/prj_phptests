<?php
/**
 * events listeners
 */
use App\Blog\Application\KafkaService;
use App\Blog\Application\MonologService;
use App\Blog\Application\NotifyService;
use EventSourcing\DomainEventBus;
use App\Blog\Infrastructure\Repositories\UserRepository;

$publisher = DomainEventBus::instance();
$publisher->subscribe(new NotifyService(new UserRepository()));
$publisher->subscribe(new MonologService());
$publisher->subscribe(new KafkaService());
