<?php

namespace DesignPatterns\Upm\Composite;

final readonly class Node
{

    public function __construct(
        private array $components = []
    )
    {}

    public function addNumber(Number $number): void
    {
        $this->components[] = $number;
    }

    public function addNode(Node $node): void
    {
        $this->components[] = $node;
    }


}