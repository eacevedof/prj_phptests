<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\App\Command\CommandInterface\CommandBusInterface
 * @file CommandBusInterface.php
 * @version 1.0.0
 * @date 02-09-2018 17:21
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\SrtaDeveloper\App\Command\CommandInterface;

interface CommandBusInterface 
{
    public function execute(CommandInterface $command);

}//CommandBusInterface