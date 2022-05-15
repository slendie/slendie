<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Slendie\Framework\Database\Sql;

final class SqlTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanMakeASelect()
    {
        $sql = new Sql();
        $sql->setTable('sample');
        $sql->setIdColumn('id');

        $query = $sql->select()->get();

        $expected = "SELECT * FROM sample ;";
        $this->assertEquals($expected, $query);
    }

    /**
     * @return void
     */
    public function testCanMakeASingleSelect()
    {
        $sql = new Sql();
        $sql->setTable('sample');
        $sql->setIdColumn('id');
        $sql->setPairs(['id' => 1]);

        $query = $sql->where('id', 1)->select()->get();

        $expected = "SELECT * FROM sample WHERE id = 1;";
        $this->assertEquals($expected, $query);

        $sql = new Sql();
        $sql->setTable('sample');
        $sql->setIdColumn('id');
        $sql->setPairs(['id' => 1]);
        $query = $sql->where('id', 1)->whereAnd('name', 'John')->select()->get();

        $expected = "SELECT * FROM sample WHERE (id = 1 ) AND (name = 'John' );";
        $this->assertEquals($expected, $query);

        $sql = new Sql();
        $sql->setTable('sample');
        $sql->setIdColumn('id');
        $sql->setPairs(['id' => 1]);

        $query = $sql->where('id', 1)->whereAnd('name', 'John')->offset(5)->limit(10)->select()->get();

        $expected = "SELECT * FROM sample WHERE (id = 1 ) AND (name = 'John' ) LIMIT 10 OFFSET 5;";
        $this->assertEquals($expected, $query);

        $sql = new Sql();
        $sql->setTable('sample');
        $sql->setIdColumn('id');
        $sql->setPairs(['id' => 1]);

        $query = $sql->where('id', 1)->whereAnd('name', 'John')->orderBy('name')->offset(5)->limit(10)->select()->get();

        $expected = "SELECT * FROM sample WHERE (id = 1 ) AND (name = 'John' ) ORDER BY name ASC LIMIT 10 OFFSET 5;";
        $this->assertEquals($expected, $query);
    }
}