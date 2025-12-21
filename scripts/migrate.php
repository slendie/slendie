<?php
/**
 * Script de migração melhorado com feedback visual e opções CLI
 */

define('BASE_PATH', __DIR__ . '/..');

require_once BASE_PATH . '/vendor/autoload.php';

// Registra o autoloader customizado
\Slendie\Framework\Autoloader::register(BASE_PATH);

// Define função global env() se não existir
if (!function_exists('env')) {
    function env($key, $default = null) { 
        return \Slendie\Framework\Env::get($key, $default);
    }
}

// Carrega .env antes do bootstrap
$envPath = BASE_PATH . '/.env';
if (!file_exists($envPath)) {
    $envPath = BASE_PATH . '/.env.example';
}
\Slendie\Framework\Env::load($envPath);

$app = new \App\App();
$app->bootstrap();

use Slendie\Framework\Migrator;

// Cores para terminal (Windows e Unix)
$colors = [
    'reset' => "\033[0m",
    'green' => "\033[32m",
    'red' => "\033[31m",
    'yellow' => "\033[33m",
    'blue' => "\033[34m",
    'cyan' => "\033[36m",
    'bold' => "\033[1m",
];

// Detecta se está em Windows sem suporte a cores
$isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
if ($isWindows && !function_exists('sapi_windows_vt100_support')) {
    // Desabilita cores no Windows antigo
    $colors = array_fill_keys(array_keys($colors), '');
}

function color($text, $color, $colors) {
    return $colors[$color] . $text . $colors['reset'];
}

function printHeader($colors) {
    echo color("╔════════════════════════════════════════╗\n", 'cyan', $colors);
    echo color("║     Slendie Migration Manager          ║\n", 'cyan', $colors);
    echo color("╚════════════════════════════════════════╝\n", 'cyan', $colors);
    echo "\n";
}

function printSuccess($message, $colors) {
    echo color("✓ ", 'green', $colors) . $message . "\n";
}

function printError($message, $colors) {
    echo color("✗ ", 'red', $colors) . $message . "\n";
}

function printInfo($message, $colors) {
    echo color("ℹ ", 'blue', $colors) . $message . "\n";
}

function printWarning($message, $colors) {
    echo color("⚠ ", 'yellow', $colors) . $message . "\n";
}

// Processa argumentos da linha de comando
$command = $argv[1] ?? 'run';
$options = array_slice($argv, 2);

try {
    $migrator = new Migrator();

    switch ($command) {
        case 'run':
        case 'migrate':
            printHeader($colors);
            printInfo("Executando migrações pendentes...\n", $colors);
            
            $result = $migrator->run();
            
            if ($result['success']) {
                if ($result['executed'] > 0) {
                    printSuccess("Migrações executadas com sucesso!", $colors);
                    echo color("  Total executado: {$result['executed']}\n", 'green', $colors);
                } else {
                    printInfo($result['message'], $colors);
                }
            } else {
                printError("Erro ao executar migrações:", $colors);
                foreach ($result['errors'] as $error) {
                    echo color("  - {$error['migration']}: {$error['error']}\n", 'red', $colors);
                }
                exit(1);
            }
            break;

        case 'status':
            printHeader($colors);
            printInfo("Status das migrações:\n", $colors);
            
            $status = $migrator->status();
            
            echo "\n";
            echo color("Total: {$status['total']} | ", 'cyan', $colors);
            echo color("Executadas: {$status['executed']} | ", 'green', $colors);
            echo color("Pendentes: {$status['pending']}\n", 'yellow', $colors);
            echo "\n";
            
            foreach ($status['migrations'] as $migration) {
                $statusIcon = $migration['executed'] 
                    ? color('✓', 'green', $colors) 
                    : color('○', 'yellow', $colors);
                $statusText = $migration['executed'] ? 'Executada' : 'Pendente';
                echo "  {$statusIcon} {$migration['migration']} - {$statusText}\n";
            }
            break;

        case 'rollback':
            printHeader($colors);
            $steps = isset($options[0]) ? (int)$options[0] : 1;
            
            printWarning("Atenção: Rollback removerá os registros das migrações do último batch.\n", $colors);
            printInfo("Fazendo rollback de {$steps} batch(es)...\n", $colors);
            
            $result = $migrator->rollback($steps);
            
            if ($result['success']) {
                if ($result['rolled_back'] > 0) {
                    printSuccess("Rollback executado com sucesso!", $colors);
                    echo color("  Registros removidos: {$result['rolled_back']}\n", 'green', $colors);
                } else {
                    printInfo($result['message'], $colors);
                }
            }
            break;

        case 'reset':
            printHeader($colors);
            printError("ATENÇÃO: Isso removerá TODOS os registros de migrações!\n", $colors);
            printWarning("As tabelas criadas NÃO serão removidas, apenas os registros.\n", $colors);
            
            echo "\n";
            echo "Digite 'yes' para confirmar: ";
            $handle = fopen("php://stdin", "r");
            $line = trim(fgets($handle));
            fclose($handle);
            
            if (strtolower($line) !== 'yes') {
                printInfo("Operação cancelada.\n", $colors);
                exit(0);
            }
            
            $result = $migrator->reset();
            
            if ($result['success']) {
                printSuccess("Reset executado com sucesso!", $colors);
                echo color("  Registros removidos: {$result['deleted']}\n", 'green', $colors);
            }
            break;

        case 'help':
        case '--help':
        case '-h':
            printHeader($colors);
            echo "Comandos disponíveis:\n\n";
            echo color("  migrate [run]     ", 'cyan', $colors) . "Executa todas as migrações pendentes\n";
            echo color("  migrate status    ", 'cyan', $colors) . "Mostra o status de todas as migrações\n";
            echo color("  migrate rollback  ", 'cyan', $colors) . "Faz rollback do último batch\n";
            echo color("  migrate reset     ", 'cyan', $colors) . "Remove todos os registros de migrações\n";
            echo color("  migrate help      ", 'cyan', $colors) . "Mostra esta ajuda\n";
            echo "\n";
            echo "Exemplos:\n";
            echo "  php scripts/migrate.php\n";
            echo "  php scripts/migrate.php status\n";
            echo "  php scripts/migrate.php rollback\n";
            break;

        default:
            printError("Comando desconhecido: {$command}\n", $colors);
            echo "Use 'php scripts/migrate.php help' para ver os comandos disponíveis.\n";
            exit(1);
    }

} catch (\Exception $e) {
    printError("Erro: " . $e->getMessage(), $colors);
    echo "\n";
    echo color("Stack trace:\n", 'red', $colors);
    echo $e->getTraceAsString() . "\n";
    exit(1);
}

echo "\n";
