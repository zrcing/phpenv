<?php
namespace Phpenv;

class Env {
    
    private static $loader = NULL; //Singleton Loader
    
    public $envFiles = array(); //All environment files path
    
    protected  $lastEnvFile = NULL;
    
    protected  $overloader = false;
    
    /**
     * Load environment config
     * 
     * @param string $envFile Absolute path
     */
    public static function load($envFile = ".env") {
        
        self::getLoader()->innerLoad($envFile);
    }
    
    /**
     * Overload environment config
     * 
     * @param string $envFile Absolute path
     */
    public static function overload($envFile = ".env") {
        
        self::getLoader()->$overloader = true;
        self::getLoader()->innerLoad($envFile);
    }
    
    /**
     * Singleton Loader
     */
    public static function getLoader() {
         
        if(!(self::$loader instanceof self)) {
            self::$loader = new self();
        }
        return self::$loader;
    }
    
    /**
     * Inner load
     * 
     * @param string $envFile
     * @throws \InvalidArgumentException
     */
    protected function innerLoad($envFile) {
        
        $this->lastEnvFile = $envFile;
        
        if(!is_readable($this->lastEnvFile) || !is_file($this->lastEnvFile)) {
            throw new \InvalidArgumentException(sprintf('Phpenv: [%s] file not found or no readable', $this->lastEnvFile));
        }
        $this->envFiles[$envFile] = $envFile;
        
        $systemAutoDetectLine = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', '1');
        $rows = file($this->lastEnvFile, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
        ini_set('auto_detect_line_endings', $systemAutoDetectLine);
        
        foreach ($rows as $row) {
            $data = $this->filter($row);
            if($data != null) {
                list($key, $val) = $data;
                $val = $this->handleSemanticsVar($val);
                $this->setEnv($key, $val);
            }
        }
    }
    
    /**
     * Filter
     * 
     * @param string $var
     * @return mixed
     */
    protected function filter($var) {
        
        switch (true) {
            case strpos(trim($var), "#") === 0:
                return null;
            case strpos($var, "=") !== false:
                list($key, $val) = array_map("trim", explode("=", $var ,2));
                return array($key, $val);
            default:
                return null;
        }
    }
    
    /**
     * Resolve variables
     * 
     * @param string $var
     */
    protected function handleSemanticsVar($var) {
        
        list($var) = array_map("trim", explode("#", $var));
        switch (true) {
            case $var === "":
                return $var;
            case is_numeric($var):
                return $var;
            default:
                $beginStr = substr($var, 0, 1);
                if (in_array($beginStr, array('\'','"')) && $beginStr == substr($var, -1, 1)) {
                    return substr($var, 1, -1);
                }
                return $var;
        }
    }
    
    /**
     * Set environment
     * 
     * @param string $key
     * @param mixed $val
     */
    public static function setEnv($key, $val) {
        
        if (self::getLoader()->overloader == false) {
            if(self::getEnv($key)) {
                return;
            }
        }
        putenv("{$key}={$val}");
        $_ENV[$key] = $val;
        $_SERVER[$key] = $val;
    }
    
    /**
     * Get environment 
     * 
     * @param string $key
     * @return mixed
     */
    public static function getEnv($key) {
        
        switch (true) {
            case array_key_exists($key, $_ENV):
                return $_ENV[$key];
            case array_key_exists($key, $_SERVER);
                return $_SERVER[$key];
            default:
                return getenv($key);
        }
    }
}