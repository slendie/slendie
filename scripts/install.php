<?php
/**
 * Script de configuração inicial após composer create-project
 */
define('BASE_PATH', __DIR__ . '/..');

echo "🚀 Configurando projeto Slendie...\n\n";

// 1. Verificar se .env existe
if (!file_exists(BASE_PATH . '/.env')) {
    if (file_exists(BASE_PATH . '/.env.example')) {
        copy(BASE_PATH . '/.env.example', BASE_PATH . '/.env');
        echo "✅ Arquivo .env criado a partir de .env.example\n";
    } else {
        echo "⚠️  Arquivo .env.example não encontrado\n";
    }
} else {
    echo "ℹ️  Arquivo .env já existe\n";
}

// 2. Gerar APP_KEY se necessário
require_once BASE_PATH . '/vendor/autoload.php';

\Slendie\Framework\Env::load(BASE_PATH . '/.env');
$appKey = \Slendie\Framework\Env::get('APP_KEY');

if (empty($appKey)) {
    $newKey = bin2hex(random_bytes(32));
    $envContent = file_get_contents(BASE_PATH . '/.env');
    $envContent = preg_replace('/^APP_KEY=.*$/m', "APP_KEY={$newKey}", $envContent);
    file_put_contents(BASE_PATH . '/.env', $envContent);
    echo "✅ APP_KEY gerada automaticamente\n";
} else {
    echo "ℹ️  APP_KEY já configurada\n";
}

// 3. Criar diretório de banco de dados SQLite se necessário
$dbPath = BASE_PATH . '/database.sqlite';
if (!file_exists($dbPath)) {
    touch($dbPath);
    echo "✅ Arquivo database.sqlite criado\n";
}

echo "\n✨ Configuração concluída!\n";
echo "📝 Não esqueça de:\n";
echo "   1. Configurar as variáveis de ambiente no arquivo .env\n";
echo "   2. Executar: php scripts/migrate.php\n";
echo "   3. Instalar dependências: npm install\n";
