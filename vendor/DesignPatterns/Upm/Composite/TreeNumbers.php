<?php

namespace DesignPatterns\Upm\Composite;

use DesignPatterns\Upm\Composite\Number;

final class TreeNumbers
{
    private Number $number;
    private array $treeNumbersList = [];


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

    public function numberOfTreeNumbers(): int
    {
        return count($this->treeNumbersList);
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