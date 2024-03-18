<?php
namespace Misc;

final class Shell
{
    private array $commands = [];

    public static function getInstance(): self
    {
        return new self();
    }



}