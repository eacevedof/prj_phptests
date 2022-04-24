<?php
namespace App\Blog\Domain;

//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Videos/Domain/Video.php
use App\Shared\Domain\IEntity;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Blog\Domain\Events\PostWasCreatedEvent;

final class PostEntity extends AggregateRoot implements IEntity
{
    private int $id;
    private int $authorId;
    private string $title;
    private string $content;
    private int $status;

    public function __construct(int $id, int $authorId, string $title="", string $content="")
    {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->title = $title;
        $this->content = $content;
        $this->status = 0;
    }

    public static function create(int $id, int $authorId, string $title="", string $content=""): self
    {
        $postEntity = new self($id, $authorId, $title, $content);
        //aqui se deberia agregar el evento createdomainevent
        $postEntity->record(new PostWasCreatedEvent($id, $authorId));
        return $postEntity;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function authorId(): int
    {
        return $this->authorId;
    }

    public function publish(): self
    {
        $this->status = 1;
        echo "post status changed ...<br/>";
        return $this;
    }
}