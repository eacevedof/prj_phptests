<?php
/**
 * events listeners
 */
use App\Shared\Infrastructure\Bus\EventBus;

use App\Blog\Application\KafkaService;
use App\Blog\Application\MonologService;
use App\Blog\Application\NotifyService;
use App\Blog\Infrastructure\Repositories\UserRepository;

$eventBus = EventBus::instance();
$eventBus->subscribe(new NotifyService(new UserRepository()));
$eventBus->subscribe(new MonologService());
$eventBus->subscribe(new KafkaService());
