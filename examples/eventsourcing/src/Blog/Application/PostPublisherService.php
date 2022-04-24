<?php
namespace App\Blog\Application;

use App\Blog\Domain\Events\PostWasPublishedEvent;
use App\Blog\Domain\PostEntity;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Shared\Infrastructure\Bus\EventBus;

//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Videos/Application/Create/VideoCreator.php
final class PostPublisherService
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function publish(int $postId, int $authorId): PostEntity
    {
        $post = $this->postRepository->ofIdOrFail($postId);
        $post->publish();
        $this->postRepository->save($post);
        EventBus::instance()->publish(new PostWasPublishedEvent($postId, $authorId));
        return $post;
    }
}