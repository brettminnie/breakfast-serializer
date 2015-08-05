<?php

namespace BDBStudios\BreakfastSerializer\Plugin;

/**
 * Interface IsPlugin
 * @package BDBStudios\BreakfastSerializer\Plugin
 */
interface IsPlugin
{
    /**
     * @return IsPlugin
     */
    public function register();

    /**
     * @return IsPlugin
     */
    public function unregister();

    /**
     * @return IsPlugin
     */
    public function activate();

    /**
     * @return IsPlugin
     */
    public function deactivate();

    /**
     * @return boolean
     */
    public function isActive();

    /**
     * @return IsPlugin
     */
    public function execute();

    /**
     * @return string
     */
    public function getName();
}
