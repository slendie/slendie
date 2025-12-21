@extends('layouts.auth')
@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9v4a2 2 0 01-2 2H5v2a2 2 0 002 2h10a2 2 0 002-2v-4a2 2 0 00-2-2h-2V9a2 2 0 00-2-2z" />
                    </svg>
                </div>
                @if(!session('status'))
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Recuperar a palavra-passe</h1>
                    <p class="text-gray-600">Esqueceu-se da sua palavra-passe? Sem problemas. Introduza o seu email e enviaremos um link para redefinir a sua palavra-passe.</p>
                @else
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Verifique o seu email</h1>
                    <p class="text-gray-600">Enviámos um link de recuperação para o seu email. Verifique a sua caixa de entrada e siga as instruções.</p>
                @endif
            </div>

            <!-- Recovery Form -->
            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">

                @if(!session('status'))
                <!-- Step 1: Email Input -->
                <div id="step1" class="space-y-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Como funciona</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>Introduza o seu email e enviaremos um link para redefinir a sua palavra-passe.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        @include('partials.alerts')
                        <div class="mb-3">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors placeholder-gray-400"
                                   placeholder="seu@email.com" value="{{ old('email', '') }}">
                        </div>

                        <button type="submit"
                                class="w-full mt-6 bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-3 px-4 rounded-xl font-medium hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 transform hover:scale-[1.02]">
                            Enviar link de recuperação
                        </button>
                    </form>
                </div>

                <!-- Step 2: Success Message -->
                @else
                <div id="step2" class="space-y-6">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Email enviado!</h3>
                        <p class="text-gray-600 mb-6">
                            Enviámos um link de recuperação para <strong>{{ request('email') }}</strong>.
                            Verifique a sua caixa de entrada e siga as instruções.
                        </p>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Não recebeu o email?</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>Verifique a pasta de spam/lixo</li>
                                        <li>Aguarde alguns minutos</li>
                                        <li>Certifique-se de que o email está correto</li>
                                        <li>Se não encontrar, espere uns 10 segundos para reenviar o e-mail</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <input type="hidden" id="email" name="email" value="{{ request('email') }}" />
                        <button type="submit" id="resendEmailBtn"
                                class="hidden w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-xl font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Reenviar email
                        </button>
                    </form>
                </div>
                @endif

                <!-- Back to Login -->
                <div class="mt-8 text-center">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Voltar ao login
                    </a>
                </div>
            </div>

            <!-- Additional Help -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Ainda com problemas?
                    <a href="#" class="text-emerald-600 hover:text-emerald-500 font-medium">
                        Entre em contacto
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
@section('bottom-scsripts')
    <script>
        const resendEmailButton = document.getElementById('resendEmailBtn');

        setTimeout(() => {
            resendEmailButton.classList.remove('hidden');
        }, 10000)
    </script>
@endsection
