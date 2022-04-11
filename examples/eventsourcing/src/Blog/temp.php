<?php
final class CreateVideoCommandHandler implements ICommandHandler
{
    private VideoCreatorAppService $creatorAppService;

    public function __construct(VideoCreatorAppService $creatorAppService)
    {
        $this->creatorAppService = $creatorAppService;
    }

    public function __invoke(CreateVideoCommand $command)
    {
        $id = new VideoId($command->id());
        $title = new VideoTitle($command->title());
        $url = new VideoUrl($command->url());
        $courseId = new CourseId($command->courseId());

        $this->creatorAppService->create(
            $id,
            $title,
            $url,
            $courseId
        );
    }
}