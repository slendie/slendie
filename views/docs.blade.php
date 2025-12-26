@extends('layouts.front')

@section('content')
    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">S</div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">Slendie</span>
                </a>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="/#features" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Recursos</a>
                <a href="/#code" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Código</a>
                <a href="https://github.com/slendie/slendie" target="_blank" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">GitHub</a>
            </div>
            <div>
                <a href="/docs" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-all bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm hover:shadow-md">
                    Documentação
                </a>
            </div>
        </div>
    </nav>

    <div class="pt-24 pb-16 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-12 gap-10">
                <!-- Sidebar Navigation -->
                <div class="md:col-span-3 lg:col-span-2">
                    <div class="sticky top-28 space-y-8">
                        <div>
                            <h5 class="font-semibold text-slate-900 mb-3">Começando</h5>
                            <ul class="space-y-2 text-sm text-slate-600">
                                <li><a href="#instalacao" class="hover:text-indigo-600 block py-1">Instalação</a></li>
                                <li><a href="#arquitetura" class="hover:text-indigo-600 block py-1">Arquitetura MVC</a></li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-semibold text-slate-900 mb-3">Conceitos</h5>
                            <ul class="space-y-2 text-sm text-slate-600">
                                <li><a href="#rotas" class="hover:text-indigo-600 block py-1">Rotas & Controllers</a></li>
                                <li><a href="#views" class="hover:text-indigo-600 block py-1">Views & Blade</a></li>
                                <li><a href="#models" class="hover:text-indigo-600 block py-1">Models & Banco</a></li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-semibold text-slate-900 mb-3">Informações</h5>
                            <ul class="space-y-2 text-sm text-slate-600">
                                <li><a href="#changelog" class="hover:text-indigo-600 block py-1">Changelog</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="md:col-span-9 lg:col-span-10">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 md:p-12">
                        <h1 class="text-4xl font-bold text-slate-900 mb-6">Documentação</h1>
                        <p class="text-lg text-slate-600 mb-10 leading-relaxed">
                            Bem-vindo à documentação oficial do Slendie. Aqui você aprenderá como instalar, configurar e desenvolver aplicações modernas com nosso framework.
                        </p>

                        <hr class="my-10 border-slate-100">

                        <!-- Instalação -->
                        <section id="instalacao" class="scroll-mt-28">
                            <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <span class="text-indigo-600">#</span> Instalação
                            </h2>
                            <p class="text-slate-600 mb-6">
                                Comece criando um novo projeto via Composer. O Slendie configura automaticamente toda a estrutura necessária.
                            </p>
                            
                            <div class="bg-slate-900 rounded-xl p-6 mb-6 overflow-x-auto shadow-lg">
                                <pre class="text-indigo-100 font-mono text-sm leading-relaxed">composer create-project slendie/slendie meu-projeto
cd meu-projeto</pre>
                            </div>

                            <p class="text-slate-600 mb-4">Em seguida, configure seu ambiente e instale as dependências:</p>

                            <div class="space-y-4">
                                <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                                    <h3 class="font-semibold text-slate-800 mb-2">1. Configuração do Ambiente</h3>
                                    <code class="block bg-white border border-slate-200 rounded px-3 py-2 text-sm text-slate-600 font-mono">cp .env.example .env</code>
                                </div>
                                <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                                    <h3 class="font-semibold text-slate-800 mb-2">2. Migrações de Banco de Dados</h3>
                                    <code class="block bg-white border border-slate-200 rounded px-3 py-2 text-sm text-slate-600 font-mono">php scripts/migrate.php</code>
                                </div>
                                <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                                    <h3 class="font-semibold text-slate-800 mb-2">3. Frontend Assets</h3>
                                    <code class="block bg-white border border-slate-200 rounded px-3 py-2 text-sm text-slate-600 font-mono">npm install && npm run dev</code>
                                </div>
                            </div>
                        </section>

                        <hr class="my-10 border-slate-100">

                        <!-- Arquitetura MVC -->
                        <section id="arquitetura" class="scroll-mt-28">
                            <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <span class="text-indigo-600">#</span> Arquitetura MVC
                            </h2>
                            <p class="text-slate-600 mb-6">
                                O Slendie segue o padrão de arquitetura <strong>Model-View-Controller (MVC)</strong>, separando a lógica da aplicação em três camadas interconectadas.
                            </p>

                            <div class="grid md:grid-cols-3 gap-6 mb-8">
                                <div class="p-6 rounded-xl bg-indigo-50 border border-indigo-100">
                                    <div class="font-bold text-indigo-700 mb-2">Model</div>
                                    <p class="text-sm text-indigo-900/70">Gerencia os dados e regras de negócio. Interage diretamente com o banco de dados.</p>
                                </div>
                                <div class="p-6 rounded-xl bg-indigo-50 border border-indigo-100">
                                    <div class="font-bold text-indigo-700 mb-2">View</div>
                                    <p class="text-sm text-indigo-900/70">A camada de apresentação. É o que o usuário vê (HTML renderizado pelo Blade).</p>
                                </div>
                                <div class="p-6 rounded-xl bg-indigo-50 border border-indigo-100">
                                    <div class="font-bold text-indigo-700 mb-2">Controller</div>
                                    <p class="text-sm text-indigo-900/70">Recebe as requisições, processa dados usando Models e retorna Views.</p>
                                </div>
                            </div>
                        </section>

                        <hr class="my-10 border-slate-100">

                        <!-- Rotas & Controllers -->
                        <section id="rotas" class="scroll-mt-28">
                            <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <span class="text-indigo-600">#</span> Rotas & Controllers
                            </h2>
                            <p class="text-slate-600 mb-6">
                                As rotas definem como sua aplicação responde às requisições HTTP, mapeando URLs para métodos em seus Controllers.
                            </p>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Definindo Rotas</h3>
                            <p class="text-slate-600 mb-4">
                                As rotas são configuradas no arquivo <code>config/routes.php</code>. Cada rota é um array contendo método, caminho e handler.
                            </p>
                            <div class="bg-slate-900 rounded-xl p-6 mb-8 overflow-x-auto shadow-lg">
                                <pre class="text-indigo-100 font-mono text-sm leading-relaxed"><code class="language-php">return [
    [
        'method' => 'GET',
        'path' => '/produtos',
        'handler' => 'App\Controllers\ProductController@index',
        'middlewares' => []
    ],
    [
        'method' => 'POST',
        'path' => '/produtos',
        'handler' => 'App\Controllers\ProductController@store',
        'middlewares' => ['auth']
    ]
];</code></pre>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Controllers</h3>
                            <p class="text-slate-600 mb-4">
                                Os controllers agrupam a lógica de requisição relacionada. Eles devem estender a classe base <code>Slendie\Controllers\Controller</code>.
                            </p>
                            
                            <div class="bg-slate-900 rounded-xl p-6 mb-8 overflow-x-auto shadow-lg">
                                <pre class="text-indigo-100 font-mono text-sm leading-relaxed"><code class="language-php">namespace App\Controllers;

use Slendie\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        // Acessa dados da requisição
        $params = $this->request()->getParams();
        
        // Renderiza uma view
        return $this->render('products.index', [
            'products' => ['Notebook', 'Mouse']
        ]);
    }

    public function store()
    {
        // Redireciona para outra URL
        return $this->redirect('/produtos');
    }
}</code></pre>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Funcionalidades Base</h3>
                            <div class="grid gap-4 mb-8">
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <code class="text-indigo-600 font-mono text-sm font-bold">$this->render($view, $data)</code>
                                    <p class="text-sm text-slate-600 mt-1">Renderiza uma view Blade. Injeta automaticamente erros de formulário e mensagens de sucesso.</p>
                                </div>
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <code class="text-indigo-600 font-mono text-sm font-bold">$this->redirect($url)</code>
                                    <p class="text-sm text-slate-600 mt-1">Realiza um redirecionamento HTTP.</p>
                                </div>
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <code class="text-indigo-600 font-mono text-sm font-bold">$this->request()</code>
                                    <p class="text-sm text-slate-600 mt-1">Retorna a instância da requisição atual para acesso a parâmetros e inputs.</p>
                                </div>
                            </div>
                        </section>

                        <hr class="my-10 border-slate-100">

                        <!-- Views -->
                        <section id="views" class="scroll-mt-28">
                            <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <span class="text-indigo-600">#</span> Views & Blade
                            </h2>
                            <p class="text-slate-600 mb-6">
                                O Slendie possui um motor de template próprio, inspirado no Blade do Laravel, mas leve e eficiente. As views ficam em <code>views/</code> e devem ter a extensão <code>.blade.php</code>.
                            </p>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Renderizando Views</h3>
                            <div class="bg-slate-900 rounded-xl p-6 mb-8 overflow-x-auto shadow-lg">
                                <pre class="text-indigo-100 font-mono text-sm leading-relaxed"><code class="language-php">use Slendie\Framework\Blade;

public function index() {
    $blade = new Blade();
    // Renderiza views/home.blade.php passando dados
    echo $blade->render('home', ['title' => 'Bem-vindo']);
}</code></pre>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Sintaxe de Exibição</h3>
                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <div class="font-mono text-indigo-600 font-bold mb-2"><script>document.write('{'+ '{ $variavel }' + '}');</script></div>
                                    <p class="text-sm text-slate-600">Imprime o valor <strong>sem escapar</strong> (raw output). Use para HTML confiável.</p>
                                </div>
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <div class="font-mono text-indigo-600 font-bold mb-2"><script>document.write('{'+ '!! $variavel !!' + '}');</script></div>
                                    <p class="text-sm text-slate-600">Imprime o valor <strong>escapado</strong> (safe output). Converte caracteres especiais em entidades HTML.</p>
                                </div>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Estruturas de Controle</h3>
                            <p class="text-slate-600 mb-4">Suporte completo para condicionais e loops:</p>
                            <div class="bg-slate-900 rounded-xl p-6 mb-8 overflow-x-auto shadow-lg">
                                <pre class="text-indigo-100 font-mono text-sm leading-relaxed"><code class="language-html"><script>document.write('@' + 'if(count($users) > 0)');</script>
<script>document.write('    @' + 'foreach($users as $user)');</script>
        &lt;div&gt;<script>document.write('{'+ '{ $user[\'name\'] }' + '}');</script>&lt;/div&gt;
    @endforeach
@else
    &lt;p&gt;Nenhum usuário encontrado.&lt;/p&gt;
@endif</code></pre>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Layouts e Herança</h3>
                            <p class="text-slate-600 mb-4">Crie layouts reutilizáveis com <code>@extends</code>, <code>@section</code> e <code>@yield</code>.</p>
                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">views/layouts/app.blade.php</div>
                                    <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto shadow-md h-full">
<pre class="text-indigo-100 font-mono text-xs leading-relaxed">
&lt;html&gt;
    &lt;head&gt;
<script>document.write('        @'+"asset('css/app.css')"+')');</script>
    &lt;/head&gt;
    &lt;body&gt;
<script>document.write('        @'+"yield('content')")</script>
    &lt;/body&gt;
&lt;/html&gt;
</pre>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">views/home.blade.php</div>
                                    <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto shadow-md h-full">
<pre class="text-indigo-100 font-mono text-xs leading-relaxed">
<script>document.write('@'+"extends('layouts.app')"+')');</script>

<script>document.write('@'+"section('content')"+')');</script>
    &lt;h1&gt;Página Inicial&lt;/h1&gt;
<script>document.write('@'+"endsection"+')');</script>
</pre>
                                    </div>
                                </div>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Diretivas Úteis</h3>
                            <ul class="space-y-4 mb-8">
                                <li class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                                    <code class="text-indigo-600 font-bold"><script>document.write('@'+"include('partials.header')"+')');</script></code>
                                    <p class="text-sm text-slate-600 mt-1">Inclui outra view. Suporta notação com ponto.</p>
                                </li>
                                <li class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                                    <code class="text-indigo-600 font-bold"><script>document.write('@'+"asset('js/app.js')"+')');</script></code>
                                    <p class="text-sm text-slate-600 mt-1">Integração com Vite. Gera tags de script e link CSS.</p>
                                </li>
                                <li class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                                    <code class="text-indigo-600 font-bold"><script>document.write('@'+"csrf"+')');</script></code>
                                    <p class="text-sm text-slate-600 mt-1">Gera um campo input hidden com o token CSRF para formulários.</p>
                                </li>
                                <li class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                                    <code class="text-indigo-600 font-bold"><script>document.write('@'+"error('email')"+')');</script> ... <script>document.write('@'+"enderror"+')');</script></code>
                                    <p class="text-sm text-slate-600 mt-1">Verifica erros de validação. Disponibiliza a variável <code>$message</code>.</p>
                                </li>
                            </ul>
                        </section>

                        <hr class="my-10 border-slate-100">

                        <!-- Models -->
                        <section id="models" class="scroll-mt-28">
                            <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <span class="text-indigo-600">#</span> Models e Banco de Dados
                            </h2>
                            <p class="text-slate-600 mb-6">
                                Os Models representam tabelas no seu banco de dados e facilitam a manipulação de registros. Eles devem estender a classe base <code>Slendie\Models\Model</code>.
                            </p>

                            <div class="bg-slate-900 rounded-xl p-6 mb-8 overflow-x-auto shadow-lg">
                                <pre class="text-indigo-100 font-mono text-sm leading-relaxed"><code class="language-php">namespace App\Models;

use Slendie\Models\Model;

class User extends Model
{
    // Define a tabela associada ao model
    protected static string $table = 'users';
}</code></pre>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Operações CRUD</h3>
                            <p class="text-slate-600 mb-4">Métodos estáticos para criar, ler, atualizar e deletar registros:</p>

                            <div class="bg-slate-900 rounded-xl p-6 mb-8 overflow-x-auto shadow-lg">
                                <pre class="text-indigo-100 font-mono text-sm leading-relaxed"><code class="language-php">// Criar
$id = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Ler
$user = User::find(1); // Retorna array ou null
$allUsers = User::all(); // Retorna array de arrays

// Atualizar
User::update(1, ['name' => 'John Updated']);

// Deletar
User::delete(1);</code></pre>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Query Builder</h3>
                            <p class="text-slate-600 mb-4">
                                Para consultas mais complexas, utilize os métodos de construção de query. Eles retornam uma instância fluente que deve ser finalizada com <code>execute()</code> ou <code>first()</code>.
                            </p>

                            <div class="bg-slate-900 rounded-xl p-6 mb-8 overflow-x-auto shadow-lg">
                                <pre class="text-indigo-100 font-mono text-sm leading-relaxed"><code class="language-php">// Filtrar e Ordernar
$users = User::where('active', 1)
             ->orderBy('created_at', 'DESC')
             ->limit(10)
             ->execute(); // Retorna array

// Buscar um único registro com condição
$user = User::where('email', 'john@example.com')->first();

// Condições complexas
$users = User::where('role', 'admin')
             ->orWhere('role', 'editor')
             ->execute();</code></pre>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-3">Métodos Disponíveis</h3>
                            <div class="grid md:grid-cols-2 gap-4 mb-8">
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <code class="text-indigo-600 font-mono text-sm font-bold">where($col, $op, $val)</code>
                                    <p class="text-sm text-slate-600 mt-1">Adiciona cláusula WHERE. O operador é opcional (padrão '=').</p>
                                </div>
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <code class="text-indigo-600 font-mono text-sm font-bold">orWhere($col, $op, $val)</code>
                                    <p class="text-sm text-slate-600 mt-1">Adiciona cláusula OR WHERE.</p>
                                </div>
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <code class="text-indigo-600 font-mono text-sm font-bold">orderBy($col, $dir)</code>
                                    <p class="text-sm text-slate-600 mt-1">Ordena os resultados (ASC ou DESC).</p>
                                </div>
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <code class="text-indigo-600 font-mono text-sm font-bold">limit($int)</code>
                                    <p class="text-sm text-slate-600 mt-1">Limita o número de registros retornados.</p>
                                </div>
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <code class="text-indigo-600 font-mono text-sm font-bold">groupBy($col)</code>
                                    <p class="text-sm text-slate-600 mt-1">Agrupa resultados por uma coluna.</p>
                                </div>
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <code class="text-indigo-600 font-mono text-sm font-bold">execute()</code>
                                    <p class="text-sm text-slate-600 mt-1">Executa a query e retorna todos os resultados.</p>
                                </div>
                                <div class="bg-white border border-slate-200 rounded-lg p-4">
                                    <code class="text-indigo-600 font-mono text-sm font-bold">first()</code>
                                    <p class="text-sm text-slate-600 mt-1">Executa a query e retorna apenas o primeiro resultado.</p>
                                </div>
                            </div>
                        </section>

                        <hr class="my-10 border-slate-100">

                        <!-- Changelog -->
                        <section id="changelog" class="scroll-mt-28">
                            <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <span class="text-indigo-600">#</span> Changelog
                            </h2>
                            <p class="text-slate-600 mb-6">
                                Registro de todas as mudanças, melhorias e correções em cada versão do Slendie.
                            </p>

                            <div class="space-y-8">
                                <!-- Versão 3.0.0 -->
                                <div class="border-l-4 border-indigo-600 pl-6">
                                    <div class="flex items-center gap-3 mb-3">
                                        <h3 class="text-xl font-bold text-slate-900">v3.0.0</h3>
                                        <span class="px-2 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 rounded-full">Atual</span>
                                        <span class="text-sm text-slate-500">2024</span>
                                    </div>
                                    <ul class="space-y-2 text-slate-600">
                                        <li class="flex items-start gap-2">
                                            <span class="text-indigo-600 mt-1">+</span>
                                            <span>Integração completa com Vite para assets frontend</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-indigo-600 mt-1">+</span>
                                            <span>Motor Blade melhorado com novas diretivas</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-indigo-600 mt-1">+</span>
                                            <span>Sistema de rotas baseado em arrays de configuração</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-emerald-600 mt-1">~</span>
                                            <span>Melhorias de performance no sistema de rotas</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-emerald-600 mt-1">~</span>
                                            <span>Otimizações no Query Builder</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Versão 2.0.0 -->
                                <div class="border-l-4 border-slate-300 pl-6">
                                    <div class="flex items-center gap-3 mb-3">
                                        <h3 class="text-xl font-bold text-slate-900">v2.0.0</h3>
                                        <span class="text-sm text-slate-500">2023</span>
                                    </div>
                                    <ul class="space-y-2 text-slate-600">
                                        <li class="flex items-start gap-2">
                                            <span class="text-indigo-600 mt-1">+</span>
                                            <span>Sistema de middleware implementado</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-indigo-600 mt-1">+</span>
                                            <span>Proteção CSRF automática</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-emerald-600 mt-1">~</span>
                                            <span>Refatoração da arquitetura MVC</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Versão 1.0.0 -->
                                <div class="border-l-4 border-slate-300 pl-6">
                                    <div class="flex items-center gap-3 mb-3">
                                        <h3 class="text-xl font-bold text-slate-900">v1.0.0</h3>
                                        <span class="text-sm text-slate-500">2022</span>
                                    </div>
                                    <ul class="space-y-2 text-slate-600">
                                        <li class="flex items-start gap-2">
                                            <span class="text-indigo-600 mt-1">+</span>
                                            <span>Lançamento inicial do framework</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-indigo-600 mt-1">+</span>
                                            <span>Sistema básico de rotas e controllers</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-indigo-600 mt-1">+</span>
                                            <span>Motor Blade básico</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-indigo-600 mt-1">+</span>
                                            <span>ORM simples com Query Builder</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-8 p-4 bg-indigo-50 border border-indigo-100 rounded-lg">
                                <p class="text-sm text-indigo-900">
                                    <strong>Legenda:</strong>
                                    <span class="ml-4"><span class="text-indigo-600">+</span> Nova funcionalidade</span>
                                    <span class="ml-4"><span class="text-emerald-600">~</span> Melhoria</span>
                                    <span class="ml-4"><span class="text-red-600">-</span> Remoção</span>
                                    <span class="ml-4"><span class="text-amber-600">!</span> Correção</span>
                                </p>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <!-- Footer padrão -->
@endsection
