<?php
include_once("Publishing/Infrastructure/RequestTrait.php");

include_once("Publishing/Domain/IEntity.php");

include_once("Publishing/Domain/PostEntity.php");
include_once("Publishing/Domain/UserEntity.php");

include_once("Publishing/Domain/PostRepository.php");
include_once("Publishing/Domain/UserRepository.php");

include_once("Publishing/Domain/Event/PostWasPublishedEvent.php");

include_once("Publishing/Application/ICommandHandler.php");
include_once("Publishing/Application/PublishCommandHandler.php");
include_once("Publishing/Application/NotifyService.php");

include_once("Publishing/Infrastructure/PostController.php");