<?php
namespace App\Blog\Infrastructure\Repositories;

use App\Blog\Domain\Types\PostAuthorIdType;
use App\Blog\Domain\Types\PostContentType;
use App\Blog\Domain\Types\PostIdType;
use App\Blog\Domain\Types\PostTitleType;
use App\Shared\Domain\Aggregate\AbsAggregateRoot;
use App\Blog\Domain\Ports\IPostRepository;
use App\Blog\Domain\PostEntity;

//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Courses/Infrastructure/Persistence/DoctrineCourseRepository.php
final class PostRepository implements IPostRepository
{
    public function ofIdOrFail(PostIdType $id): PostEntity
    {
        return new PostEntity(
            $id,
            new PostAuthorIdType(1),
            new PostTitleType("Qué es Lorem Ipsum?"),
            new PostContentType(
            "  Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. <br/>
  Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T.
  persona que se dedica a la imprenta) <br/>
  desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen.
  No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos,
  quedando esencialmente igual al original. <br/>
  Fue popularizado en los 60s con la creación de las hojas \"Letraset\", las cuales contenian pasajes de Lorem Ipsum,
  y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones
  de Lorem Ipsum.
            ")
        );
    }

    public function save(AbsAggregateRoot $postEntity): void
    {
        echo "post {$postEntity->title()->value()} saved ...<br/>";
    }
}