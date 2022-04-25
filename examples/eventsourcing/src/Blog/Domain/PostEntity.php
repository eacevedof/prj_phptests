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
    }

    public static function create(PostIdType $id, PostAuthorIdType $authorId, PostTitleType $title, PostContentType $content): self
    {
        $postEntity = new self($id, $authorId, $title, $content);
        //aqui se deberia agregar el evento createdomainevent. El contenido de los eventos va en raw
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

    public function publish(): self
    {
        $this->status = new PostStatusType(1);
        echo "post status changed ...<br/>";
        return $this;
    }
}