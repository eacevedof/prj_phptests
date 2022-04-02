<?php
namespace App\Publishing\Application;

use App\Publishing\Domain\PostEntity;
use App\Publishing\Domain\PostRepository;
use App\Publishing\Domain\PublishPostCommand;
use App\Publishing\Domain\UserRepository;

/**
 * La diferencia entre un application service y un command handler
 * es que la ejecucion de un servicio se hace teniendo como entrada un input plano
 * mientras que la de un command handler se hace teniendo como entrada un DTO llammado command
 *
 * Este DTO permite que se pueda hacer un Decorator del
 */
final class PublishCommandHandler
{
    private PostRepository $postRepository;
    private UserRepository $userRepository;
    
    public function __construct(
        PostRepostiory $postRepository, 
        UserRepository $userRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(PublishPostCommand $command): PostEntity
    {
        $post = $this->postRepository->ofIdOrFail($command->postId());
        $user = $this->postRepository->ofIdOrFail($command->authorId());
        $post->publish($user);
        return $post;
    }
}