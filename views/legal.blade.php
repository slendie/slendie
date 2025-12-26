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
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 md:p-12">
                <h1 class="text-4xl font-bold text-slate-900 mb-2">Informações Legais</h1>
                <p class="text-lg text-slate-600 mb-10 leading-relaxed">
                    Política de Privacidade, Termos de Uso e Licença do Slendie Framework.
                </p>

                <hr class="my-10 border-slate-100">

                <!-- Política de Privacidade -->
                <section id="privacidade" class="scroll-mt-28 mb-12">
                    <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="text-indigo-600"><a name="privacy"></a>#</span> Política de Privacidade
                    </h2>
                    <div class="prose prose-slate max-w-none">
                        <p class="text-slate-600 mb-4 leading-relaxed">
                            O Slendie Framework é um projeto de código aberto disponibilizado gratuitamente. 
                            <strong>Não coletamos, armazenamos ou processamos nenhuma informação pessoal</strong> de usuários 
                            que utilizam este framework.
                        </p>
                        <p class="text-slate-600 mb-4 leading-relaxed">
                            Este projeto é fornecido <strong>"AS IS"</strong> (como está), sem garantias de qualquer tipo, 
                            expressas ou implícitas. Você é livre para usar, modificar e distribuir o código conforme 
                            os termos da licença MIT.
                        </p>
                        <p class="text-slate-600 leading-relaxed">
                            Se você tiver dúvidas sobre esta política, entre em contato através do 
                            <a href="https://github.com/slendie/slendie" target="_blank" class="text-indigo-600 hover:text-indigo-700">repositório no GitHub</a>.
                        </p>
                    </div>
                </section>

                <hr class="my-10 border-slate-100">

                <!-- Termos de Uso -->
                <section id="termos" class="scroll-mt-28 mb-12">
                    <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="text-indigo-600"><a name="terms"></a>#</span> Termos de Uso
                    </h2>
                    <div class="prose prose-slate max-w-none">
                        <p class="text-slate-600 mb-4 leading-relaxed">
                            Ao usar o Slendie Framework, você concorda com os seguintes termos:
                        </p>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-4">
                            <h3 class="font-semibold text-slate-800 mb-3">Uso do Software</h3>
                            <p class="text-slate-600 mb-3 leading-relaxed">
                                Você é livre para usar o Slendie Framework em projetos pessoais, comerciais ou de qualquer natureza, 
                                conforme os termos da licença MIT.
                            </p>
                            <h3 class="font-semibold text-slate-800 mb-3">Isenção de Responsabilidade</h3>
                            <p class="text-slate-600 mb-3 leading-relaxed">
                                <strong>Nos isentamos de qualquer responsabilidade</strong> pelo uso do framework. O código pode estar 
                                sujeito a erros não intencionais, bugs ou falhas. O uso do software é por sua conta e risco.
                            </p>
                            <p class="text-slate-600 leading-relaxed">
                                Não garantimos que o software atenderá aos seus requisitos específicos, que será ininterrupto, 
                                seguro ou livre de erros, ou que os defeitos serão corrigidos.
                            </p>
                        </div>
                        <p class="text-slate-600 leading-relaxed">
                            Ao utilizar este framework, você reconhece que leu, entendeu e concorda com estes termos de uso.
                        </p>
                    </div>
                </section>

                <hr class="my-10 border-slate-100">

                <!-- Licença MIT -->
                <section id="licenca" class="scroll-mt-28">
                    <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="text-indigo-600"><a name="license"></a>#</span> Licença MIT
                    </h2>
                    <div class="bg-slate-900 rounded-xl p-6 mb-6 overflow-x-auto shadow-lg">
                        <pre class="text-indigo-100 font-mono text-sm leading-relaxed">MIT License

Copyright (c) 2024 Slendie Framework

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.</pre>
                    </div>
                    <div class="prose prose-slate max-w-none">
                        <p class="text-slate-600 mb-4 leading-relaxed">
                            A <strong>Licença MIT</strong> é uma licença de software livre e de código aberto, permissiva e curta. 
                            Ela permite que você:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-slate-600 mb-4 ml-4">
                            <li>Usar o software comercialmente</li>
                            <li>Modificar o software</li>
                            <li>Distribuir o software</li>
                            <li>Usar o software de forma privada</li>
                            <li>Sublicenciar e vender o software</li>
                        </ul>
                        <p class="text-slate-600 leading-relaxed">
                            A única condição é que você mantenha o aviso de copyright e a declaração de licença em todas as cópias 
                            ou partes substanciais do software.
                        </p>
                    </div>
                </section>

                <hr class="my-10 border-slate-100">

                <!-- Informações de Contato -->
                <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-6">
                    <h3 class="font-semibold text-slate-900 mb-2">Última Atualização</h3>
                    <p class="text-sm text-slate-600 mb-4">
                        Esta página foi atualizada pela última vez em {{ date('d/m/Y') }}.
                    </p>
                    <h3 class="font-semibold text-slate-900 mb-2">Contato</h3>
                    <p class="text-sm text-slate-600">
                        Para questões sobre privacidade, termos de uso ou licenciamento, visite nosso 
                        <a href="https://github.com/slendie/slendie" target="_blank" class="text-indigo-600 hover:text-indigo-700">repositório no GitHub</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <!-- Footer padrão -->
@endsection

