<?php

namespace DesignPatterns\Upm\Composite;

final class Number
{
    public function __construct(private readonly int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }
}