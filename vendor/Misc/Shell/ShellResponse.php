<?php
namespace Misc\Shell;

final class ShellResponse
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getToken(array $output): string
    {

    }
}