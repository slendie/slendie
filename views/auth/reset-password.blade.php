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
                @if($step === 1)
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Recuperar a palavra-passe</h1>
                    <p class="text-gray-600">Defina uma nova palavra-passe para a sua conta.</p>
                @elseif($step === 2)
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Palavra-passe alterada</h1>
                    <p class="text-gray-600">A sua palavra-passe foi alterada com sucesso.</p>
                @endif
            </div>

            <!-- Change Password Form -->
            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">

                @if($step === 1)
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
                                <h3 class="text-sm font-medium text-blue-800">Para definir a sua nova palavra-passe:</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul>
                                        <li>Indiqe o seu e-mail.</li>
                                        <li>Defina uma nova palavra-passe e confirme-a.</li>
                                        <li>Clique em Alterar a palavra-passe.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @include('partials.alerts')

                        <div class="mb-3">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors placeholder-gray-400"
                                   placeholder="seu@email.com" value="{{ old('email', $request['email'] ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Nova Palavra-passe
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors placeholder-gray-400"
                                       placeholder="••••••••" oninput="checkPasswordStrength()">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                        <div class="mb-3">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmação da Palavra-passe
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors placeholder-gray-400"
                                       placeholder="••••••••">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation')">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <input type="hidden" name="token" value="{{ $request['token'] ?? '' }}">

                        <button type="submit"
                                class="w-full mt-6 bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-3 px-4 rounded-xl font-medium hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 transform hover:scale-[1.02]">
                            Alterar a palavra-passe
                        </button>
                    </form>
                </div>

                <!-- Step 2: Success Message -->
                @elseif($step === 2)
                <div id="step2" class="space-y-6">
                    <div class="text-center">
                        @include('partials.alerts')

                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Palavra-passe alterada!</h3>
                        <p class="text-gray-600 mb-6">
                            A sua palavra-passe foi alterada com sucesso.
                        </p>
                    </div>
                </div>
                @endif

                <!-- Back to Login -->
                <div class="mt-8 text-center">
                    <a href="/login"
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

        function resendEmail() {
            alert('Email reenviado! Verifique a sua caixa de entrada.');
        }
    </script>
@endsection
