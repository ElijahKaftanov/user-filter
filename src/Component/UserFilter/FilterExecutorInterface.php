<?php declare(strict_types=1);

namespace App\Component\UserFilter;


use App\Component\UserFilter\Condition\ConditionInterface;

/**
 * Interface FilterExecutorInterface
 * @package App\Component\UserFilter
 */
interface FilterExecutorInterface
{
    /**
     * @param ConditionInterface $condition
     * @return array
     */
    public function execute(ConditionInterface $condition): array;
}