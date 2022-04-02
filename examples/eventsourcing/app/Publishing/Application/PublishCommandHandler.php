<?php
namespace App\Publishing\Application;

use \App\Publishing\Domain\Event\PostWasPublishedCommand;
use \App\Publishing\Domain\ICommandHandler;
use \App\Publishing\Domain\PostEntity;
use \App\Publishing\Domain\PostRepository;
use \App\Publishing\Domain\UserRepository;
use \App\Publishing\Domain\PublishPostCommand;

/**
 * La diferencia entre un application service y un command handler
 * es que la ejecucion de un servicio se hace teniendo como entrada un input plano
 * mientras que la de un command handler se hace teniendo como entrada un DTO llammado command
 *
 * Este DTO permite que se pueda hacer un Decorator del
 */
final class PublishCommandHandler implements ICommandHandler
{
    private PostRepository $postRepository;
    private UserRepository $userRepository;

    public function __construct(
        \App\Publishing\Domain\PostRepository $postRepository,
        \App\Publishing\Domain\UserRepository $userRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(PostWasPublishedCommand $command): PostEntity
    {
        $post = $this->postRepository->ofIdOrFail($command->postId());
        $user = $this->userRepository->ofIdOrFail($command->authorId());
        $post->publish($user);
        return $post;
    }
}

/*
 * La ventaja de usar un command (event) es que al ser un DTO podriamos hacer un decorador (wrapper)
 * que nos permita hacer logica extra antes y despues de execute.
 *
 * Ejemplo: ver LoggerDecorator
 */
