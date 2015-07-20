<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Interface IsSerializable
 * @package BDBStudios\BreakfastSerializer
 */
interface IsSerializable
{
    const FORMAT_PHP  = 1;
    const FORMAT_JSON = 2;
    const FORMAT_XML  = 4;
    const FORMAT_YML  = 8;

    const MAX_DEPTH_NOT_SET = -1;

    /**
     * @param object $data
     * @return string
     */
    public function serialize($data);

    /**
     * @param string $data
     * @return object
     *
     * @throws \LogicException
     */
    public function deserialize($data);
}
