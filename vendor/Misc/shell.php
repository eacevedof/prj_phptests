<?php
namespace Misc;

final class Shell
{
    private array $commands = [];

    public static function getInstance(): self
    {
        return new self();
    }

    public function addCmd(string $cmd): self
    {
        $this->commands[] = $cmd;
        return $this;
    }
    
    public function exec(): array
    {
        $output = [];
        $resultCode = 0;
        exec('ls -l', $output, $resultCode);
        return $output;
    }

    public function reset(): self
    {
        $this->commands = [];
        return $this;
    }
}