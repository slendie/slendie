<?php
namespace App;

use Slendie\Framework\Routing\Router;
use Slendie\Framework\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private function createRoutes()
    {
        Route::get(['set' => '/', 'as' => 'home'], 'AppController@index');
        Route::get(['set' => '/tasks', 'as' => 'tasks.index'], 'TaskController@index');
        Route::get(['set' => '/tasks/create', 'as' => 'tasks.create'], 'TaskController@create');
        Route::post(['set' => '/tasks/create', 'as' => 'tasks.store'], 'TaskController@store');
        Route::get(['set' => '/tasks/{id}/edit', 'as' => 'tasks.edit'], 'TaskController@edit');
        Route::post(['set' => '/tasks/{id}/edit', 'as' => 'tasks.update'], 'TaskController@update');
    }
    /**
     * Com PHPUnit toda classe precisa terminar com Test,
     * como por exemplo, RouterTest.
     * 
     * Todo método de teste precisa iniciar com test e
     * descrever o que ele está testando, como 
     * testEsseMetodoDescreveOQueDeveAcontecer()
     *
     * @return void
     */
    public function testIfThisIsTrue()
    {
        $response = true;
        $expected = 1;

        /**
         * O método assertEquals é provido pela classe TestCase
         * que a RouterTest (esta que estamos) está herdando
         * ele verifica se o valor esperado (expected) é igual
         * ao valor atual (actual);
         */
        $this->assertEquals($expected, $response);
    }

    /**
     * @return void
     */
    public function testCheckIfFoundRoute()
    {
        $this->createRoutes();

        $actual = Route::translate('tasks.index', []);

        /**
         * When in SAPI Cli mode, we do not have protocol or domain.
         */
        $expected = '://tasks';

        $this->assertEquals($expected, $actual);

        $actual = Route::translate('tasks.edit', ['id' => 2]);
        $expected = '://tasks/2/edit';

        return $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function testCheckIfNotFoundRoute()
    {
        $this->createRoutes();

        $actual = Route::translate('hello-world', []);
        $expected = '://hello-world';

        return $this->assertNotEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function testCheckIfFoundRouteWithWrongMethod()
    {
        //
        return $this->assertEquals(1, 1);
    }

    /**
     * @return void
     */
    public function testCheckIfFoundVariableRoute()
    {

        Route::get(['set' => '/task/{category}/edit/{id}/clone/{source}', 'as' => 'task.crazy'], 'AppController@index');
        Route::get(['set' => '/user/{user}/profile', 'as' => 'user.profile'], 'AppController@index');
        $actual = Route::translate('user.profile', ['user' => 'luciano']);

        $expected = '://user/luciano/profile';

        return $this->assertEquals($expected, $actual);
    }
}