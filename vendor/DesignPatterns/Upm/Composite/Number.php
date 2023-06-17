<?php

namespace DesignPatterns\Upm\Composite;

final class Number
{
    public function __construct(private readonly int $value)
    {
    }

    public static function getNumber(int $value): self
    {
        return new self($number);
    }

    public function value(): int
    {
        return $this->value;
    }
}