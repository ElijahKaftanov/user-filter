<?php declare(strict_types=1);

namespace App\Component\UserFilter\Doctrine;


use App\Component\UserFilter\Condition\CompositeCondition;
use App\Component\UserFilter\Condition\Condition;
use App\Component\UserFilter\Condition\ConditionInterface;
use App\Component\UserFilter\Filter\UserCountryFilter;
use App\Component\UserFilter\Filter\UserEmailFilter;
use App\Component\UserFilter\Filter\UserIdFilter;
use App\Component\UserFilter\Filter\UserNameFilter;
use App\Component\UserFilter\Filter\UserStatusFilter;
use App\Component\UserFilter\FilterInterface;
use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class CompileCondition
 * @package App\Component\UserFilter\Doctrine
 */
class CompileCondition
{
    /**
     * @var QueryBuilder
     */
    private $qb;

    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $sql;

    /**
     * CompileCondition constructor.
     * @param $condition
     * @param QueryBuilder $qb
     */
    public function __construct($condition, QueryBuilder $qb)
    {
        $this->qb = $qb;
        $this->params = [];
        $this->compile($condition);
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->params;
    }

    /**
     * @param ConditionInterface $condition
     */
    protected function compile(ConditionInterface $condition)
    {
        $cond = $this->comp($condition);
        $this->sql = $this->qb
            ->select('u.id', 'u.email', 'u.role', 'u.reg_date')
            ->from('users', 'u')
            ->innerJoin('u', 'users_about', 'a', 'u.id = a.user')
            ->where($cond)
            ->getSQL();
    }


    /**
     * @param ConditionInterface $cond
     * @return CompositeExpression|string
     * @throws \Exception
     */
    private function comp(ConditionInterface $cond)
    {
        if ($cond instanceof CompositeCondition) {

            $type = $this->getCompositeExpressionType($cond);
            $parts = array_map([$this, 'comp'], $cond->getParts());
            return new CompositeExpression($type, $parts);

        } elseif ($cond instanceof Condition) {

            return $this->createConditionExpression($cond);

        }
        throw new \InvalidArgumentException('$cond');
    }

    /**
     * @param CompositeCondition $cond
     * @return string
     * @throws \Exception
     */
    private function getCompositeExpressionType(CompositeCondition $cond)
    {
        $type = $cond->getType();
        if ($type === CompositeCondition::TYPE_AND) {
            return CompositeExpression::TYPE_AND;
        } elseif ($type === CompositeCondition::TYPE_OR) {
            return CompositeExpression::TYPE_OR;
        }
        throw new \Exception('Unexpected condition type ' . $type);
    }

    /**
     * @param Condition $condition
     * @return CompositeExpression|string
     * @throws \Exception
     */
    private function createConditionExpression(Condition $condition)
    {
        $expr = $this->getExpr();
        $col = $this->getColumnName($condition->getFilter());
        $operator = $condition->getOperator();
        if ($col[0] == 'u') {
            $this->addParam($condition->getValue());
            return $expr->comparison($col, $operator, '?');
        } elseif ($col[0] == 'a') {
            $item = explode('.', $col)[1];
            $this->addParam($item);
            $this->addParam($condition->getValue());
            return $expr->andX(
                $expr->eq('a.item', '?'),
                $expr->comparison('a.value', $operator, '?')
            );
        }
    }

    /**
     * TODO: Resolve hardcode
     *
     * @param FilterInterface $filter
     * @return string
     * @throws \Exception
     */
    private function getColumnName(FilterInterface $filter): string
    {
        $map = [
            UserIdFilter::class => 'u.id',
            UserEmailFilter::class => 'u.email',
            UserCountryFilter::class => 'a.country',
            UserStatusFilter::class => 'a.state',
            UserNameFilter::class => 'a.firstname',
        ];

        $class = get_class($filter);
        if (!isset($map[$class])) {
            throw new \Exception('There is no implementation for filter ' . $class);
        }

        return $map[$class];
    }

    /**
     * @param $value
     */
    private function addParam($value)
    {
        $this->params[] = $value;
    }

    /**
     * @return ExpressionBuilder
     */
    private function getExpr():ExpressionBuilder
    {
        return $this->qb->expr();
    }
}