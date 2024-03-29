<?php

namespace LHub\StateMachineRulesEvaluator;


/*
     public const

'AND' => 'Modules\TacticalRequests\Utils\RulesValidation\EvaluateConditionsAnd',
'OR' => 'Modules\TacticalRequests\Utils\RulesValidation\EvaluateConditionsOr',
'NOT' => 'Modules\TacticalRequests\Utils\RulesValidation\EvaluateConditionsNot',
'ASSIGN' => 'Modules\TacticalRequests\Utils\RulesValidation\AssignFromAttributes',
'MOTIVE-TACTICAL' => 'Modules\TacticalRequests\Utils\RulesValidation\EvaluateMotiveTactical',
'NOT-MOTIVE-TACTICAL' => 'Modules\TacticalRequests\Utils\RulesValidation\EvaluateNotMotiveTactical',
'REJECTION-REASON' => 'Modules\TacticalRequests\Utils\RulesValidation\EvaluateRejectionReason',
'NOT-REJECTION-REASON' => 'Modules\TacticalRequests\Utils\RulesValidation\EvaluateNotRejectionReason',

*/
enum OperatorEnum: string
{
    case AND = "AND";
    case OR = "OR";
    case NOT = "NOT";
    case ASSIGN = "ASSIGN";
    case MOTIVE_TACTICAL = "MOTIVIE_TACTICAL";
    case NON_MOTIVE_TACTICAL = "NON_MOTIVE_TACTICAL";
    case REJECTION_REASON = "REJECTION_REASON";
    case NOT_REJECTION_REASON = "NOT_REJECTION_REASON";
}
