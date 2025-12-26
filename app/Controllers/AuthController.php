<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Slendie\Controllers\Controller;

final class AuthController extends Controller
{
    /**
     * GET /login
     */
    public function login()
    {
        $this->render('auth/login');
    }

    /**
     * POST /signin
     */
    public function signin()
    {
        // Implement signin logic here
        $email = $this->request->input('email');
        $password = $this->request->input('password');

        // Garante que formErrors seja um array
        if (!is_array($this->formErrors)) {
            $this->formErrors = [];
        }

        // Sanitiza o email para evitar XSS (senha não precisa ser sanitizada)
        $email = $email ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : '';

        if (empty($email) || empty($password)) {
            $this->formErrors['email'] = "Por favor, preencha todos os campos.";
        } else {
            $user = User::where('email', $email)->first();
            if (! $user) {
                $this->formErrors['email'] = "Email ou senha inválidos.";
            } else {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    return $this->redirect(config('app.home') . '/app');
                }
                $this->formErrors['email'] = "Email ou senha inválidos.";

            }
        }

        $this->render('auth/login');
    }

    public function register()
    {
        $this->render('auth/register', [
            'step' => 1,
        ]);
    }

    public function store()
    {
        // Garante que formErrors seja um array
        if (!is_array($this->formErrors)) {
            $this->formErrors = [];
        }

        // Obtém dados do formulário
        $name = $this->request->input('name');
        $email = $this->request->input('email');
        $password = $this->request->input('password');
        $password_confirmation = $this->request->input('password_confirmation');

        // Sanitiza os dados para evitar XSS
        $name = $name ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : '';
        $email = $email ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : '';

        // Validação
        if (empty($name)) {
            $this->formErrors['name'] = "O nome é obrigatório.";
        }

        if (empty($email)) {
            $this->formErrors['email'] = "O email é obrigatório.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->formErrors['email'] = "O email fornecido não é válido.";
        } else {
            // Verifica se o email já existe
            $existingUser = User::where('email', $email)->first();
            if ($existingUser) {
                $this->formErrors['email'] = "Este email já está em uso.";
            }
        }

        if (empty($password)) {
            $this->formErrors['password'] = "A senha é obrigatória.";
        } elseif (mb_strlen($password) < 8) {
            $this->formErrors['password'] = "A senha deve ter pelo menos 8 caracteres.";
        }

        if (empty($password_confirmation)) {
            $this->formErrors['password_confirmation'] = "A confirmação de senha é obrigatória.";
        } elseif (!empty($password) && $password !== $password_confirmation) {
            // Só verifica se as senhas coincidem se ambas foram fornecidas
            $this->formErrors['password'] = "As senhas não coincidem.";
        }

        // Se não houver erros, cria o usuário
        if (empty($this->formErrors)) {
            // Hash da senha
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Cria o usuário (sem role_id por padrão, pode ser atribuído depois)
            $userId = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'role_id' => null
            ]);

            // Define mensagem de sucesso na sessão
            $_SESSION['form_success'] = "Registro realizado com sucesso! Faça login para continuar.";

            // Redireciona para login
            return $this->redirect('/login');
        }

        // Se houver erros, renderiza a view de registro novamente
        $this->render('auth/register', [
            'step' => 1,
        ]);
    }

    public function resetPassword()
    {
        $this->render('auth/reset-password', [
            'step' => 1,
        ]);
    }

    public function forgotPassword()
    {
        $this->render('auth/forgot-password');
    }

    public function logout()
    {
        // Implement logout logic here
        session_destroy();
        return $this->redirect('/login');
    }
}
