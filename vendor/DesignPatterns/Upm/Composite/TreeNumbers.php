<?php

namespace DesignPatterns\Upm\Composite;

use DesignPatterns\Upm\Composite\Number;

final class TreeNumbers
{
    private ?Number $number = null;
    private string $name = "";
    private array $theTree = [];

    private function __construct(Number $number, string $name = "")
    {
        $this->number = $number;
        $this->name = $name;
    }

    public static function getTreeNumbersByNumber(Number $number): self
    {
        return new self($number);
    }

    public static function getTreeNumbersByName(string $name): self
    {
        return new self($name);
    }

    public function isComposite(): bool
    {
        return true;
    }

    public function add(TreeNumbers $treeNumbers): void
    {
        $this->theTree[] = $treeNumbers;
    }

    public function remove(TreeNumbers $treeNumbers): void
    {
        $this->theTree[] = $treeNumbers;
    }

    public function numberOfTreeNumbers(): void
    {

    }

    public function sum(): int
    {
        return 0;
    }

    public function higher(): int
    {
        return 0;
    }

    public function toString(): string
    {
        return "";
    }


}