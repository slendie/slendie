<?php

namespace Slendie\Framework;

use function env;

class Migrator
{
    private $migrationsDir;
    private $driver;
    private $pdo;

    public function __construct($migrationsDir = null)
    {
        $this->migrationsDir = $migrationsDir ?? BASE_PATH . '/app/migrations';
        $this->driver = env('DB_CONNECTION', 'sqlite');
        $this->pdo = Database::getConnection();
        $this->ensureMigrationsTable();
    }

    /**
     * Garante que a tabela de migrações existe
     */
    private function ensureMigrationsTable()
    {
        if (!Database::checkIfTableExists($this->driver, 'migrations')) {
            $migrations = [
                'sqlite' => [
                    "CREATE TABLE IF NOT EXISTS migrations (
                        migration VARCHAR(255) NOT NULL PRIMARY KEY,
                        batch INTEGER NOT NULL,
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                    );",
                ],
                'mysql' => [
                    "CREATE TABLE IF NOT EXISTS migrations (
                        migration VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL PRIMARY KEY,
                        batch INTEGER NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                ],
                'pgsql' => [
                    "CREATE TABLE IF NOT EXISTS migrations (
                        migration VARCHAR(255) NOT NULL PRIMARY KEY,
                        batch INTEGER NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    );",
                ],
            ];
            Database::execute($migrations[$this->driver]);
        }
    }

    /**
     * Obtém todas as migrações disponíveis
     */
    public function getAvailableMigrations()
    {
        $files = [];
        if (is_dir($this->migrationsDir)) {
            $files = glob($this->migrationsDir . '/*.php') ?: [];
            sort($files, SORT_STRING);
        }
        return array_map('basename', $files);
    }

    /**
     * Obtém todas as migrações já executadas
     */
    public function getExecutedMigrations()
    {
        $stmt = $this->pdo->query("SELECT migration FROM migrations ORDER BY batch ASC, migration ASC");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Obtém o próximo número de batch
     */
    private function getNextBatch()
    {
        $stmt = $this->pdo->query("SELECT MAX(batch) as max_batch FROM migrations");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return ($result['max_batch'] ?? 0) + 1;
    }

    /**
     * Executa todas as migrações pendentes
     */
    public function run()
    {
        $available = $this->getAvailableMigrations();
        $executed = $this->getExecutedMigrations();
        $pending = array_diff($available, $executed);

        if (empty($pending)) {
            return [
                'success' => true,
                'message' => 'Nenhuma migração pendente.',
                'executed' => 0
            ];
        }

        $batch = $this->getNextBatch();
        $executedCount = 0;
        $errors = [];

        foreach ($pending as $migrationName) {
            try {
                $this->runMigration($migrationName, $batch);
                $executedCount++;
            } catch (\Exception $e) {
                $errors[] = [
                    'migration' => $migrationName,
                    'error' => $e->getMessage()
                ];
                // Em caso de erro, interrompe a execução
                break;
            }
        }

        return [
            'success' => empty($errors),
            'executed' => $executedCount,
            'total' => count($pending),
            'errors' => $errors
        ];
    }

    /**
     * Executa uma migração específica
     */
    private function runMigration($migrationName, $batch)
    {
        $file = $this->migrationsDir . '/' . $migrationName;
        
        if (!file_exists($file)) {
            throw new \RuntimeException("Arquivo de migração não encontrado: {$migrationName}");
        }

        $result = include $file;
        
        if (!is_array($result) || !isset($result[$this->driver])) {
            throw new \RuntimeException("Migração {$migrationName} não possui suporte para o driver {$this->driver}");
        }

        $statements = $result[$this->driver];
        $queries = is_array($statements) ? $statements : [$statements];

        // Remove queries vazias
        $queries = array_filter(array_map('trim', $queries), function($q) {
            return !empty($q);
        });

        if (empty($queries)) {
            throw new \RuntimeException("Migração {$migrationName} não possui queries válidas");
        }

        // Executa em transação
        $this->pdo->beginTransaction();
        try {
            foreach ($queries as $query) {
                $this->pdo->exec($query);
            }

            // Registra a migração
            $stmt = $this->pdo->prepare(
                "INSERT INTO migrations (migration, batch, created_at) VALUES (?, ?, ?)"
            );
            $stmt->execute([$migrationName, $batch, date('Y-m-d H:i:s')]);

            $this->pdo->commit();
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Obtém o status das migrações
     */
    public function status()
    {
        $available = $this->getAvailableMigrations();
        $executed = $this->getExecutedMigrations();
        
        $status = [];
        foreach ($available as $migration) {
            $status[] = [
                'migration' => $migration,
                'executed' => in_array($migration, $executed)
            ];
        }

        return [
            'total' => count($available),
            'executed' => count($executed),
            'pending' => count($available) - count($executed),
            'migrations' => $status
        ];
    }

    /**
     * Faz rollback do último batch de migrações
     */
    public function rollback($steps = 1)
    {
        // Nota: Para rollback completo, seria necessário criar arquivos de rollback
        // Por enquanto, apenas remove os registros da tabela migrations
        $stmt = $this->pdo->query("SELECT MAX(batch) as max_batch FROM migrations");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $maxBatch = $result['max_batch'] ?? 0;

        if ($maxBatch === 0) {
            return [
                'success' => true,
                'message' => 'Nenhuma migração para fazer rollback.',
                'rolled_back' => 0
            ];
        }

        $targetBatch = max(1, $maxBatch - $steps + 1);
        
        $stmt = $this->pdo->prepare("DELETE FROM migrations WHERE batch >= ?");
        $stmt->execute([$targetBatch]);
        $rolledBack = $stmt->rowCount();

        return [
            'success' => true,
            'rolled_back' => $rolledBack,
            'batch' => $targetBatch
        ];
    }

    /**
     * Faz rollback de todas as migrações
     */
    public function reset()
    {
        $stmt = $this->pdo->query("DELETE FROM migrations");
        $deleted = $stmt->rowCount();

        return [
            'success' => true,
            'deleted' => $deleted
        ];
    }
}

