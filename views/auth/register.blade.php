@extends('layouts.auth')
@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                @if($step === 1)
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Registo de conta</h1>
                    <p class="text-gray-600">Crie a sua conta para começar a usar a plataforma.</p>
                @elseif($step === 2)
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Registo bem-sucedido</h1>
                    <p class="text-gray-600">A sua conta foi criada com sucesso.</p>
                @endif
            </div>

            @if($step === 1)
                <!-- Register Form -->
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <form class="space-y-6" method="POST" action="{{ route('register.store') }}">
                        @csrf
                        @include('partials.alerts')

                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nome
                                </label>
                                <input type="text" id="name" name="name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors placeholder-gray-400"
                                       placeholder="João" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors placeholder-gray-400"
                                   placeholder="seu@email.com" value="{{ old('email') }}">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Palavra-passe
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required minlength="8"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors placeholder-gray-400 pr-12"
                                       placeholder="••••••••" oninput="checkPasswordStrength()">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                        onclick="togglePassword('password')">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <!-- Password Strength Component -->
                            <div id="passwordStrength" class="mt-2 hidden">
                                <div class="grid items-center space-x-2 space-y-1 mb-2">
                                    <div id="req-length" class="text-gray-600 text-xs flex items-center">
                                        <span class="mr-1">❌</span> Mínimo 8 caracteres
                                    </div>
                                    <div id="req-upper" class="text-gray-600 text-xs flex items-center">
                                        <span class="mr-1">❌</span> 1 maiúscula
                                    </div>
                                    <div id="req-number" class="text-gray-600 text-xs flex items-center">
                                        <span class="mr-1">❌</span> 1 número
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                    <div id="strengthBar" class="h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <div id="strengthText" class="font-medium text-xs"></div>
                            </div>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirme a Palavra-passe
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors placeholder-gray-400 pr-12"
                                       placeholder="••••••••">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                        onclick="togglePassword('password_confirmation')">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <div id="passwordMatch" class="mt-2 text-xs hidden">
                                <div class="flex items-center text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                              clip-rule="evenodd" />
                                    </svg>
                                    As palavras-passe não coincidem
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Privacy -->
                        <div class="flex items-start">
                            <input id="terms" name="terms" type="checkbox" required
                                   class="h-4 w-4 mt-1 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="terms" class="ml-3 block text-sm text-gray-700 leading-5">
                                Concordo com os
                                <a href="#" class="text-purple-600 hover:text-purple-500 font-medium">Termos de Serviço</a>
                                e
                                <a href="#" class="text-purple-600 hover:text-purple-500 font-medium">Política de
                                    Privacidade</a>
                            </label>
                        </div>

                        <!-- Newsletter Subscription -->
                        <div class="flex items-start">
                            <input id="newsletter" name="newsletter" type="checkbox"
                                   class="h-4 w-4 mt-1 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="newsletter" class="ml-3 block text-sm text-gray-700">
                                Quero receber atualizações e novidades por email
                            </label>
                        </div>

                        <button type="submit" id="registerBtn"
                                class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-4 rounded-xl font-medium hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            Criar conta
                        </button>
                    </form>

                    <!-- Divider with Social Media -->
                    <div class="mt-8 hidden">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">Ou registe-se com</span>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <button
                                class="w-full inline-flex justify-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path fill="#4285F4"
                                          d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853"
                                          d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05"
                                          d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="#EA4335"
                                          d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                            </button>
                            <button
                                class="w-full inline-flex justify-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-600">
                            Já tem uma conta?
                            <a href="/login" class="font-medium text-purple-600 hover:text-purple-500">
                                Entre aqui
                            </a>
                        </p>
                    </div>
                </div>


                <!-- Step 2: Success Message -->
            @elseif($step === 2)
                <div id="step2" class="space-y-6">
                    <div class="text-center">
                        @include('partials.alerts')

                        <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Já pode usar a plataforma</h3>
                        @auth()
                            <p class="text-gray-600 mb-6">
                                A sua conta foi criada com sucesso. Pode começar a usar a plataforma.
                            </p>
                        @else
                            <p class="text-gray-600 mb-6">
                                Autentique-se no login abaixo.
                            </p>
                        @endauth
                    </div>
                </div>

                <!-- Back to Login -->
                <div class="mt-8 text-center">
                    @auth()
                        <a href="{{ config('fortify.home') }}" class="inline-flex items-center text-sm text-purple-600 hover:text-purple-900 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Entrar na plataforma
                        </a>
                    @else
                        <a href="/login" class="inline-flex items-center text-sm text-purple-600 hover:text-purple-900 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Vá para o login
                        </a>
                    @endauth
                </div>

            @endif

        </div>
    </div>
@endsection
@section('bottom-scripts')
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthDiv = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');

            if (password.length === 0) {
                strengthDiv.classList.add('hidden');
                return;
            }

            strengthDiv.classList.remove('hidden');

            let score = 0;
            const requirements = {
                length: password.length >= 8,
                upper: /[A-Z]/.test(password),
                number: /[0-9]/.test(password)
            };

            // Update requirements display
            Object.keys(requirements).forEach(req => {
                const element = document.getElementById(`req-${req}`);
                const icon = element.querySelector('span');
                if (requirements[req]) {
                    icon.textContent = '✅';
                    element.classList.remove('text-gray-600');
                    element.classList.add('text-green-600');
                    score++;
                } else {
                    icon.textContent = '❌';
                    element.classList.remove('text-green-600');
                    element.classList.add('text-gray-600');
                }
            });

            // Update strength bar and text
            const strength = ['Fraca', 'Média', 'Forte'];
            const colors = ['bg-red-500', 'bg-yellow-500', 'bg-green-500'];
            const widths = ['33%', '66%', '100%'];

            strengthBar.className = `h-2 rounded-full transition-all duration-300 ${colors[score - 1] || 'bg-gray-300'}`;
            strengthBar.style.width = widths[score - 1] || '0%';
            strengthText.textContent = strength[score - 1] || '';
            strengthText.className = `font-medium ${score === 3 ? 'text-green-600' : score === 2 ? 'text-yellow-600' : 'text-red-600'}`;
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const matchDiv = document.getElementById('passwordMatch');

            if (confirmPassword.length === 0) {
                matchDiv.classList.add('hidden');
                return;
            }

            if (password !== confirmPassword) {
                matchDiv.classList.remove('hidden');
            } else {
                matchDiv.classList.add('hidden');
            }
        }
    </script>
@endsection
