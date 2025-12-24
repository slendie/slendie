@extends('layouts.front')
@section('styles')
    <style>
        /* Estilos para o formulário de contato */
        form.contact-form {
            max-width: 720px;
            margin: 1.5rem auto;
            padding: 1.25rem;
            background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
            border: 1px solid #e6eef6;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(18, 38, 63, 0.06);
            font-family: inherit;
        }
        form.contact-form div { margin-bottom: 0.9rem; }
        form.contact-form label {
            display: block;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.32rem;
            color: #213547;
        }
        form.contact-form input[type="text"],
        form.contact-form input[type="email"],
        form.contact-form textarea {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #d7e3ee;
            border-radius: 8px;
            background: #ffffff;
            transition: border-color .15s ease, box-shadow .15s ease;
            font-size: 0.95rem;
            color: #10212f;
            box-sizing: border-box;
        }
        form.contact-form input:focus,
        form.contact-form textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 6px 18px rgba(59,130,246,0.12);
        }
        form.contact-form textarea { resize: vertical; min-height: 120px; }
        form.contact-form button[type="submit"]{
            background: linear-gradient(180deg,#2b8be6 0%, #1f6fc2 100%);
            color: #ffffff;
            border: none;
            padding: 0.6rem 1rem;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: background .12s ease, transform .06s ease, box-shadow .12s ease;
            box-shadow: 0 6px 12px rgba(43,139,230,0.12);
        }
        form.contact-form button[type="submit"]:hover{
            background: #1f6fc2;
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(31,111,194,0.12);
        }
        .form-actions { display:flex; justify-content:flex-end; gap:0.5rem; margin-top:0.4rem; }
        @media (max-width: 560px) {
            form.contact-form { padding: 1rem; border-radius: 8px; }
            .form-actions { flex-direction: column; align-items: stretch; }
        }
    </style>
@endsection
@section('content')
    <h2>Home</h2>
    <p>Bem-vindo à Home</p>
    @include('partials.check-counter')
    
    @if($form_success)
        <div style="max-width: 720px; margin: 1.5rem auto; padding: 0.75rem 1rem; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; color: #155724;">
            {{ $form_success }}
        </div>
    @endif
    
    <form method="POST" class="contact-form" action="/contato">
        @csrf
        @if(array_key_exists('_token', $form_errors))
            <div style="padding: 0.75rem 1rem; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; color: #721c24; margin-bottom: 1rem;">
                {{ $form_errors['_token'] }}
            </div>
        @endif
        <div>
            <label for="name">Nome</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            @if(array_key_exists('name', $form_errors))
                <span style="color: #dc3545; font-size: 0.875rem; display: block; margin-top: 0.25rem;">{{ $form_errors['name'] }}</span>
            @endif
        </div>
        <div>
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @if(array_key_exists('email', $form_errors))
                <span style="color: #dc3545; font-size: 0.875rem; display: block; margin-top: 0.25rem;">{{ $form_errors['email'] }}</span>
            @endif
        </div>
        <div>
            <label for="subject">Assunto</label>
            <input id="subject" type="text" name="subject" value="{{ old('subject') }}">
            @if(array_key_exists('subject', $form_errors))
                <span style="color: #dc3545; font-size: 0.875rem; display: block; margin-top: 0.25rem;">{{ $form_errors['subject'] }}</span>
            @endif
        </div>
        <div>
            <label for="message">Mensagem</label>
            <textarea id="message" name="message" rows="5">{{ old('message') }}</textarea>
            @if(array_key_exists('message', $form_errors))
                <span style="color: #dc3545; font-size: 0.875rem; display: block; margin-top: 0.25rem;">{{ $form_errors['message'] }}</span>
            @endif
        </div>
        <button type="submit">Enviar</button>
    </form>
@endsection
@section('footer')
    <p>Footer from home</p>
@endsection
