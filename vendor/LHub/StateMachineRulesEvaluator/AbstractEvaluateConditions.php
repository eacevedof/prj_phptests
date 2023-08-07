<?php

namespace LHub\StateMachineRulesEvaluator;

abstract class AbstractEvaluateConditions
{

    public function __construct(private RulesEvaluatorFactory $rulesEvaluatorFactory)
    {}

    public function evaluate(array $conditions): ?RulesEvaluatorInterface
    {
        foreach ($conditions as $key => $condition) {
            $strOperator = $condition["operator"];
            if (!$operator = OperatorEnum::from($strOperator))
                continue;

            $evaluator = $this->rulesEvaluatorFactory->getEvaluatorByOperator($operator);

            if (!$comparison = $condition["comparison"])
                continue;

            $evaluator->evaluate($comparison);
            if ($evaluator->isEvaluationOk())
                return $evaluator;
        }
        return null;
    }

    public function evaluateStatus()
    {
        if(count($this->action) === 0){
            return null;
        }
        $statuses = array_column(array_column($this->action, 0), "status");
        return $statuses[0] ?? null;
    }

    public function evaluateAssign(): ?array
    {

        if(count($this->action) === 0){
            return null;
        }

        $arrayFinal = [];
        $arrayReplace = array_column(array_column($this->action, 0), "assign");

        foreach ($arrayReplace as $value){
            foreach ($value as $key => $data) {
                // se mergean los mismos indices de array ejemplo roles, users, user_attr
                $arrayFinal[$key] = array_merge($arrayFinal[$key] ?? [], $data);
            }
        }

        return $arrayFinal;
    }

    public function evaluateReplace(): ?array
    {
        if(count($this->action) === 0){
            return null;
        }

        $arrayFinal = [];
        $arrayReplace = array_column(array_column($this->action, 0), "replace");

        foreach ($arrayReplace as $value){
            foreach ($value as $key => $data) {
                // se mergean los mismos indices de array ejemplo roles, users, user_attr
                $arrayFinal[$key] = array_merge($arrayFinal[$key] ?? [], $data);
            }
        }

        return $arrayFinal;
    }

    public function evaluateAction(): bool
    {
        if(count($this->action) === 0){
            return false;
        }

        return true;
    }

    private function getEvaluationClassByOperator(string $operator): string
    {
        return self::OPERATOR[$operator] ?? "";
    }
}