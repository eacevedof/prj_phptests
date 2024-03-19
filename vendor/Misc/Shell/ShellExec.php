<?php
namespace Misc\Shell;

final class ShellExec
{
    private array $commands = [];
    private string $cmds = "";
    
    private array $output = [];
    private ?int $resultCode = null;

    public static function getInstance(): self
    {
        return new self();
    }

    public function addCmd(string $cmd): self
    {
        $this->commands[] = $cmd;
        return $this;
    }
    
    public function exec(): self
    {
        if (!$this->commands)
            return [
                "output" => [],
                "result_code" => null,
            ];

        $output = [];
        $resultCode = 0;

        $cmds = implode(" ", $this->commands);
        $this->cmds = trim($cmds);

        exec(
            $this->cmds, 
            $this->output, 
            $this->resultCode
        );

        return $this;
    }
    
    public function output(): array
    {
        return $this->output;
    }
    
    public function rresultCode(): ?int
    {
        return $this->resultCode;
    }

    public function reset(): self
    {
        $this->commands = [];
        $this->cmds = "";
        $this->output = [];
        $this->resultCode = null;
        
        return $this;
    }
}