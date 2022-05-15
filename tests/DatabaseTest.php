<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Slendie\Framework\Database\Database;
use Slendie\Framework\Environment\Environment;

final class DatabaseTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanBeSingleton()
    {
        $env = Environment::getEnvFile();
        $this->assertInstanceOf(Database::class, Database::getInstance( $env ));
    }
}