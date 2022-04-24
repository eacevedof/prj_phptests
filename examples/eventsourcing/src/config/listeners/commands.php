<?php
/**
 * add listeners to CommandBus
 */
use App\Shared\Infrastructure\Bus\CommandBus;

use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;
use App\Blog\Application\PostPublisherService;
use App\Blog\Application\PostPublishCommandHandler;
use App\Blog\Application\PostPublishCommand;

$bus = CommandBus::instance();
$bus->subscribe(PostPublishCommand::class, new PostPublishCommandHandler(
    new PostPublisherService(
        new PostRepository(),
        new UserRepository()
    )
));