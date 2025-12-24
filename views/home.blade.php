@extends('layouts.front')

@section('content')
    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">S</div>
                <span class="font-bold text-xl tracking-tight text-slate-900">Slendie</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Recursos</a>
                <a href="#code" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Código</a>
                <a href="https://github.com/slendie/slendie" target="_blank" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">GitHub</a>
            </div>
            <div>
                <a href="/docs" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-all bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm hover:shadow-md">
                    Documentação
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
            <div class="absolute left-0 right-0 top-0 -z-10 m-auto h-[310px] w-[310px] rounded-full bg-indigo-500 opacity-20 blur-[100px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold uppercase tracking-wide mb-8">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                v3.0.0 Disponível
            </div>
            
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight text-slate-900 mb-8 max-w-4xl mx-auto leading-tight">
                Desenvolva com <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Elegância</span> e Performance.
            </h1>
            
            <p class="text-lg md:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                Slendie é o micro-framework PHP ideal para quem busca simplicidade sem sacrificar o poder. 
                Zero configuração, Blade template e Vite prontos para usar.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#" class="w-full sm:w-auto px-8 py-3.5 text-base font-semibold text-white transition-all bg-indigo-600 rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Começar Agora
                </a>
                <div class="w-full sm:w-auto relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-violet-500 rounded-xl opacity-30 group-hover:opacity-100 transition duration-200 blur"></div>
                    <div class="relative flex items-center bg-white rounded-xl leading-none">
                        <code class="flex-1 px-4 py-3.5 font-mono text-sm text-slate-700 select-all">composer create-project slendie/slendie</code>
                        <button class="px-3 py-3.5 text-slate-400 hover:text-indigo-600 transition-colors border-l border-slate-100" title="Copiar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Tudo o que você precisa</h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Uma fundação sólida para seus projetos, com as melhores ferramentas do ecossistema PHP moderno.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-100 hover:bg-indigo-50/30 transition-all duration-300">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-indigo-600 mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Blade Template</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Escreva templates limpos e expressivos com herança de layout, componentes e diretivas personalizadas.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-100 hover:bg-indigo-50/30 transition-all duration-300">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-violet-600 mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/><line x1="3.27" y1="6.96" x2="12" y2="12.01"/><line x1="20.73" y1="6.96" x2="12" y2="12.01"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Vite Integration</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Hot Module Replacement (HMR) instantâneo para Vue, React ou apenas CSS/JS puro com Tailwind.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-100 hover:bg-indigo-50/30 transition-all duration-300">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Seguro por Padrão</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Proteção CSRF automática, escaping de output e headers de segurança configurados desde o início.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Code Showcase -->
    <section id="code" class="py-24 bg-slate-900 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Simplicidade no Core</h2>
                    <p class="text-slate-400 text-lg mb-8 leading-relaxed">
                        Esqueça configurações complexas. Slendie foca no que importa: seu código.
                        Roteamento intuitivo, Controllers limpos e uma estrutura que faz sentido.
                    </p>
                    
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center gap-3 text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Estrutura MVC familiar
                        </li>
                        <li class="flex items-center gap-3 text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Injeção de dependência automática
                        </li>
                        <li class="flex items-center gap-3 text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Middleware support
                        </li>
                    </ul>

                    <a href="#" class="inline-flex items-center gap-2 text-indigo-400 font-semibold hover:text-indigo-300 transition-colors">
                        Explorar a arquitetura
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <div class="relative">
                    <div class="absolute -inset-4 bg-indigo-500/20 rounded-3xl blur-xl"></div>
                    <div class="relative rounded-xl bg-[#0F172A] border border-slate-800 shadow-2xl overflow-hidden">
                        <div class="flex items-center gap-2 px-4 py-3 bg-slate-800/50 border-b border-slate-800">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <div class="ml-4 text-xs text-slate-500 font-mono">routes/web.php</div>
                        </div>
                        <div class="p-6 overflow-x-auto">
                            <pre class="font-mono text-sm leading-relaxed"><code class="language-php"><span class="text-violet-400">use</span> <span class="text-blue-400">Slendie\Framework\Router</span>;

<span class="text-slate-500">// Definição de rotas simples e expressiva</span>
<span class="text-yellow-300">Router</span>::<span class="text-blue-300">get</span>(<span class="text-green-300">'/'</span>, <span class="text-green-300">'HomeController@index'</span>);

<span class="text-yellow-300">Router</span>::<span class="text-blue-300">group</span>([<span class="text-green-300">'prefix'</span> => <span class="text-green-300">'/api'</span>], <span class="text-violet-400">function</span>() {
    <span class="text-yellow-300">Router</span>::<span class="text-blue-300">get</span>(<span class="text-green-300">'/users'</span>, [<span class="text-yellow-300">UserController</span>::<span class="text-violet-400">class</span>, <span class="text-green-300">'index'</span>]);
    <span class="text-yellow-300">Router</span>::<span class="text-blue-300">post</span>(<span class="text-green-300">'/users'</span>, [<span class="text-yellow-300">UserController</span>::<span class="text-violet-400">class</span>, <span class="text-green-300">'store'</span>]);
});</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-indigo-600 text-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-4">
                    <div class="text-4xl font-bold mb-2">100%</div>
                    <div class="text-indigo-200 text-sm font-medium uppercase tracking-wide">PHP Moderno</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold mb-2">&lt; 20ms</div>
                    <div class="text-indigo-200 text-sm font-medium uppercase tracking-wide">Tempo de Resposta</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold mb-2">Zero</div>
                    <div class="text-indigo-200 text-sm font-medium uppercase tracking-wide">Dependências Inúteis</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold mb-2">MIT</div>
                    <div class="text-indigo-200 text-sm font-medium uppercase tracking-wide">Open Source</div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <!-- Custom footer links if needed, otherwise using layout default -->
    <div class="max-w-7xl mx-auto px-6 pt-8 pb-4 grid grid-cols-2 md:grid-cols-4 gap-8 text-left">
        <div>
            <h4 class="font-bold text-slate-900 mb-4">Produto</h4>
            <ul class="space-y-2 text-sm text-slate-600">
                <li><a href="#" class="hover:text-indigo-600">Recursos</a></li>
                <li><a href="#" class="hover:text-indigo-600">Integrações</a></li>
                <li><a href="#" class="hover:text-indigo-600">Changelog</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold text-slate-900 mb-4">Recursos</h4>
            <ul class="space-y-2 text-sm text-slate-600">
                <li><a href="/docs" class="hover:text-indigo-600">Documentação</a></li>
                <li><a href="/docs#api" class="hover:text-indigo-600">API Reference</a></li>
                <li><a href="/docs#exemplos" class="hover:text-indigo-600">Exemplos</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold text-slate-900 mb-4">Comunidade</h4>
            <ul class="space-y-2 text-sm text-slate-600">
                <li><a href="#" class="hover:text-indigo-600">GitHub</a></li>
                <li><a href="#" class="hover:text-indigo-600">Discord</a></li>
                <li><a href="#" class="hover:text-indigo-600">Twitter</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold text-slate-900 mb-4">Legal</h4>
            <ul class="space-y-2 text-sm text-slate-600">
                <li><a href="#" class="hover:text-indigo-600">Privacidade</a></li>
                <li><a href="#" class="hover:text-indigo-600">Termos</a></li>
                <li><a href="#" class="hover:text-indigo-600">Licença</a></li>
            </ul>
        </div>
    </div>
@endsection
