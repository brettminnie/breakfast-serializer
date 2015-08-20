<?php

namespace BDBStudios\BreakfastSerializer\Plugin\DateTime;

use BDBStudios\BreakfastSerializer\Plugin\PluginAbstract;

/**
 * Class DateTimeHandler
 * @package BDBStudios\BreakfastSerializer\Plugin\DateTime
 */
class DateTimeHandler extends PluginAbstract implements IsDateTime
{
    const PLUGIN_NAME = 'PLUGIN_DATE_TIME_TO_ISO';

    /**
     * @param bool $active
     */
    public function __construct($active = true)
    {
        parent::__construct(self::PLUGIN_NAME, $active);
    }

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
            true === is_string($value)
            &&
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

    /**
     * @inheritDoc
     */
    public function execute(&$value = null)
    {
        if (true === empty($value)) {
            throw new \PluginExecutionException('No value has been passed through for conversion');
        }

        if (true === is_string($value) && true === $this->isISO8601String($value)) {
            $value = $this->fromISO8601Format($value);
        } elseif (true === $this->isDateTime($value)) {
            $value = $this->toISO8601Format($value);
        }

        return $this;
    }
}
