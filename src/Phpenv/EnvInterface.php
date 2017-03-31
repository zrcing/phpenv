<?php
/**
 * @author Liao Gengling <liaogling@gmail.com>
 */
namespace Phpenv;

interface EnvInterface
{
    /**
     * Load environment config
     *
     * @param string $envFile Absolute path
     */
    public static function load($envFile = ".env");

    /**
     * Overload environment config
     *
     * @param string $envFile Absolute path
     */
    public static function overload($envFile = ".env");

    /**
     * Singleton Loader
     *
     * @return Env
     */
    public static function getLoader();

    /**
     * Set environment
     *
     * @param string $key
     * @param mixed $val
     */
    public static function setEnv($key, $val);

    /**
     * Get environment
     *
     * @param string $key
     * @return mixed
     */
    public static function getEnv($key);

}