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
     * @depends testCanConnectToDatabase
     */
    public function testCanReturnPdoStatement()
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
     * @depends testCanReturnPdoStatement
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
     * @depends testCanExecDelete
     */
    public function testCanExecInsert()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $deleted_rows = $conn->exec('DELETE FROM `users`;');
        $inserted_rows = $conn->exec('INSERT INTO `users` (name, email, password) VALUES ("Test User", "test@test.com", "123456");');

        $this->assertEquals(1, $inserted_rows);
    }

    /**
     * @depends testCanExecInsert
     */
    public function testCanQuerySingleSelect()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $sttm = $conn->query("SELECT * FROM `users` WHERE `email` = 'test@test.com';");

        $row = $sttm->fetch();

        $this->assertEquals('Test User', $row['name']);
    }

    /**
     * https://www.php.net/manual/en/pdo.prepare.php
     * @depends testCanExecInsert
     */
    public function testCanExecPrepareSelect()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $sql = "SELECT * FROM `users` WHERE `email` = :email;";
        $sttm = $conn->prepare( $sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY] );
        $sttm->execute(['email' => 'test@test.com']);

        $row = $sttm->fetch();

        $this->assertEquals('Test User', $row['name']);

        $sttm->execute(['email' => 'noone@test.com']);
        
        $row = $sttm->fetch();

        $this->assertEquals(false, $row);
    }

    /**
     * https://www.php.net/manual/en/pdo.prepare.php
     * @depends testCanExecInsert
     */
    public function testCanExecPrepareSelectQuotation()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $sql = "SELECT * FROM `users` WHERE `email` = ?;";
        $sttm = $conn->prepare( $sql );
        $sttm->execute(['test@test.com']);

        $row = $sttm->fetch();

        $this->assertEquals('Test User', $row['name']);

        $sttm->execute(['noone@test.com']);
        
        $row = $sttm->fetch();

        $this->assertEquals(false, $row);
    }

    /**
     * https://www.php.net/manual/en/pdo.prepare.php
     * @depends testCanConnectToDatabase
     */
    public function testCanExecPrepareInsert()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (:name, :email, :password);";
        $sttm = $conn->prepare( $sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY] );
        $n_rows = $sttm->execute([
            'name'      => 'User Prepared 1',
            'email'     => 'prepared1@test.com',
            'password'  => '123456',
        ]);

        $this->assertEquals(1, $n_rows);
    }

    /**
     * https://www.php.net/manual/en/pdo.prepare.php
     * @depends testCanExecPrepareInsert
     */
    public function testCanExecPrepareUpdate()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $sql = "UPDATE `users` SET `name` = :name WHERE `email` = :email;";
        $sttm = $conn->prepare( $sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY] );
        $n_rows = $sttm->execute([
            'name'      => 'User Updated 1',
            'email'     => 'prepared1@test.com',
        ]);

        $sttm = $conn->query("SELECT * FROM `users` WHERE `email` = 'prepared1@test.com';");
        $row = $sttm->fetch();

        $this->assertEquals('User Updated 1', $row['name']);
    }

    /**
     * https://www.php.net/manual/en/pdo.errorinfo.php
     * @depends testCanConnectToDatabase
     */
    public function testCanGetErrorInfo()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $sql = "bogus SQL";
        try {
            $sttm = $conn->prepare( $sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY] );
            $errorMsg = '';
        } catch (\PDOException $e) {
            $msg = $e->getMessage();
            $errorMsg = $conn->errorInfo()[2];
        }

        $this->assertEquals('near "bogus": syntax error', $errorMsg);
    }

    /**
     * https://www.php.net/manual/en/pdo.errorcode.php
     * @depends testCanConnectToDatabase
     */
    public function testCanGetErrorCode()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        try {
            $sttm = $conn->exec("INSERT INTO bones(skull) VALUES ('lucy')");
            $errorMsg = '';
        } catch (\PDOException $e) {
            $msg = $e->getMessage();
            $errorMsg = $conn->errorCode();
        }

        $this->assertEquals('HY000', $errorMsg);
    }

    /**
     * https://www.php.net/manual/en/pdo.errorcode.php
     * @depends testCanConnectToDatabase
     */
    public function testCanGetErrorFromCatch()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        try {
            $sttm = $conn->exec("INSERT INTO bones(skull) VALUES ('lucy')");
            $msg = '';
            $code = 0;
        } catch (\PDOException $e) {
            $msg = $e->getMessage();
            $code = $e->getCode();
        }

        $this->assertEquals('HY000', $code);
    }

    /**
     * https://www.php.net/manual/en/pdo.lastinsertid.php
     * @depends testCanConnectToDatabase
     */
    public function testGetLastInsertId()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (:name, :email, :password);";
        $sttm = $conn->prepare( $sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY] );
        $n_rows = $sttm->execute([
            'name'      => 'Last User Inserted',
            'email'     => 'lastone@test.com',
            'password'  => '123456',
        ]);

        $id = $conn->lastInsertId();

        $sql = "SELECT * FROM `users` WHERE `email` = ?";
        $sttm = $conn->prepare( $sql );
        $sttm->execute(['lastone@test.com']);

        $row = $sttm->fetch();

        $this->assertEquals($row['id'], $id);
    }

    /**
     * https://www.php.net/manual/en/pdo.begintransaction.php
     * @depends testCanConnectToDatabase
     */
    public function testCanRollbackTransaction()
    {
        $conn = Connection::getInstance();
        $conn->setOptions( env('DATABASE') );
        $conn->connect();

        $conn->beginTransaction();

        $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (:name, :email, :password);";
        $sttm = $conn->prepare( $sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY] );
        $n_rows = $sttm->execute([
            'name'      => 'Not inserted data',
            'email'     => 'noone@test.com',
            'password'  => '123456',
        ]);

        $conn->rollback();

        $sql = "SELECT * FROM `users` WHERE `email` = ?";
        $sttm = $conn->prepare( $sql );
        $sttm->execute(['noone@test.com']);

        $row = $sttm->fetch();

        $this->assertEquals(false, $row);
    }
}