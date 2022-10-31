<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Slendie\Framework\Database\Connection;

use App\App;

final class ConnectionTest extends TestCase
{
    public function testCanBeSingleton()
    {
        $conn = Connection::getInstance();

        $this->assertInstanceOf(Connection::class, $conn);
    }

    public function testCanConnectToDatabase()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $this->assertInstanceOf(Connection::class, $conn);
    }

    /**
     * https://www.php.net/manual/en/pdo.query.php
     */
    public function testCanQuerySelect()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $query = $conn->query('SELECT * FROM users');

        $this->assertInstanceOf(PDOStatement::class, $query);
    }

    /**
     * https://www.php.net/manual/en/pdo.exec.php
     * https://www.php.net/manual/en/pdostatement.rowcount.php
     */
    public function testCanExecDelete()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $n_rows = $conn->exec('DELETE FROM `users`;');
        $sttm = $conn->query('SELECT * FROM `users`;');

        $rows = $sttm->fetchAll();

        $count_users = count( $rows );

        $this->assertEquals(0, $count_users);
    }

    /**
     * https://www.php.net/manual/en/pdo.exec.php
     */
    public function testCanExecuteSqlInsert()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $deleted_rows = $conn->exec('DELETE FROM `users`;');
        $inserted_rows = $conn->exec('INSERT INTO `users` (name, email, password) VALUES ("Test User", "test@test.com", "123456");');
        $sttm = $conn->query('SELECT * FROM `users`;');

        $rows = $sttm->fetchAll();

        $this->assertEquals(1, count( $rows ));
    }
}