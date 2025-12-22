<?php

declare(strict_types=1);
define('PHPUNIT_TEST', true);

// Define BASE_PATH se não estiver definido
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require_once __DIR__ . '/../vendor/autoload.php';

use Slendie\Controllers\Controller;
use Slendie\Controllers\Middlewares\WebMiddleware;
use Slendie\Framework\Autoloader;
use Slendie\Framework\Database;
use Slendie\Framework\Env;
use Slendie\Framework\Request;

// Registra o autoloader customizado
Autoloader::register();

Env::set('APP_NAME', 'Test App');
Env::set('DB_CONNECTION', 'sqlite');
Env::set('DB_DATABASE', ':memory:');
Env::set('TIMEZONE', 'UTC');

date_default_timezone_set('UTC');

// Função auxiliar para limpar sessão
function clearSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    unset($_SESSION['user_id']);
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_success']);
    unset($_SESSION['old_input']);
}

// Função auxiliar para configurar Request no WebMiddleware
function setupRequest($method = 'GET', $uri = '/', $post = [], $get = [])
{
    // Salva valores originais
    $originalServer = $_SERVER;
    $originalGet = $_GET;
    $originalPost = $_POST;

    // Limpa
    $_SERVER = [];
    $_GET = [];
    $_POST = [];

    // Configura método e URI
    $_SERVER['REQUEST_METHOD'] = $method;
    $_SERVER['REQUEST_URI'] = $uri;
    $_GET = $get;
    $_POST = $post;

    $request = new Request();

    // Injeta no WebMiddleware
    $webMiddleware = new WebMiddleware();
    $webMiddleware->handle($request);

    return ['request' => $request, 'original' => ['server' => $originalServer, 'get' => $originalGet, 'post' => $originalPost]];
}

// Função auxiliar para restaurar ambiente
function restoreEnvironment($original)
{
    $_SERVER = $original['server'];
    $_GET = $original['get'];
    $_POST = $original['post'];
}

// Função auxiliar para resetar conexão do Database
function resetDatabaseConnection()
{
    $reflection = new ReflectionClass(Database::class);
    $property = $reflection->getProperty('pdo');
    $property->setAccessible(true);
    $property->setValue(null, null);
}

// Função auxiliar para configurar ambiente de teste
function setupTestEnv()
{
    // Configura variáveis de ambiente para SQLite em memória
    Env::set('DB_CONNECTION', 'sqlite');
    Env::set('DB_DATABASE', ':memory:');
    Env::set('DB_HOST', null);
    Env::set('DB_PORT', null);
    Env::set('DB_USER', null);
    Env::set('DB_PASSWORD', null);

    // Reseta conexão do Database
    resetDatabaseConnection();
}

// Função auxiliar para criar tabelas de teste
function createTestTables()
{
    $pdo = Database::getConnection();

    // Cria tabela de usuários
    $pdo->exec('CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        role_id INTEGER
    )');

    // Cria tabela de roles
    $pdo->exec('CREATE TABLE IF NOT EXISTS roles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL
    )');

    // Cria tabela de permissions
    $pdo->exec('CREATE TABLE IF NOT EXISTS permissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE
    )');

    // Cria tabela de role_permissions
    $pdo->exec('CREATE TABLE IF NOT EXISTS role_permissions (
        role_id INTEGER NOT NULL,
        permission_id INTEGER NOT NULL
    )');
}

// Função auxiliar para limpar tabelas
function clearTestTables()
{
    $pdo = Database::getConnection();
    $pdo->exec('DELETE FROM role_permissions');
    $pdo->exec('DELETE FROM users');
    $pdo->exec('DELETE FROM roles');
    $pdo->exec('DELETE FROM permissions');
}

// Função auxiliar para capturar output e código HTTP
function captureOutputAndCode($callback)
{
    ob_start();
    $code = null;

    // Captura código HTTP usando output buffering
    $result = $callback();

    $output = ob_get_clean();

    // Tenta obter o código HTTP (pode não estar disponível em todos os ambientes)
    if (function_exists('http_response_code')) {
        $code = http_response_code();
    }

    return ['result' => $result, 'output' => $output, 'code' => $code];
}

// Função auxiliar para remover diretório recursivamente
function removeDirectory($dir)
{
    if (!is_dir($dir)) {
        return;
    }
    try {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                removeDirectory($path);
            } else {
                @unlink($path);
            }
        }
        @rmdir($dir);
    } catch (Exception $e) {
        // Ignora erros de limpeza
    }
}

// Função auxiliar para simular requisição HTTP
function simulateRequest($method = 'GET', $uri = '/', $get = [], $post = [], $files = [], $headers = [], $jsonBody = null)
{
    // Salva valores originais
    $originalServer = $_SERVER;
    $originalGet = $_GET;
    $originalPost = $_POST;
    $originalFiles = $_FILES;

    // Limpa
    $_SERVER = [];
    $_GET = [];
    $_POST = [];
    $_FILES = [];

    // Configura método e URI
    $_SERVER['REQUEST_METHOD'] = $method;
    $_SERVER['REQUEST_URI'] = $uri;

    // Configura GET
    $_GET = $get;

    // Configura POST
    $_POST = $post;

    // Configura FILES
    $_FILES = $files;

    // Configura headers
    foreach ($headers as $key => $value) {
        $headerKey = 'HTTP_' . mb_strtoupper(str_replace('-', '_', $key));
        $_SERVER[$headerKey] = $value;
    }

    // Configura JSON body se fornecido
    if ($jsonBody !== null) {
        // Simula php://input usando um arquivo temporário
        $tempFile = sys_get_temp_dir() . '/php_input_' . uniqid() . '.tmp';
        file_put_contents($tempFile, is_string($jsonBody) ? $jsonBody : json_encode($jsonBody));

        // Substitui file_get_contents('php://input') temporariamente
        // Nota: Não podemos realmente substituir php://input, então vamos usar reflection
        // ou criar um mock. Por enquanto, vamos testar sem JSON body primeiro.
    }

    $request = new Request();

    // Restaura valores originais
    $_SERVER = $originalServer;
    $_GET = $originalGet;
    $_POST = $originalPost;
    $_FILES = $originalFiles;

    return $request;
}

// Função auxiliar para simular JSON body (mais complexo, vamos testar separadamente)
function simulateRequestWithJson($method = 'POST', $uri = '/', $jsonBody, $get = [], $post = [], $files = [], $headers = [])
{
    // Salva valores originais
    $originalServer = $_SERVER;
    $originalGet = $_GET;
    $originalPost = $_POST;
    $originalFiles = $_FILES;

    // Limpa
    $_SERVER = [];
    $_GET = [];
    $_POST = [];
    $_FILES = [];

    // Configura método e URI
    $_SERVER['REQUEST_METHOD'] = $method;
    $_SERVER['REQUEST_URI'] = $uri;

    // Configura GET
    $_GET = $get;

    // Configura POST
    $_POST = $post;

    // Configura FILES
    $_FILES = $files;

    // Configura headers
    foreach ($headers as $key => $value) {
        $headerKey = 'HTTP_' . mb_strtoupper(str_replace('-', '_', $key));
        $_SERVER[$headerKey] = $value;
    }

    // Para JSON, precisamos simular php://input
    // Vamos criar um stream wrapper temporário ou usar reflection
    // Por enquanto, vamos apenas testar que o método json() existe

    $request = new Request();

    // Restaura valores originais
    $_SERVER = $originalServer;
    $_GET = $originalGet;
    $_POST = $originalPost;
    $_FILES = $originalFiles;

    return $request;
}

// Classe de controller de teste que expõe métodos protegidos
final class TestController extends Controller
{
    public static $calledMethod = null;
    public static $calledArgs = [];
    public static $output = '';

    public static function reset()
    {
        self::$calledMethod = null;
        self::$calledArgs = [];
        self::$output = '';
    }

    public function getRequest()
    {
        return $this->request();
    }

    public function testRedirect($url)
    {
        return $this->redirect($url);
    }

    public function testRender($view, $data = [])
    {
        return $this->render($view, $data);
    }

    public function getFormErrors()
    {
        return $this->formErrors;
    }

    public function getFormSuccess()
    {
        return $this->formSuccess;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getOldInput()
    {
        return $this->oldInput;
    }

    public function index()
    {
        self::$calledMethod = 'index';
        self::$calledArgs = func_get_args();
        return 'index output';
    }

    public function show($id)
    {
        self::$calledMethod = 'show';
        self::$calledArgs = func_get_args();
        return 'show output: ' . $id;
    }

    public function edit($id, $action)
    {
        self::$calledMethod = 'edit';
        self::$calledArgs = func_get_args();
        return 'edit output: ' . $id . ' ' . $action;
    }

    public function create()
    {
        self::$calledMethod = 'create';
        self::$calledArgs = func_get_args();
        return 'create output';
    }

    public function store()
    {
        self::$calledMethod = 'store';
        self::$calledArgs = func_get_args();
        return 'store output';
    }
}
