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
        $postId = $this->getPost("postId", 1);
        $userId = $this->getPost("userId", 1);

        DomainEventPublisher::instance()->subscribe(new NotifyService(new UserRepository()));
        $publishCommand = new PublishCommand($postId, $userId);

        $post = (new PublishCommandHandler(
            new PostRepository(),
            new UserRepository()
        ))->execute($publishCommand);

        $this->set("post", $post)
            ->render("post-status");
    }

}
