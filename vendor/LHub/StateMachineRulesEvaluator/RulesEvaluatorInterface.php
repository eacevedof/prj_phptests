<?php

namespace LHub\StateMachineRulesEvaluator;

interface RulesEvaluatorInterface
{
                    public function isEvaluationOk(): bool;

                        public function evaluate(): void;
}