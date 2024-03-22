<?php
namespace Misc\Shell;

final class ShellExec
{
    private array $commands = [];
    private string $oneLineCommand = "";
    
    private array $output = [];
    private ?int $resultCode = null;

    public static function getInstance(): self
    {
        return new self();
    }

    public function addCommand(string $command): self
    {
        $this->commands[] = $command;
        return $this;
    }
    
    public function exec(): self
    {
        if (!$this->commands)
            return $this;

        $this->loadOnleLineCommand();
        exec(
            $this->oneLineCommand, 
            $this->output, 
            $this->resultCode
        );

        return $this;
    }

    private function loadOnleLineCommand(): void
    {
        if ($this->oneLineCommand) return;

        $oneLineCommand = implode(" ", $this->commands);
        $this->oneLineCommand = trim($oneLineCommand);
    }

    public function getOutput(): array
    {
        return $this->output;
    }
    
    public function getResultCode(): ?int
    {
        return $this->resultCode;
    }
    
    public function printDebugCommand(): void
    {
        $this->loadOnleLineCommand();
        print_r($this->oneLineCommand);
    }

    public function getCommand(): string
    {
        $this->loadOnleLineCommand();
        return $this->oneLineCommand;
    }

    public function reset(): self
    {
        $this->commands = [];
        $this->oneLineCommand = "";
        $this->output = [];
        $this->resultCode = null;
        return $this;
    }
}