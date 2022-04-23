<?php
namespace App\Blog\Infrastructure;

use App\Blog\Domain\Bus\ICommandBus;
use App\Blog\Application\Commands\CommandBus;
use App\Blog\Application\PostPublishCommand;

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
        /**
         *- bus->dispatch(command):
         *  - ejecuta commandHandler()(command)
         *      ejecuta: publisherService->publish(postidVO, useridVO)
         *          - lanza el evento: DomainEventBus::instance()->publish(postIdVO, userIdVO)
         */
        $post = $this->bus->dispatch(new PostPublishCommand($postId, $userId));
        $this->set("post", $post)
            ->render("post-status");
    }

}
