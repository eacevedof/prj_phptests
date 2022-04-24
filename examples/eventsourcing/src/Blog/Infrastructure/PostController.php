<?php
namespace App\Blog\Infrastructure;

use App\Shared\Domain\Bus\Command\ICommandBus;
use App\Blog\Application\Commands\CommandBus;
use App\Blog\Application\PostPublishCommand;
use App\Shared\Infrastructure\Request\RequestTrait;
use App\Shared\Infrastructure\View\ViewTrait;

/**
 * https://github.com/CodelyTV/php-ddd-example/blob/main/src/Shared/Infrastructure/Symfony/ApiController.php
 * https://github.com/CodelyTV/php-ddd-example/blob/main/apps/mooc/backend/src/Controller/Courses/CoursesPutController.php
 */
final class PostController
{
    use RequestTrait;
    use ViewTrait;

    private ICommandBus $bus;

    public function __construct(ICommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function publish(): void
    {
        $userId = $this->getRequestSession("userId", 1);
        $postId = $this->getRequestPost("postId", 1);
        /**
         *- bus->publish(command):
         *  - ejecuta commandHandler()(command)
         *      ejecuta: publisherService->publish(postidVO, useridVO)
         *          - lanza el evento: DomainEventBus::instance()->publish(postIdVO, userIdVO)
         */
        $post = $this->bus->publish(new PostPublishCommand($postId, $userId));

        $this->set("post", $post)
            ->render(
                $this->_get_view(__DIR__,"post-status")
            );
    }
}
