<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path, true, 302);
        exit;
    }

    protected function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect(url('/'));
        }
    }

    protected function verifyCsrf(): void
    {
        if (!Session::verify($_POST['csrf_token'] ?? null)) {
            http_response_code(419);
            View::render('errors/419', ['title' => 'Sesion expirada']);
            exit;
        }
    }

    protected function notFound(): void
    {
        http_response_code(404);
        View::render('errors/404', ['title' => 'No encontrado']);
        exit;
    }
}
