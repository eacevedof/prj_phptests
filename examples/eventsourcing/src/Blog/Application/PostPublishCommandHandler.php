<?php
namespace App\Blog\Application;

use App\Blog\Domain\PostEntity;
use App\Shared\Domain\Bus\Command\ICommandHandler;

/**
 * La diferencia entre un application service y un command handler
 * es que la ejecucion de un servicio se hace teniendo como entrada un input plano
 * mientras que la de un command handler se hace teniendo como entrada un DTO llammado command
 *
 * Este DTO permite que se pueda hacer un Decorator del Command Handler
 */
//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Videos/Application/Create/CreateVideoCommandHandler.php
final class PostPublishCommandHandler implements ICommandHandler
{
    private PostPublisherService $publisherService;

    public function __construct(PostPublisherService $publisherService)
    {
        $this->publisherService = $publisherService;
    }

    public function __invoke(PostPublishCommand $command): PostEntity
    {
        echo "command handler execute ...<br/>";
        return $this->publisherService->publish($command->postId(), $command->authorId());
    }
}

/*
 * La ventaja de usar un command (event) es que al ser un DTO podriamos hacer un decorador (wrapper)
 * que nos permita ejecutar logica extra antes y despues de execute.
 * Ejemplo: ver LoggerDecorator
 */
