<?php

namespace LHub\StateMachineRulesEvaluator;

final class VerifyConditions extends AbstractEvaluateConditions
{
    //use EvaluateConditions

    private mixed $rules;
    protected int $assetId;
    protected mixed $task;
    protected int $status;

    private string $prePostConditionJson;

    public function __construct(string $prePostConditionJson, int $assetId, mixed $task = null)
    {
        $this->prePostConditionJson = $prePostConditionJson;
        $this->rules = json_decode($prePostConditionJson, true)["rules"];
        $this->assetId = $assetId;
        $this->task = $task;
        $this->action = [];

    }

    /**
     * esto devuelve el validador
     */
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
                $this->evaluateAllRules();
                $this->replaceActionArray();
            }

            return $this;

        }
        catch (Exception $e){
            throw new Exception(trans('rulesjson.exception.validation'), 400);
        }
    }

    private function evaluateAllRules(): void
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