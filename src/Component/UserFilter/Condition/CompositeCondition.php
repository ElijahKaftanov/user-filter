<?php declare(strict_types=1);

namespace App\Component\UserFilter\Condition;


use InvalidArgumentException;

/**
 * Class CompositeCondition
 * @package App\Component\UserFilter\Condition
 */
class CompositeCondition implements ConditionInterface
{
    const TYPE_AND = 'and';
    const TYPE_OR  = 'or';

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $parts = [];

    /**
     * CompositeCondition constructor.
     * @param string $type
     * @param array $parts
     */
    public function __construct(string $type, array $parts = [])
    {
        if (!in_array($type, [self::TYPE_AND, self::TYPE_OR])) {
            throw new InvalidArgumentException('Invalid argument $type');
        }
        $this->type = $type;

        foreach ($parts as $part) {
            $this->add($part);
        }
    }

    /**
     * @param ConditionInterface $part
     */
    protected function add(ConditionInterface $part)
    {
        $this->parts[] = $part;
    }

    /**
     * @return array
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * Returns the type of this composite expression (AND/OR).
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}