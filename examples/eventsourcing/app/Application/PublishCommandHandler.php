<?php
namespace App\Publishing\Application;

use App\Publishing\Domain\PostEntity;
use App\Publishing\Domain\Event\PostWasPublishedCommand;
use App\Publishing\Domain\PostRepository;
use App\Publishing\Domain\UserRepository;

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

    public function handle(PostWasPublishedCommand $command): PostEntity
    {
        $post = $this->postRepository->ofIdOrFail($command->postId());
        $user = $this->postRepository->ofIdOrFail($command->authorId());
        $post->publish($user);
        return $post;
    }
}