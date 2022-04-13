<?php
namespace App\Blog\Infrastructure;

use App\Blog\Application\KafkaService;
use App\Blog\Application\MonologService;
use App\Blog\Application\PostPublisherService;
use App\Blog\Domain\Bus\ICommandBus;
use App\Blog\Domain\Ports\IPostRepository;
use App\Blog\Domain\Ports\IUserRepository;
use EventSourcing\DomainEventPublisher;
use App\Blog\Application\PostPublishCommand;
use App\Blog\Application\NotifyService;
use App\Blog\Application\PostPublishCommandHandler;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;
use App\Blog\Application\Commands\CommandBus;

final class PostController
{
    use RequestTrait;
    use ViewTrait;

    private ICommandBus $bus;

    public function __construct(ICommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function publish(): void
    {
        $userId = $this->getRequestSession("userId", 1);
        $postId = $this->getRequestPost("postId", 1);

        $publishCommand = new PostPublishCommand($postId, $userId);
        $this->bus->register(PostPublishCommand::class, new PostPublishCommandHandler(
            new PostPublisherService(
                new PostRepository(),
                $userRepository = new UserRepository()
            )
        ));

        //ejecuta handler->invoke($publishCommand)
        //que a su vez ejecuta service->publish($postId, $authorId)
        $this->bus->dispatch($publishCommand);

        $publisher = DomainEventPublisher::instance();
        $publisher->subscribe(new NotifyService($userRepository));
        $publisher->subscribe(new MonologService());
        $publisher->subscribe(new KafkaService());

        /*
        $publishCommand = new PostPublishCommand($postId, $userId);

        //el handler lanza el evento: PostWasPublishedEvent
        $post = (new PostPublishCommandHandler(
            new PostRepository(),
            $userRepository
        ))->execute($publishCommand);
        */

        $this->set("post", $post)
            ->render("post-status");
    }

}
