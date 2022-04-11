<?php
final class VideoAggregateRoot extends AggregateRoot
{
    private VideoId $id;
    private VideoTitle $title;
    private VideoUrl $url;
    private CourseId $courseId;

    public function __construct(VideoId $id, VideoTitle $title, VideoUrl $url, CourseId $courseId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->url = $url;
        $this->courseId = $courseId;
    }

    public static function create(
        VideoId $id,
        VideoTitle $title,
        VideoUrl $url,
        CourseId $courseId
    )
    {
        $video = new self($id, $title, $url, $courseId);
        $video->record(new VideoCreatedDomainEvent($id));
        return $video;
    }
}