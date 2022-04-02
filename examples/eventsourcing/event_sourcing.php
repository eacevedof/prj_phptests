<?php
include_once("app/bootstrap.php");

use App\Publishing\Application\PublishCommandHandler;
use App\Publishing\Domain\PostRepository;
use App\Publishing\Domain\UserRepository;
use EventSourcing\DomainEventPublisher;
use App\Publishing\Domain\PublishPostCommand;

$command = new PublishPostCommand(1, 1);
$publisher = DomainEventPublisher::instance();
(new PublishCommandHandler(
    new PostRepository(),
    new UserRepository()
))->execute($command);