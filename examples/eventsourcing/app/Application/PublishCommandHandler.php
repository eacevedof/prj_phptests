<?php
namespace App\Publishing;
use EventSourcing\DomainEventPublisher;

final class PublishCommandHandler
{
    private PostRepository $postRepository;
    private UserRepository $userRepository;
    private DomainEventPublisher $eventPublisher;
    
    public function __construct(
        PostRepostiory $postRepository, 
        UserRepository $userRepository, 
        DomainEventPublisher $eventPublisher
    )
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->eventPublisher = $eventPublisher;
    }

    public function handle(PostWasPublishedCommand $command)
    {
        $post = $this->postRepository->ofIdOrFail($command->postId());
        $user = $this->postRepository->ofIdOrFail($command->authorId());
        $post->publish($user);

        /**
         * aqui otras tareas fuera de la responsabilidad unica
         * enviar por email
         * peristir en sphinx etc, nos apoyamos en el evento
         */
        $event = new PostWasPublishedCommand($post->id(), $user->id());
        //eventdispathcer es una caja que tiene a los consumidores y productores, su metodo disparador puede llamarse
        //dispatch, notify, pub (de publisher/susbscriber)

        /**
         * si bien esto es aceptable lo mejor seria moverlo a publish para q si otro servicio ejecuta post->publish se notifique
         */
        $this->eventPublisher->publish($event);

        /**
         * LA OTRA OPCION SI LLEVAMOS LA PUBLICACION A LA ENTIDAD
         */
        $this->eventPublisher->publish($post->getEvents());

        return $post;
    }
}