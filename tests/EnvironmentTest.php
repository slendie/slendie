<?php
namespace App;

use Slendie\Framework\Environment\Environment;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
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
    public function testIfCanReturnSection()
    {
        // O valor que eu quero testar
        $response = Environment::getSection('view');
        
        // $response = Environment::getSection('view');

        $expected = [
            'path'      => 'resources.views',
            'extension' => 'tpl.php'
        ];

        /**
         * O método assertEquals é provido pela classe TestCase
         * que a RouterTest (esta que estamos) está herdando
         * ele verifica se o valor esperado (expected) é igual
         * ao valor atual (actual);
         */
        $this->assertEquals($expected, $response);
    }

    /*
     * @return void
     */
    public function testIfCanGetAKeyValue()
    {
        $response = Environment::getKey('view', 'path');

        $expected = 'resources.views';

        $this->assertEquals($expected, $response);
    }

    /*
     * @return void
     */
    public function testIfCanGetAValue()
    {
        $response = Environment::get('path');

        $expected = 'resources.views';

        $this->assertEquals($expected, $response);
    }

    /*
     * @return void
     */
    public function testIfCanGetAProperty()
    {
        $env = Environment::getInstance();
        
        $response = $env->path;

        $expected = 'resources.views';

        $this->assertEquals($expected, $response);
    }

    // https://blog.erikfigueiredo.com.br/serie-php-sem-frameworks/
}