<?php declare(strict_types=1);

namespace App\Component\UserFilter\Filter;


use App\Component\UserFilter\FilterInterface;

/**
 * Class UserStatusFilter
 * @package App\Component\UserFilter\Filter
 */
class UserStatusFilter implements FilterInterface
{
    /**
     * Returns signature of filter
     * @return string
     */
    public function getSignature(): string
    {
        return 'state';
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