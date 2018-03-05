<?php declare(strict_types=1);

namespace App\Component\UserFilter;


use App\Component\UserFilter\Condition\ConditionInterface;

interface FilterCompilerInterface
{
    public function compile($query): ConditionInterface;
}