<?php
namespace Misc;

final class Shell
{
    public static function getInstance(): self
    {
        return new self();
    }

}