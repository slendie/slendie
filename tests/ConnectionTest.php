<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Slendie\Framework\Database\Connection;

use App\App;

final class ConnectionTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanBeSingleton()
    {
        $this->assertInstanceOf(PDO::class, Connection::getInstance());
    }
}