<?php
namespace App\Blog\Application;

use App\Shared\Domain\Bus\Command\ICommand;

//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Videos/Application/Create/CreateVideoCommand.php
final class PostPublishCommand implements ICommand
{
    private int $postId;
    private int $authorId;

    public function __construct(int $postId, int $authorId)
    {
        $this->postId = $postId;
        $this->authorId = $authorId;
    }

    public function postId():int
    {
        return $this->postId;
    }

    public function authorId():int
    {
        return $this->authorId;
    }
}