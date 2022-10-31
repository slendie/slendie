<?php
namespace App;

use Slendie\Framework\Environment\Environment;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * Get the environment file name
     */
    public function testCanGetFilename()
    {
        $env = Environment::getInstance();
        $this->assertEquals( SITE_FOLDER . '.env', $env->getFilename() );
    }

    /**
     * Set the environment file name
     */
    public function testCanSetEnvFile()
    {
        $env = Environment::getInstance();
        $env->setEnvFile( SITE_FOLDER . '.env.testing' );
        
        $this->assertEquals( SITE_FOLDER . '.env.testing', $env->getFilename() );
    }

    /**
     * Get a key
     */
    public function testCanGetKey()
    {
        $env = Environment::getInstance();
        $env->load();

        $this->assertEquals( 'Slendie', $env->get('APP_TITLE') );
    }

    /**
     * Get a key from a section
     */
    public function testCanGetKeyFromSection()
    {
        $env = Environment::getInstance();
        $env->load();

        $env_value = $env->get('DATABASE');

        $this->assertEquals( 'sqlite', $env_value['DRIVER'] );
    }

    /**
     * Get a key from environment 
     */
    public function testCanGetKeyFromEnvironment()
    {
        $env = Environment::getInstance();
        $env->load();

        $this->assertEquals( 'Slendie', getenv('APP_TITLE') );
    }

    /**
     * Get a key from environment from a section
     */
    public function testCanGetKeyFromEnvironmentFromSection()
    {
        $env = Environment::getInstance();
        $env->load();

        $this->assertEquals( 'sqlite', getenv('DATABASE.DRIVER') );
    }

    /**
     * Get array from environment
     */
    public function testCanGetArrayFromEnvironment()
    {
        $env = Environment::getInstance();
        $env->load();

        $expected = [
            'VIEW_PATH'     => 'resources.views',
            'VIEW_CACHE'    => 'resources.cache',
            'VIEW_EXTENSION' => 'tpl.php',
        ];

        $this->assertEquals( $expected, $env->get('VIEW') );
    }

    public function testCanGetRightEnvironmentFile()
    {
        $database_name = env('DATABASE')['DBNAME'];

        $expected = "C:\\web\\php\\slendie\\storage\\slendie.sqlite3";

        $this->assertEquals( $expected, $database_name );
    }
}