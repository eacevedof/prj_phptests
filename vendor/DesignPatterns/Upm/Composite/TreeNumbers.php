<?php

namespace DesignPatterns\Upm\Composite;

use DesignPatterns\Upm\Composite\Number;

final class TreeNumbers
{
    private ?Number $number = null;
    private string $name = "";
    private array $treeNumbersList = [];

    private function __construct(Number $number, string $name)
    {
        $this->number = $number;
        $this->name = $name;
    }

    public function isComposite(): bool
    {
        return true;
    }

    public function add(TreeNumbers $treeNumbers): void
    {
        $this->treeNumbersList[] = $treeNumbers;
    }

    public function remove(TreeNumbers $treeNumbers): void
    {
        $this->treeNumbersList[] = $treeNumbers;
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