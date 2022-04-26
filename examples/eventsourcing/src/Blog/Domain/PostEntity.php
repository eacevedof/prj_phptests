<?php
namespace App\Blog\Domain;

//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Videos/Domain/Video.php
use App\Shared\Domain\Aggregate\AbsAggregateRoot;
use App\Shared\Domain\IEntity;
use App\Blog\Domain\Types\PostIdType;
use App\Blog\Domain\Types\PostAuthorIdType;
use App\Blog\Domain\Types\PostTitleType;
use App\Blog\Domain\Types\PostContentType;
use App\Blog\Domain\Types\PostStatusType;
use App\Blog\Domain\Events\PostWasCreatedEvent;
use App\Shared\Infrastructure\Bus\EventBus;

//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Courses/Domain/Course.php
//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Videos/Domain/Video.php
final class PostEntity extends AbsAggregateRoot implements IEntity
{
    private PostIdType $id;
    private PostAuthorIdType $authorId;
    private PostTitleType $title;
    private PostContentType $content;
    private PostStatusType $status;

    public function __construct(PostIdType $id, PostAuthorIdType $authorId, PostTitleType $title, PostContentType $content)
    {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->title = $title;
        $this->content = $content;
        $this->status = new PostStatusType(0);

        /**
         * forma carlos b:
         * mi duda: Si esto se hace en el new... cuando se recuperen registros de una bd y se use este método
         * se lanzaría el evento?
         */
        //EventBus::instance()->publish(new PostWasCreatedEvent($id->value(), $authorId->value()));
    }

    public static function create(
        PostIdType $id,
        PostAuthorIdType $authorId,
        PostTitleType $title,
        PostContentType $content
    ): self
    {
        /**
         * Punto importante. En codely usan la estrategia de los name constructors mientras que Carlos B.
         * sugiere que deberia lanzarse el evento dentro del new EntidadX()
         * [DDD y CQRS: Preguntas Frecuentes](https://youtu.be/auEhX4WfCRA?t=1008)
         *
         * - Los valores del constructor del evento son de tipos primitivos
         */
        $postEntity = new self($id, $authorId, $title, $content);

        /**
         * forma Codely
         */
        $postEntity->record(new PostWasCreatedEvent($id->value(), $authorId->value()));
        return $postEntity;
    }

    public function id(): PostIdType
    {
        return $this->id;
    }

    public function status(): PostStatusType
    {
        return $this->status;
    }

    public function title(): PostTitleType
    {
        return $this->title;
    }

    public function content(): PostContentType
    {
        return $this->content;
    }

    public function authorId(): PostAuthorIdType
    {
        return $this->authorId;
    }

    public function publish(): void
    {
        $this->status = new PostStatusType(1);
        echo "post status changed ...<br/>";
        $this->record(new PostWasCreatedEvent($this->id->value(), $this->authorId()->value()));
    }
}