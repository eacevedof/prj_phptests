- Basado en **Rigor Talks de Carlos Buenosvinos**
- [Repo Rigor Talks](https://github.com/farso/RigorTalks)
- Videos playlist:
    - [Youtube - Rigor talks](https://www.youtube.com/watch?v=aKcmbOZV9mA&list=PLfgj7DYkKH3Cd8bdu5SIHGYXh_bPV2idP)

- [Youtube - PulpoCon19 - Eventos, mensajería y otras fábulas (Carlos Buenosvinos)](https://www.youtube.com/watch?v=qwPFZ9v91kw&t=17s)  

- [CommandBus - Rigor talks](https://youtu.be/OIFwYYlO_Og?list=PLfgj7DYkKH3Cd8bdu5SIHGYXh_bPV2idP&t=308)
```php
final class CommandBus
{
    private array $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    public function addHandler(ICommand $command, ICommandHandler $handler): void
    {
        $this->handlers[] = ["command" => get_class($command), "handler"=>$handler];
    }

    public function dispatch(ICommand $command): void
    {
        foreach ($this->handlers as $array) {
            if (get_class($command) !== $array["command"]) continue;
            $handler = $array["handler"];
            //aqui se usa invoke, pero depende de la interfaz IComandHandler
            $handler($command);
        }
    }
}
```

- [CodelyTv - Controller](https://youtu.be/o0w-jYun6AU?t=1462)
```php
final class VideoController extends Controller
{
    private ICommandBus $bus;

    public function __construct(ICommandBus $bus)
    {
        $this->bus = $bus;
    }
    
    public function createAction(
        string $id,
        Request $request
    ) {
        $command = new CreateVideoCommand(
            $id,
            $request->get("title"),
            $request->get("url"),
            $request->get("course_id")
        );
        
        $this->bus->dispatch($command);
        return new HttpCreateResponse();
    }
}
```
- [CodelyTv - CreateVideoCommandHandler](https://youtu.be/o0w-jYun6AU?t=1496)
```php
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
```  

- [CodelyTv - VideoCreatorAppService](https://youtu.be/o0w-jYun6AU?t=1566)
```php
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
        $videoAggregateRoot = Video::create($id, $title, $url, $courseId);
        $this->videoRepository->save($videoAggregateRoot);
        $this->domainEventPublisher->publish($videoAggregateRoot->pullDomainEvents());
    }
}
```
- [CodelyTv - VideoAggregateRoot](https://youtu.be/o0w-jYun6AU?t=1597)
```php
abstract class AggregateRoot
{
    private array $domainEvents;
    
    public function addDomainEvent(IDomainEvent $event): void
    {
        $this->domainEvents[] = $event;
    }
    
    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }
}

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
        $video->addDomainEvent(new VideoCreatedDomainEvent($id));
        return $video;
    }
}
```