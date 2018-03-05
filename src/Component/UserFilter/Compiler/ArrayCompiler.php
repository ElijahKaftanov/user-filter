<?php declare(strict_types=1);

namespace App\Component\UserFilter\Compiler;


use App\Component\UserFilter\Condition\CompositeCondition;
use App\Component\UserFilter\Condition\Condition;
use App\Component\UserFilter\Condition\ConditionInterface;
use App\Component\UserFilter\FilterCompilerInterface;
use App\Component\UserFilter\FilterInterface;

/**
 * Class ArrayCompiler
 * @package App\Component\UserFilter
 */
class ArrayCompiler implements FilterCompilerInterface
{
    /**
     * @var FilterInterface[]
     */
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = [];
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    /**
     * @param FilterInterface $filter
     */
    protected function addFilter(FilterInterface $filter)
    {
        $this->filters[$filter->getSignature()] = $filter;
    }

    /**
     * @param array $query
     * @return CompositeCondition|ConditionInterface
     * @throws \Exception
     */
    public function compile($query):ConditionInterface
    {
        $first = array_shift($query);
        if ($this->isLogicalOperator($first)) {
            $operands = array_map([$this, 'compile'], $query);

            return $this->createComposite($first, $operands);
        } elseif ($this->isComparisonOperator($first)) {
            return $this->createCondition($first, $query);
        }

        throw new \Exception('First item of $query should be operator');
    }

    /**
     * @param string $type
     * @param $query
     * @return ConditionInterface
     * @throws \Exception
     */
    protected function createCondition(string $type, $query): ConditionInterface
    {
        $filter = array_shift($query);
        $filter = $this->findFilter($filter);
        $value = array_shift($query);
        return new Condition($filter, $type, $value);
    }

    /**
     * @param string $name
     * @return FilterInterface|mixed
     * @throws \Exception
     */
    protected function findFilter(string $name)
    {
        if (!array_key_exists($name, $this->filters)) {
            throw new \Exception('No filters registered with signature ' . $name);
        }
        return $this->filters[$name];
    }

    /**
     * @param string $type
     * @param array $conditions
     * @return CompositeCondition
     */
    protected function createComposite(string $type, array $conditions)
    {
        return new CompositeCondition($type, $conditions);
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function isLogicalOperator(string $name)
    {
        return in_array($name, ['or', 'and']);
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function isComparisonOperator(string $name)
    {
        return in_array($name, ['=', '!=']);
    }
}