<?php
namespace App\Publishing\Application;

interface ICommandHandler
{
    //no puedo definir execute pq el DTO varia segun sus metodos a ejecutar en el cuerpo de
    //execute
    //public function execute($command): IEntity;
}