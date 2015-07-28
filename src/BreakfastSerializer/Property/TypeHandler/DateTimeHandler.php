<?php

namespace BDBStudios\BreakfastSerializer\Property\TypeHandler;

trait DateTimeHandler
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
}
