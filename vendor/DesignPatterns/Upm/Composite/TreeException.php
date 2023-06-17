<?php

namespace DesignPatterns\Upm\Composite;

use Exception;

final class TreeException extends Exception
{
    public static function unsupportedOperationException(): void
    {
        throw new self("Unsuported Operation Exception", 500);
    }
}