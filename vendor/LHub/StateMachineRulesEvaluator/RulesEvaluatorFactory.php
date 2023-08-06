<?php

namespace LHub\StateMachineRulesEvaluator;


final class RulesEvaluatorFactory
{

    public function getEvaluatorByOperator(OperatorEnum $operatorEnum): RulesEvaluatorInterface
    {
            return match($operatorEnum) {
                OperatorEnum::OR
            };
    }

}