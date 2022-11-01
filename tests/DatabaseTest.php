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

    public function testCanSelectAllUsers()
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `users`;";
        $rows = $db->selectAllPreparedSql( $sql );

        return $this->assertGreaterThan(0, count( $rows));
    }

    public function testCanSelectSingleUser()
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `users` WHERE `email` = ?;";

        $user = $db->selectPreparedSql( $sql, '', ['lastone@test.com'] );

        return $this->assertIsArray( $user );
    }

/*    public function testCanSelectAllUsersWithClass()
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `users`;";
        $rows = $db->selectAllPreparedSql( $sql, 'App\Models\User' );

        $row = $rows[0];

        return $this->assertInstanceOf('App\Models\User', $row);
    }

    public function testCanSelectSingleUserWithClass()
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `users` WHERE `email` = ?;";

        $user = $db->selectPreparedSql($sql, 'App\Models\User', ['lastone@test.com']);

        return $this->assertInstanceOf('App\Models\User', $user);
    }*/

    public function testCanInsertUser()
    {
        $db = Database::getInstance();

        $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (?, ?, ?);";

        $n_rows = $db->execPreparedSql($sql, ['Database User 1', 'database1@test.com', '123456']);

        return $this->assertEquals(1, $n_rows);
    }

    public function testCanUpdateUser()
    {
        $db = Database::getInstance();

        $sql = "UPDATE `users` SET `name` = :name WHERE `email` = :email;";

        $n_rows = $db->execPreparedSql( $sql, ['name' => 'Changed to Database User 2', 'email' => 'database1@test.com']);

        return $this->assertEquals(1, $n_rows);
    }

    public function testCanDeleteUser()
    {
        $db = Database::getInstance();

        $sql = "DELETE FROM `users` WHERE `email` = :email;";

        $n_rows = $db->execPreparedSql( $sql, ['email' => 'database1@test.com']);

        return $this->assertEquals(1, $n_rows);
    }

    public function testCanQuerySql()
    {
        $db = Database::getInstance();

        $query = $db->query('SELECT * FROM users');

        return $this->assertInstanceOf(PDOStatement::class, $query);
    }

    public function testCanExecSql()
    {
        $db = Database::getInstance();

        $inserted_rows = $db->exec('INSERT INTO `users` (name, email, password) VALUES ("Database Test 3", "database3@test.com", "123456");');

        return $this->assertEquals(1, $inserted_rows);
    }
}