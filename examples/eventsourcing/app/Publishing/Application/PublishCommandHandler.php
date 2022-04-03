<?php
namespace App\Publishing\Application;

use App\Publishing\Application\Commands\PublishCommand;
use \App\Publishing\Domain\PostEntity;
use \App\Publishing\Domain\Ports\IPostRepository;
use \App\Publishing\Domain\Ports\IUserRepository;

/**
 * La diferencia entre un application service y un command handler
 * es que la ejecucion de un servicio se hace teniendo como entrada un input plano
 * mientras que la de un command handler se hace teniendo como entrada un DTO llammado command
 *
 * Este DTO permite que se pueda hacer un Decorator del
 */
final class PublishCommandHandler implements ICommandHandler
{
    private IPostRepository $postRepository;
    private IUserRepository $userRepository;

    public function __construct(
        IPostRepository $postRepository,
        IUserRepository $userRepository
    ){
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(PublishCommand $command): PostEntity
    {
        echo "command handler execute ...<br/>";
        $post = $this->postRepository->ofIdOrFail($command->postId());
        $user = $this->userRepository->ofIdOrFail($command->authorId());
        $post->publish($user);
        $this->postRepository->save($post);
        return $post;
    }
}

/*
 * La ventaja de usar un command (event) es que al ser un DTO podriamos hacer un decorador (wrapper)
 * que nos permita hacer logica extra antes y despues de execute.
 *
 * Ejemplo: ver LoggerDecorator
 */
