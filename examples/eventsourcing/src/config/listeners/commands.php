<?php
/**
 * handles listeners
 */
use App\Blog\Application\PostPublishCommand;
use App\Blog\Application\PostPublishCommandHandler;
use App\Blog\Application\PostPublisherService;
use App\Blog\Infrastructure\Bus\CommandBus;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;

$bus = new CommandBus();
$bus->register(PostPublishCommand::class, new PostPublishCommandHandler(
    new PostPublisherService(
        new PostRepository(),
        new UserRepository()
    )
));
return $bus;