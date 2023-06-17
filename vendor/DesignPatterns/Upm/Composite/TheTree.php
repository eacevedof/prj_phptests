<?php

namespace DesignPatterns\Upm\Composite;

use DesignPatterns\Upm\Composite\Number;

final class TheTree
{
    private const ROOT_NAME = "root";
    private array $theTree = [];

    private function __construct()
    {
        $this->theTree = [
            self::ROOT_NAME => []
        ];
    }

    public function addNode(Node $node): void
    {
        $this->theTree[self::ROOT_NAME][] = $node;
    }

    public function addNumber(Node $number): void
    {
        $this->theTree[self::ROOT_NAME][] = $number;
    }

    public function numberOfNodes(): int
    {
        return 0;
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