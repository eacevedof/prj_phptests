<?php
final class VideoCreatorAppService
{
    private VideoRepository $videoRepository;
    private DomainEventPublisher $domainEventPublisher;

    public function __construct(VideoRepository $videoRepository, DomainEventPublisher $domainEventPublisher)
    {
        $this->videoRepository = $videoRepository;
        $this->domainEventPublisher = $domainEventPublisher;
    }

    public function create(
        VideoId $id,
        VideoTitle $title,
        VideoUrl $url,
        CourseId $courseId
    )
    {
        $videoEntity = Video::create($id, $title, $url, $courseId);
        $this->videoRepository->save($videoEntity);
        $this->domainEventPublisher->publish($videoEntity->pullDomainEvents());
    }
}