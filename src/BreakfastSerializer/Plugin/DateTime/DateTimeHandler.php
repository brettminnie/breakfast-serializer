<?php

namespace BDBStudios\BreakfastSerializer\Plugin\DateTime;

use BDBStudios\BreakfastSerializer\Plugin\PluginInterface;

/**
 * Class DateTimeHandler
 * @package BDBStudios\BreakfastSerializer\Plugin\DateTime
 */
class DateTimeHandler implements PluginInterface, IsDateTime
{
    /**
     * @inheritdoc
     */
    public function isDateTime($value)
    {
        return (true === ($value instanceof \DateTime));
    }

    /**
     * @inheritdoc
     */
    public function isISO8601String($value)
    {
        return (
            1 === preg_match(
                IsDateTime::ISO_STRING,
                $value
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function toISO8601Format(\DateTime $value)
    {
        return $value->format(\DateTime::ISO8601);
    }

    /**
     * @inheritDoc
     */
    public function fromISO8601Format($value)
    {
        return \DateTime::createFromFormat(\DateTime::ISO8601, $value);
    }

    /**
     * @inheritDoc
     */
    public static function isEnabledInConfiguration(array $configurationData)
    {
        return (
            isset($configurationData['typeHandler'][IsDateTime::CONFIGURATION_KEY])
            &&
            $configurationData['typeHandler'][IsDateTime::CONFIGURATION_KEY]
        );
    }
}
