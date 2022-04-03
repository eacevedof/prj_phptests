<?php
namespace App\Publishing\Infrastructure;

use EventSourcing\DomainEventPublisher;
use App\Publishing\Application\Commands\PublishCommand;
use App\Publishing\Application\NotifyService;
use App\Publishing\Application\PublishCommandHandler;
use App\Publishing\Infrastructure\Repositories\PostRepository;
use App\Publishing\Infrastructure\Repositories\UserRepository;

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
