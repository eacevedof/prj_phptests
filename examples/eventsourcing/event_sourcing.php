<?php
include_once("app/bootstrap.php");

use App\Publishing\Application\PublishCommandHandler;
use App\Publishing\Domain\PostRepository;
use App\Publishing\Domain\UserRepository;
use EventSourcing\DomainEventPublisher;
use App\Publishing\Domain\PublishPostCommand;

//este es el payload de entrada
$command = new PublishPostCommand(1, 1);
$publisher = DomainEventPublisher::instance();

//ejecuto el servicio
(new PublishCommandHandler(
    new PostRepository(),
    new UserRepository()
))->execute($command);