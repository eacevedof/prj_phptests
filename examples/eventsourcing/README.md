- Basado en **Rigor Talks de Carlos Buenosvinos**
- [Repo Rigor Talks](https://github.com/farso/RigorTalks)
- Videos playlist:
    - [Youtube - Rigor talks](https://www.youtube.com/watch?v=aKcmbOZV9mA&list=PLfgj7DYkKH3Cd8bdu5SIHGYXh_bPV2idP)
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
- [CodelyTv - CommandBus]()