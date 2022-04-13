<?php
namespace App\Blog\Application;

use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;
use EventSourcing\DomainEventPublisher;

final class PostPublisherService
{
    private PostRepository $postRepository;
    private UserRepository $userRepository;

    public function __construct(PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function publish(int $postId, int $authorId)
    {
        $post = $this->postRepository->ofIdOrFail($postId);
        //$user = $this->userRepository->ofIdOrFail($authorId);
        $post->publish();
        $this->postRepository->save($post);

    }
}