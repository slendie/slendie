<?php

declare(strict_types=1);

namespace App\Controllers;

use Slendie\Controllers\Controller;
use Slendie\Framework\CSRF;

final class FormController extends Controller
{
    public function store()
    {
        // Validação CSRF
        if (!CSRF::validate()) {
            $_SESSION['form_errors'] = ['_token' => 'Token CSRF inválido ou expirado. Por favor, recarregue a página e tente novamente.'];
            $_SESSION['old_input'] = $this->request->all();
            return $this->redirect('/');
        }

        // Validação básica dos campos
        $name = $this->request->input('name');
        $email = $this->request->input('email');
        $subject = $this->request->input('subject');
        $message = $this->request->input('message');

        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'O nome é obrigatório.';
        }

        if (empty($email)) {
            $errors['email'] = 'O e-mail é obrigatório.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'O e-mail informado é inválido.';
        }

        if (empty($subject)) {
            $errors['subject'] = 'O assunto é obrigatório.';
        }

        if (empty($message)) {
            $errors['message'] = 'A mensagem é obrigatória.';
        }

        // Se houver erros, redireciona de volta com os erros
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['old_input'] = $this->request->all();
            return $this->redirect('/');
        }

        unset($_SESSION['form_errors']);
        unset($_SESSION['old_input']);

        // Aqui você pode processar o formulário (salvar no banco, enviar email, etc.)
        // Por enquanto, apenas armazena em sessão para exibir mensagem de sucesso
        $_SESSION['form_success'] = 'Mensagem enviada com sucesso!';

        // Redireciona de volta para a home com mensagem de sucesso
        return $this->redirect('/');
    }
}
