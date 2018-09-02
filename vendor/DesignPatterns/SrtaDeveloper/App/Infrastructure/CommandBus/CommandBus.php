<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\SrtaDeveloper\App\Infrastructure\CommandBus\CommandBus
 * @file CommandBus.php
 * @version 1.0.0
 * @date 02-09-2018 17:21
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\SrtaDeveloper\App\Infrastructure\CommandBus;

use DesignPatterns\SrtaDeveloper\App\CommandBusInterface;
use DesignPatterns\SrtaDeveloper\App\Command\CommandInterface;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

class CommandBus implements CommandBusInterface
{
    private $messageBus;

    public function __construct(MessageBusSupportingMiddleware $messageBus)
    {
        $this->messageBus = $messageBus;
    }//__construct

    public function execute(CommandInterface $command)
    {
        $this->messageBus->handle($command);
    }//execute    

}//CommandBus