<?php declare(strict_types=1);

namespace App\Component\UserFilter;


use App\Component\UserFilter\Condition\ConditionInterface;

/**
 * Class UserFilterManager
 * @package App\Component\UserFilter
 */
class UserFilterManager implements UserFilterManagerInterface
{
    /**
     * @var FilterCompilerInterface
     */
    protected $compiler;

    /**
     * @var FilterExecutorInterface
     */
    private $executor;

    public function __construct(FilterExecutorInterface $executor, FilterCompilerInterface $compiler)
    {
        $this->executor = $executor;
        $this->compiler = $compiler;
    }

    public function filter($query)
    {
        $condition = $this->compile($query);
        return $this->execute($condition);
    }

    /**
     * @param $query
     * @return ConditionInterface
     * @throws \Exception
     */
    public function compile($query) : ConditionInterface
    {
        return $this->compiler->compile($query);
    }

    /**
     * @param ConditionInterface $condition
     * @return array
     */
    public function execute(ConditionInterface $condition)
    {
        return $this->executor->execute($condition);
    }
}