<?php
/**
 * events listeners
 */
use App\Shared\Infrastructure\Bus\EventBus;

use App\Blog\Application\KafkaService;
use App\Blog\Application\MonologService;
use App\Blog\Application\NotifyService;
use App\Blog\Infrastructure\Repositories\UserRepository;

$publisher = EventBus::instance();
$publisher->subscribe(new NotifyService(new UserRepository()));
$publisher->subscribe(new MonologService());
$publisher->subscribe(new KafkaService());
