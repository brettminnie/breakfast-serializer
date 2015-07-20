<?php


namespace BDBStudios\BreakfastSerializer\Property;

/**
 * Class ExcludableProperty
 * @package BDBStudios\BreakfastSerializer\Property
 */
trait ExcludableProperty
{
    /**
     * @param string $propertyName
     * @param string $currentClassName
     * @param array $configuration
     * @return bool
     */
    public function isExcluded($propertyName, $currentClassName, array $configuration)
    {
        if (true === isset($configuration['exclusions'][$currentClassName]['excludeVariables'])) {

            return array_key_exists(
                $propertyName,
                array_flip(
                    $configuration['exclusions'][$currentClassName]['excludeVariables']
                )
            );
        }

        return false;

    }
}
