<?php declare(strict_types=1);

namespace App\Component\UserFilter\Doctrine;


use App\Component\UserFilter\Condition\ConditionInterface;
use App\Component\UserFilter\FilterExecutorInterface;
use Doctrine\DBAL\Connection;

/**
 * Class DoctrineExecutor
 * @package App\Component\UserFilter\Doctrine
 */
class DoctrineExecutor implements FilterExecutorInterface
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param ConditionInterface $condition
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function execute(ConditionInterface $condition): array
    {
        $compiler = new CompileCondition($condition, $this->connection->createQueryBuilder());

        $result = $this->connection->executeQuery($compiler->getSql(), $compiler->getParameters());

        return $result->fetchAll();
    }
}