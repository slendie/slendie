@extends('layouts.auth')
@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 border border-gray-100 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Verifique o seu e-mail</h1>
            <p class="text-gray-600 mb-6">
                Para aceder a este recurso, confirme o seu endereço de e-mail.<br>
                Se não recebeu o e-mail, pode reenviá-lo abaixo.
            </p>
            @if (session('status') === 'verification-link-sent')
                <div class="mb-4 text-green-600 text-sm">
                    Um novo e-mail de verificação foi enviado!
                </div>
            @endif
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-4 rounded-xl font-medium hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-[1.02]">
                    Reenviar e-mail de verificação
                </button>
            </form>
            <div class="mt-6">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                       class="text-sm text-gray-500 hover:text-gray-700 underline">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
