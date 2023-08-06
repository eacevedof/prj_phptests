<?php

namespace LHub\StateMachineRulesEvaluator;

abstract class AbstractEvaluateConditions
{
    public const OPERATOR = [
        "AND" => "Modules\TacticalRequests\Utils\RulesValidation\EvaluateConditionsAnd",
        "OR" => "Modules\TacticalRequests\Utils\RulesValidation\EvaluateConditionsOr",
        "NOT" => "Modules\TacticalRequests\Utils\RulesValidation\EvaluateConditionsNot",
        "ASSIGN" => "Modules\TacticalRequests\Utils\RulesValidation\AssignFromAttributes",
        "MOTIVE-TACTICAL" => "Modules\TacticalRequests\Utils\RulesValidation\EvaluateMotiveTactical",
        "NOT-MOTIVE-TACTICAL" => "Modules\TacticalRequests\Utils\RulesValidation\EvaluateNotMotiveTactical",
        "REJECTION-REASON" => "Modules\TacticalRequests\Utils\RulesValidation\EvaluateRejectionReason",
        "NOT-REJECTION-REASON" => "Modules\TacticalRequests\Utils\RulesValidation\EvaluateNotRejectionReason",
    ];

    public function evaluate(array $conditions)
    {
        $result = null;

        foreach ($conditions as $key => $condition) {

            if($operation = $this->getEvaluationClassByOperator($condition["operator"])){
                if(!$result || $result->isEval()){
                    $result = $operation::init($condition, $this->task ?? $this->assetId);
                }
            }
        }

        return $result;
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