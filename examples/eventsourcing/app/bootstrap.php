<?php
include_once("Publishing/Infrastructure/RequestTrait.php");
include_once("Publishing/Infrastructure/ViewTrait.php");

include_once("Publishing/Domain/IEntity.php");

include_once("Publishing/Domain/PostEntity.php");
include_once("Publishing/Domain/UserEntity.php");

include_once("Publishing/Domain/Ports/IPostRepository.php");
include_once("Publishing/Domain/Ports/IUserRepository.php");

include_once("Publishing/Domain/Event/PostWasPublishedEvent.php");

include_once("Publishing/Application/ICommandHandler.php");
include_once("Publishing/Application/Commands/ICommand.php");
include_once("Publishing/Application/Commands/PublishCommand.php");
include_once("Publishing/Application/PublishCommandHandler.php");
include_once("Publishing/Application/NotifyService.php");

include_once("Publishing/Infrastructure/PostController.php");
include_once("Publishing/Infrastructure/Repositories/UserRepository.php");
include_once("Publishing/Infrastructure/Repositories/PostRepository.php");