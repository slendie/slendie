@extends('layouts.auth')
@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 border border-gray-100 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">E-mail verificado com sucesso!</h1>
            <p class="text-gray-600 mb-6">
                O seu endereço de e-mail foi confirmado.<br>
                Já pode aceder à plataforma.
            </p>
            <a href="{{ config('fortify.home') }}"
               class="w-full inline-block bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-4 rounded-xl font-medium hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-[1.02]">
                Entrar na plataforma
            </a>
        </div>
    </div>
@endsection

