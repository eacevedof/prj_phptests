<?php
namespace App\Blog\Infrastructure;

use EventSourcing\DomainEventPublisher;
use App\Blog\Application\Commands\PublishCommand;
use App\Blog\Application\NotifyService;
use App\Blog\Application\PublishCommandHandler;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;

final class PostController
{
    use RequestTrait;
    use ViewTrait;

    public function publish(): void
    {
        $userId = $this->getRequestSession("userId", 1);
        $postId = $this->getRequestPost("postId", 1);

        DomainEventPublisher::instance()->subscribe(new NotifyService($userRepository = new UserRepository()));
        $publishCommand = new PublishCommand($postId, $userId);

        $post = (new PublishCommandHandler(
            new PostRepository(),
            $userRepository
        ))->execute($publishCommand);

        $this->set("post", $post)
            ->render("post-status");
    }

}
