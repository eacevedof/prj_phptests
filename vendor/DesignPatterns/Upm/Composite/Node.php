<?php

namespace DesignPatterns\Upm\Composite;

use DesignPatterns\Upm\Composite\TreeException;
use function PHPUnit\Framework\isInstanceOf;

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

    private function failIfNotValidNode(Node $node): void
    {
        //TreeException::wrongNode();
        //supongamos que solo tiene un nivel
        $components = $node->getComponents();
        foreach ($components as $component) {
            if (isInstanceOf(Number::class, $component))
                continue;


        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getComponents(): Node | Number
    {
        return $this->components[$this->name];
    }



}