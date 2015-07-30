<?php

namespace BDBStudios\BreakfastSerializer\Property\TypeHandler;

/**
 * Interface IsDateTime
 * @package BDBStudios\BreakfastSerializer\Property\TypeHandler
 */
interface IsDateTime
{
    const ISO_STRING = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(-|\+)\d{4}$/';

    const CONFIGURATION_KEY  = 'dateTime';

    /**
     * @param  mixed $value
     * @return boolean
     */
    public function isDateTime($value);

    /**
     * @param  mixed $value
     * @return boolean
     */
    public function isISO8601String($value);

    /**
     * @param \DateTime $value
     * @return string
     */
    public function toISO8601Format(\DateTime $value);

    /**
     * @param  string $value
     * @return \DateTime
     */
    public function fromISO8601Format($value);

    /**
     * @param array $configurationData
     * @return bool
     */
    public static function isEnabledInConfiguration(array $configurationData);
}
