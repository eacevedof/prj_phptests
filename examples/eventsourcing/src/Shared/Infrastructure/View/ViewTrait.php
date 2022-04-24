<?php
namespace App\Shared\Infrastructure\View;

trait ViewTrait
{
    private array $vars = [];

    private function set(string $varName, $value): self
    {
        $this->vars[$varName] = $value;
        return $this;
    }

    private function render(string $path): void
    {
        foreach ($this->vars as $name=>$value) {
            $$name = $value;
        }

        include_once("$path.php");
        exit();
    }

    private function _get_view(string $thisdir, string $view): string
    {
        return "$thisdir/views/$view";
    }
}