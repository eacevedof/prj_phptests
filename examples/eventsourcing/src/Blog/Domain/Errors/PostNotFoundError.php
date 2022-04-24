<?php
namespace App\Blog\Domain\Errors;

use App\Blog\Domain\Types\PostIdType;
use App\Shared\Domain\AbsDomainError;

final class PostNotFoundError extends AbsDomainError
{
    public function __construct(private PostIdType $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return "post_not_found";
    }

    protected function errorMessage(): string
    {
        return sprintf("Post <%s> has not been found", $this->id->value());
    }
}