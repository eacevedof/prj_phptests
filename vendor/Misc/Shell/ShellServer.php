<?php
namespace Misc\Shell;

final class ShellServer
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
        if (!$this->commands)
            return [
                "output" => [],
                "result_code" => null,
            ];

        $output = [];
        $resultCode = 0;

        $cmds = implode(" ", $this->commands);
        $cmds = trim($cmds);

        exec($cmds, $output, $resultCode);

        return [
            "output" => $output,
            "result_code" => $resultCode,
        ];
    }

    public function reset(): self
    {
        $this->commands = [];
        return $this;
    }
}