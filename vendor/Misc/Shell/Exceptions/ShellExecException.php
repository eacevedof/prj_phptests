<?php

namespace Misc\Shell\Exceptions;

use Exception;

final class ShellExecException extends Exception
{
    public static function failIfEmptyCommands(): void
    {
        throw new self("No commands to be executed", 400);
    }
}
