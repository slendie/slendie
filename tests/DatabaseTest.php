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
        $db = Database::getInstance();

        $this->assertInstanceOf(Database::class, $db);
    }

    public function testCanFetchAllUsers()
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `users`;";
        $rows = $db->fetchAll( $sql );

        return $this->assertGreaterThan(0, count( $rows));
    }
}