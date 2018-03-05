<?php declare(strict_types=1);

namespace App\Component\UserFilter\Condition;


use App\Component\UserFilter\FilterInterface;

/**
 * Class Condition
 * @package App\Component\UserFilter\Condition
 */
class Condition implements ConditionInterface
{
    /**
     * @var FilterInterface
     */
    private $filter;
    /**
     * @var string
     */
    private $operator;

    /**
     * @var mixed
     */
    private $value;

    /**
     * Condition constructor.
     * @param FilterInterface $filter
     * @param string $operator
     * @param $value
     */
    public function __construct(FilterInterface $filter, string $operator, $value)
    {
        $this->filter = $filter;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * @return FilterInterface
     */
    public function getFilter(): FilterInterface
    {
        return $this->filter;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}