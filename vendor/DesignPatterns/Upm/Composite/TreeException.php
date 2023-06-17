<?php

namespace DesignPatterns\Upm\Composite;

use Exception;

final class TreeException extends Exception
{
    public static function unsupportedOperationException(): void
    {
        throw new self("Unsuported Operation Exception", 500);
    }

    public static function nameCanNotBeEmpty(): void
    {
        throw new self("Name can not be emtpy", 500);
    }

    public static function wrongNode(): void
    {
        throw new self("Lowest level of this node must be a number", 500);
    }
}