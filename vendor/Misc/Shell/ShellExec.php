<?php
namespace Misc\Shell;

use Error;
use Exception;
use Misc\Shell\Exceptions\ShellExecException;

final class ShellExec
{
    private array $commands = [];
    private string $oneLineCommand = "";

    private array $output = [];
    private int $resultCode = 0; //ok

    public static function getInstance(): self
    {
        return new self;
    }

    public function addCommand(string $command): self
    {
        $this->commands[] = $command;
        return $this;
    }

    public function exec(): self
    {
        $this->loadOneLineCommand();
        if (!$this->oneLineCommand)
            ShellExecException::failIfEmptyCommands();

        try {
            $lastLine = exec(
                $this->oneLineCommand,
                $this->output,
                $this->resultCode
            );
            if ($this->resultCode)
                $this->output[] = "error:\t$this->oneLineCommand\t(result_code: $this->resultCode)";
        }
        catch (Exception $ex) {
            $this->resultCode = 1;
            $this->output[] = $ex->getMessage();
        }
        catch (Error $err) {
            $this->resultCode = 1;
            $this->output[] = $err->getMessage();
        }
        return $this;
    }

    private function loadOneLineCommand(): void
    {
        if ($this->oneLineCommand) return;

        $oneLineCommand = implode(" ", $this->commands);
        $this->oneLineCommand = trim($oneLineCommand);
    }

    public function getOutput(): array
    {
        return $this->output;
    }

    public function isError(): bool
    {
        return (bool) $this->resultCode;
    }

    public function printDebugCommand(): void
    {
        $this->loadOneLineCommand();
        echo $this->oneLineCommand;
    }

    public function getCommand(): string
    {
        $this->loadOneLineCommand();
        return $this->oneLineCommand;
    }

    public function reset(): self
    {
        $this->commands = [];
        $this->oneLineCommand = "";
        $this->output = [];
        $this->resultCode = 0;
        return $this;
    }
}
