<?php
include_once("app/bootstrap.php");

use App\Publishing\Application\PublishCommandHandler;
use App\Publishing\Domain\PostRepository;
use App\Publishing\Domain\UserRepository;
use EventSourcing\DomainEventPublisher;
use App\Publishing\Domain\PublishPostCommand;

final class PostController
{
    public function publish(): void
    {
        $dispacher = DomainEventPublisher::instance();
        $dispacher->subscribe();
        //ejecuto el servicio
        (new PublishCommandHandler(
            new PostRepository(),
            new UserRepository()
        ))->execute(new PublishPostCommand(1, 1));
    }
}

(new PostController())->publish();