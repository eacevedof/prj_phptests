<?php

namespace DesignPatterns\Upm\Composite;

use DesignPatterns\Upm\Composite\TreeException;

final readonly class Node
{
    private array $components;

    public function __construct(private string $name)
    {
        if (!$this->name = trim($name))
            TreeException::nameCanNotBeEmpty();

        $this->components = [
            $this->name => []
        ];
    }

    public static function getNode(string $name): self
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