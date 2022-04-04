<?php
namespace App\Blog\Infrastructure\Repositories;

use App\Blog\Domain\Ports\IPostRepository;
use App\Blog\Domain\PostEntity;

final class PostRepository implements IPostRepository
{
    public function ofIdOrFail(int $id): PostEntity
    {
        return new PostEntity(
            $id,
            "Qué es Lorem Ipsum?",
            "  Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. <br/>
  Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T.
  persona que se dedica a la imprenta) <br/>
  desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen.
  No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos,
  quedando esencialmente igual al original. <br/>
  Fue popularizado en los 60s con la creación de las hojas \"Letraset\", las cuales contenian pasajes de Lorem Ipsum,
  y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones
  de Lorem Ipsum.
            "
        );
    }

    public function save(PostEntity $postEntity): void
    {
        echo "post saved ...<br/>";
    }
}