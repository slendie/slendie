# Slendie

Starter kit para pequenos projetos em PHP.

## Instalação

composer create-project slendie/slendie meu-projeto
cd meu-projeto## Configuração

1. Copie o arquivo `.env.example` para `.env`:
cp .env.example .env2. Configure as variáveis de ambiente no arquivo `.env`

3. Execute as migrações:
```sh
php scripts/migrate.php4. Instale as dependências do frontend:
npm install
npm run dev## Estrutura do Projeto
```

- `app/` - Controllers, Models, Migrations
- `config/` - Arquivos de configuração
- `public/` - Ponto de entrada da aplicação
- `src/` - Classes core do framework
- `views/` - Templates Blade
- `tests/` - Testes automatizados

## Desenvolvimento

# Executar testes
composer test

# Build de assets
npm run build

# Servidor de desenvolvimento
php -S localhost:8000 -t public

## Licença

MIT