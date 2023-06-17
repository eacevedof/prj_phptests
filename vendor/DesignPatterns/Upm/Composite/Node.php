<?php

namespace DesignPatterns\Upm\Composite;

final readonly class Node
{
    private array $components;

    public function __construct(private string $name)
    {
        $this->components = [
            $this->name => []
        ];
    }

    public function fromPrimitives(string $name): self
    {
        return new self($name);
    }

    public function addNumber(Number $number): void
    {
        $this->components[$this->name][] = $number;
    }

    public function addNode(Node $node): void
    {
        $this->components[$this->name][] = $node;
    }

}