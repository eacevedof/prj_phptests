<?php

namespace DesignPatterns\Upm\Composite;

final readonly class NumbersLeaf
{

    public function __construct(
        private array $numbers = []
    )
    {}

    public function addNumber(Number $number): void
    {

    }

}