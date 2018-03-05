<?php declare(strict_types=1);

namespace App\Component\UserFilter;


/**
 * Interface FilterInterface
 * @package App\Component\UserFilter
 */
interface FilterInterface
{
    /**
     * Returns signature of filter
     * @return string
     */
    public function getSignature(): string;

    /**
     * @param $value
     * @return bool
     */
    public function validateValue($value): bool;
}