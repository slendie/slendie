<?php

namespace App\Controllers;

use Slendie\Controllers\Controller;
use Slendie\Framework\Blade;

class AuthController extends Controller
{
    public function login()
    {
        // Implement login logic here
        $blade = new Blade();

        // Get form errors and success message from session
        $formErrors = $_SESSION['form_errors'] ?? [];
        $formSuccess = $_SESSION['form_success'] ?? null;

        // Clear session messages after retrieving them
        unset($_SESSION['form_errors']);
        unset($_SESSION['form_success']);

        $html = $blade->render('auth/login', [
            'form_errors' => $formErrors,
            'errors' => $formErrors, // Also pass as 'errors' for Laravel-like compatibility
            'form_success' => $formSuccess,
        ]);

        echo $html;
    }

    public function signin()
    {
        $blade = new Blade();

        // Get form errors and success message from session
        $formErrors = $_SESSION['form_errors'] ?? [];
        $formSuccess = $_SESSION['form_success'] ?? null;

        // Clear session messages after retrieving them
        unset($_SESSION['form_errors']);
        unset($_SESSION['form_success']);

        // Implement signin logic here
        $email = $this->request->input('email');
        $password = $this->request->input('password');

        // Sanitiza os dados para evitar XSS
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

        if ($email === 'coach@coachingsandrafelix.com' && $password === 'acessoinscritos2025+') {
            // Login direto para o usuário de teste
            $_SESSION['user_id'] = 1; // ID fictício para o usuário de teste

            return $this->redirect('/app/inscritos');
        } else {
            // Verifica se os campos estão preenchidos
            if (empty($email) || empty($password)) {
                $formErrors['email'] = "Por favor, preencha todos os campos.";
            } else {
                // Aqui você pode adicionar a lógica de autenticação real
                $formErrors['email'] = "Email ou senha inválidos.";
            }
        }

        $html = $blade->render('auth/login', [
            'form_errors' => $formErrors,
            'errors' => $formErrors, // Also pass as 'errors' for Laravel-like compatibility
            'form_success' => $formSuccess,
        ]);

        echo $html;
    }

    public function logout()
    {
        // Implement logout logic here
        session_destroy();
        return $this->redirect('/login');
    }
}