<?php declare(strict_types=1);

namespace App\Component\UserFilter\Filter;


use App\Component\UserFilter\FilterInterface;

/**
 * Class UserIdFilter
 * @package App\Component\UserFilter\Filter
 */
class UserIdFilter implements FilterInterface
{
    /**
     * @inheritdoc
     */
    public function getSignature(): string
    {
        return 'id';
    }

    /**
     * @param $value
     * @return bool
     */
    public function validateValue($value): bool
    {
        // TODO: Implement validateValue() method.
    }
}