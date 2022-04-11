<?php
final class VideoController
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