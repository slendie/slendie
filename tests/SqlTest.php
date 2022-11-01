<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Slendie\Framework\Database\Sql;

final class SqlTest extends TestCase
{
    public function testCanMakeSimpleSelect()
    {
        $sql = new Sql('users');
        $sql->select();
        $select = $sql->get();

        return $this->assertEquals('SELECT * FROM `users`', $select);
    }

    public function testCanMakeConcatenatedSelect()
    {
        $select = (new Sql('users'))->select()->get();

        return $this->assertEquals('SELECT * FROM `users`', $select);
    }

    public function testCanMakeSelectWhereWithValue()
    {
        $sql = new Sql('users');
        $sql->select()->where('id', 1);
        $select = $sql->get();

        return $this->assertEquals('SELECT * FROM `users` WHERE `id` = 1', $select);
    }

    public function testCanMakeSelectWhereWithoutValue()
    {
        $sql = new Sql('users');
        $sql->select()->where('id');
        $select = $sql->get();

        return $this->assertEquals('SELECT * FROM `users` WHERE `id` = :id', $select);
    }

    public function testCanMakeSelectWithMultipleWhere()
    {
        $select = (new Sql('users'))
            ->select()
            ->where('id', 1)
            ->orWhere('id', 2)
            ->orOpen()
            ->where('id', 3)
            ->where('id', 4)
            ->close()
            ->get();

        return $this->assertEquals('SELECT * FROM `users` WHERE `id` = 1 OR `id` = 2 OR (`id` = 3 AND `id` = 4)', $select);
    }

    public function testCanMakeSelectGroupAndOrder()
    {
        $select = (new Sql('users'))
            ->select(['role', 'name'])
            ->where('score', 1, '>')
            ->group('role')
            ->order('name', 'DESC')
            ->limit(10)
            ->offset(15)
            ->get();

        $expected = "SELECT `role`, `name` FROM `users` WHERE `score` > 1 GROUP BY `role` ORDER BY `name` DESC LIMIT 10 OFFSET 15";

        return $this->assertEquals($expected, $select);
    }

    public function testCanMakeInsert()
    {
        $insert = (new Sql('users'))
            ->insert(['name', 'email', 'password'])->get();

        $expected = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (?, ?, ?)";

        return $this->assertEquals($expected, $insert);
    }

    public function testCanMakeUpdate()
    {
        $update = (new Sql('users'))
            ->update(['name', 'email', 'password'])->get();

        $expected = "UPDATE `users` SET `name` = ?, `email` = ?, `password` = ?";

        return $this->assertEquals($expected, $update);
    }
}