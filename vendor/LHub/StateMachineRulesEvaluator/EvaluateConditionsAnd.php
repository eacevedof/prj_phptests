<?php

namespace LHub\StateMachineRulesEvaluator;

final class EvaluateConditionsAnd implements RulesEvaluatorInterface
{
    private  bool $evaluationResult;

    public function isEvaluationOk(): bool
    {
        return $this->evaluationResult;
    }

    public function evaluate(array $comparison): void
    {
        try {
            foreach ($this->conditions["comparison"] as $value){
                $attributeValue = $this->getAttributeValue($this->assetId, $value["asset_type_attr_id"]);
                                $attributeValueId = ($value["value"] ?? "");

                if($this->isSelectableJsonAttributeValue($attributeValue)){
                    $attributeValueId = (int) ($value["value"] ?? "");
                    $this->findIdInSelectableJsonOrFail($attributeValue, $attributeValueId);
                    continue;
                }

                $this->evaluateForNoJsonStringOrFail($attributeValue, $attributeValueId);
            }
            $this->evaluationResult = true;
        }
        catch (Exception $ex){
            $this->evaluationResult = false;
        }
    }

    private  function isSelectableJsonAttributeValue(string $string): bool
    {
                return  preg_match("/[\[{]|[}\]]/", $attributeValue);
    }
    

    public function setEval(bool $eval): void
    {
        $this->evaluationResult = $eval;
    }

    private function getAttributeValue($assetId, $typeId): mixed
    {
        return AttributeRepository::getAssetAttributeValueByAssetIdAndAssetTypeAttrId($assetId, $typeId);
    }

    private function evaluateForNoJsonStringOrFail(string $value, string $match): void
    {
        if($value != $match){
            throw new Exception(trans("rulesjson.exception.simple"), 400);
        }
    }

    private function findIdInSelectableJsonOrFail(string $attributeValue, int $idToFind): void
    {
        // despues probar cuando match (lo q viene del json) es un array de valores
        $jsonDecode = json_decode($attributeValue, true);
        if (!in_array($idToFind, array_column($jsonDecode, "id"))) {
            throw new Exception(trans("rulesjson.exception.json"), 400);
        }
    }    
}