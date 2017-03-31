<?php
/**
 * @author Liao Gengling <liaogling@gmail.com>
 */
use Phpenv\Env;

class PhpenvTest extends PHPUnit_Framework_TestCase
{
    public function testEnv()
    {
        Env::load(__DIR__.'/.env');

        $this->assertEquals('root', Env::getEnv('DB_USER'));
        $this->assertEquals('3306', Env::getEnv('DB_PORT'));
        $this->assertEquals('http://assets.test.com', Env::getEnv('ASSETS_URL'));
    }
}