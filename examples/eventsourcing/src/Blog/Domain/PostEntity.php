<?php
namespace App\Blog\Domain;

//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Videos/Domain/Video.php
final class PostEntity extends AggregateRoot implements IEntity
{
    private int $id;
    private int $authorId;
    private int $status;
    private string $title;
    private string $content;

    public function __construct(int $id, int $authorId, string $title="", string $content="")
    {
        $this->id = $id;
        $this->status = 0;
        $this->title = $title;
        $this->content = $content;
        $this->authorId = $authorId;
    }

    public static function create(int $id, int $authorId, string $title="", string $content=""): self
    {
        $postEntity = new self($id, $authorId, $title, $content);
        //aqui se deberia agregar el evento createdomainevent

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

    public function publish(): self
    {
        $this->status = 1;
        echo "post status changed ...<br/>";
        return $this;
    }
}