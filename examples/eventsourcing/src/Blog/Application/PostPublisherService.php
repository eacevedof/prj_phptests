<?php
namespace App\Blog\Application;

use App\Blog\Domain\Events\PostWasPublishedEvent;
use App\Blog\Domain\PostEntity;
use App\Blog\Domain\Types\PostAuthorIdType;
use App\Blog\Domain\Types\PostIdType;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Shared\Infrastructure\Bus\EventBus;

//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Courses/Application/Create/CourseCreator.php
//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Videos/Application/Create/VideoCreator.php
final class PostPublisherService
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    //aqui se debe usar tipos personalizados
    public function publish(PostIdType $postId, PostAuthorIdType $authorId): PostEntity
    {
        $post = $this->postRepository->ofIdOrFail($postId);
        $post->publish();
        $this->postRepository->save($post);
        /**
         * forma carlos b.
         */
        //EventBus::instance()->publish(new PostWasPublishedEvent($postId->value(), $authorId->value()));
        /**
         * forma Codely
         */
        EventBus::instance()->publish(...$post->pullDomainEvents());
        return $post;
    }
}