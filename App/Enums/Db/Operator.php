<?php
namespace App\Enums\Db;

enum Operator: string{
    case IS = 'IS';
    case IS_NOT = 'IS NOT';
    case IN = 'IN';
    case NOT_IN = 'NOT IN';
    case EQUAL = '=';
    case NOT_EQUAL = '!=';
    case MORE = '>';
    case LESS = '<';
    case MORE_OR_EQUAL = '>=';
    case LESS_OR_EQUAL = '<=';
    case LIKE = 'LIKE';
    //TODO between


}