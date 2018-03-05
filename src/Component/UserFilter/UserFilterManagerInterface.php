<?php declare(strict_types=1);

namespace App\Component\UserFilter;


use App\Component\UserFilter\Condition\ConditionInterface;

/**
 * Interface UserFilterManagerInterface
 * @package App\Component\UserFilter
 */
interface UserFilterManagerInterface
{
    /**
     * @param $query
     * @return mixed
     */
    public function filter($query);

    /**
     * @param $query
     * @return ConditionInterface
     */
    public function compile($query) : ConditionInterface;

    /**
     * @param ConditionInterface $condition
     * @return mixed
     */
    public function execute(ConditionInterface $condition);
}