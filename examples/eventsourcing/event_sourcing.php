<?php
include_once("app/bootstrap.php");

use App\Publishing\Application\PublishCommandHandler;
use App\Publishing\Domain\PostRepository;
use App\Publishing\Domain\UserRepository;
use EventSourcing\DomainEventPublisher;

$publisher = DomainEventPublisher::instance();
(new PublishCommandHandler(
    new PostRepository(),
    new UserRepository(),
    $publisher,
))->handle();