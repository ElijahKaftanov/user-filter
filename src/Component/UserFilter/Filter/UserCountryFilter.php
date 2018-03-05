<?php declare(strict_types=1);

namespace App\Component\UserFilter\Filter;


use App\Component\UserFilter\FilterInterface;

/**
 * Class UserCountryFilter
 * @package App\Component\UserFilter\Filter
 */
class UserCountryFilter implements FilterInterface
{

    /**
     * Returns signature of filter
     * @return string
     */
    public function getSignature(): string
    {
        return 'country';
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