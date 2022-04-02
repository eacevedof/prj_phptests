<?php
include_once("Publishing/Infrastructure/RequestTrait.php");

include_once("Publishing/Domain/ICommandHandler.php");
include_once("Publishing/Domain/IEntity.php");

include_once("Publishing/Domain/PostEntity.php");
include_once("Publishing/Domain/UserEntity.php");

include_once("Publishing/Domain/PostRepository.php");
include_once("Publishing/Domain/UserRepository.php");

include_once("Publishing/Domain/Event/PostWasPublishedCommand.php");

include_once("Publishing/Application/PublishCommandHandler.php");