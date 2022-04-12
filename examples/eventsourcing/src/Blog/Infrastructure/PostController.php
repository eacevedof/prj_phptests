<?php
namespace App\Blog\Infrastructure;

use App\Blog\Application\KafkaService;
use App\Blog\Application\MonologService;
use App\Blog\Domain\Bus\ICommandBus;
use App\Blog\Domain\Ports\IPostRepository;
use App\Blog\Domain\Ports\IUserRepository;
use EventSourcing\DomainEventPublisher;
use App\Blog\Application\PublishPostCommand;
use App\Blog\Application\NotifyService;
use App\Blog\Application\PublishPostCommandHandler;
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

        $publisher = DomainEventPublisher::instance();
        $publisher->subscribe(new NotifyService($userRepository = new UserRepository()));
        $publisher->subscribe(new MonologService());
        $publisher->subscribe(new KafkaService());

        $publishCommand = new PublishPostCommand($postId, $userId);

        //el handler lanza el evento: PostWasPublishedEvent
        $post = (new PublishPostCommandHandler(
            new PostRepository(),
            $userRepository
        ))->execute($publishCommand);

        $this->set("post", $post)
            ->render("post-status");
    }

}
