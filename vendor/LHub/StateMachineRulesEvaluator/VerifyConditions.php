<?php

namespace LHub\StateMachineRulesEvaluator;

final class VerifyConditions extends AbstractEvaluateConditions
{
    //use EvaluateConditions

    private mixed $rules;
    protected int $assetId;
    protected mixed $task;
    protected array $action;
    protected int $status;
    private mixed $jsonValue;

    public function __construct($json, $assetId, $task = null)
    {
        $this->rules = json_decode($json, true)["rules"];
        $this->assetId = $assetId;
        $this->task = $task;
        $this->action = [];
        $this->jsonValue = $json;
    }

    public function verify()
    {
        try {

            $isCheckAll = json_decode($this->jsonValue, true)["checkAll"] ?? false;

            // si el json tiene que detenerse a la primera condicion que se cumpla entra por aca
            if(!$isCheckAll){
                foreach ($this->rules as $rule) {
                    foreach ($rule as $condition){
                        if(isset($condition['conditions'])){
                            $result = $this->evaluate($condition['conditions']);
                            if($result && $result->isEval()){
                                return $this->setAction($rule);
                            }
                        }
                    }
                }
            }

            // si el json debe evaluarse completo entra por aca
            if($isCheckAll){
                $this->fullEvaluate($this->rules);
                $this->replaceActionArray();
            }

            return $this;

        } catch (Exception $e){
            throw new Exception(trans('rulesjson.exception.validation'), 400);
        }
    }

    private function fullEvaluate(array $rule): void
    {
        foreach ($this->rules as $rule) {
            foreach ($rule as $condition) {
                if (isset($condition['conditions'])) {
                    $result = $this->evaluate($condition['conditions']);
                    if ($result && $result->isEval()) {
                        $this->action[] = array_column($rule, 'action');
                    }
                }
            }
        }
    }

    private function setAction(array $conditions): self
    {
        $this->action = array_column($conditions, 'action');
        return $this;
    }

    private function replaceActionArray(): void
    {
        $replaceActionArray = [];
        foreach ($this->action as $key => $value) {
            $replaceActionArray[$key] = $value[0];
        }
        $this->action = $replaceActionArray;
    }

}