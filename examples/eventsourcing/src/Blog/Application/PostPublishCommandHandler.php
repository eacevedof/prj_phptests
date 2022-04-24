<?php
namespace App\Blog\Application;

use App\Blog\Application\PostPublishCommand;
use App\Blog\Domain\Events\PostWasPublishedEvent;
use App\Blog\Domain\PostEntity;
use App\Blog\Domain\Ports\IPostRepository;
use App\Blog\Domain\Ports\IUserRepository;
use EventSourcing\DomainEventBus;
use App\Shared\Domain\Bus\Command\ICommandHandler;

/**
 * La diferencia entre un application service y un command handler
 * es que la ejecucion de un servicio se hace teniendo como entrada un input plano
 * mientras que la de un command handler se hace teniendo como entrada un DTO llammado command
 *
 * Este DTO permite que se pueda hacer un Decorator del Command Handler
 */
final class PostPublishCommandHandler implements ICommandHandler
{
    private PostPublisherService $publisherService;

    public function __construct(PostPublisherService $publisherService)
    {
        $this->publisherService = $publisherService;
    }

    public function __invoke(PostPublishCommand $command)
    {
        echo "command handler execute ...<br/>";

        return $this->publisherService->publish($command->postId(), $command->authorId());
        /*
        $post = $this->postRepository->ofIdOrFail($command->postId());
        $user = $this->userRepository->ofIdOrFail($command->authorId());
        $post->publish($user);
        //si la persistencia lanza una excepción no se publicaría el evento
        $this->postRepository->save($post);
        DomainEventPublisher::instance()->publish(
            new PostWasPublishedEvent(
                $post->id(),
                $user->id()
            )
        );
        */
        //return $post;

    }
}

/*
 * La ventaja de usar un command (event) es que al ser un DTO podriamos hacer un decorador (wrapper)
 * que nos permita ejecutar logica extra antes y despues de execute.
 * Ejemplo: ver LoggerDecorator
 */
