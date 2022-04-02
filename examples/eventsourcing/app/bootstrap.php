<?php
include_once("Domain/ICommandHandler.php");

include_once("Domain/IEntity.php");
include_once("Domain/PostEntity.php");
include_once("Domain/UserEntity.php");
include_once("Domain/PostRepository.php");
include_once("Domain/UserRepository.php");
include_once("Domain/Event/PostWasPublishedCommand.php");
include_once("Infrastructure/RequestTrait.php");
include_once("Application/PublishCommandHandler.php");