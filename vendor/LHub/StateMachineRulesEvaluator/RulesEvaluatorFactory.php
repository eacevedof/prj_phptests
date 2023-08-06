<?php

namespace LHub\StateMachineRulesEvaluator;


final class RulesEvaluatorFactory
{


    public function getEvaluatorByOperator(OperatorEnum $operatorEnum): RulesEvaluatorInterface
    {
            return match($operatorEnum) {
                OperatorEnum::OR => new EvaluateConditionsOr(),
                OperatorEnum::AND => new EvaluateConditionsAnd(),
                OperatorEnum::NOT=> new EvaluateConditionsNot()
            };
    }

}