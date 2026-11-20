<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $view, array $data = [], string $title = ''): void
    {
        $config = require dirname(__DIR__, 2) . '/config/app.php';
        $data['appName'] = $data['appName'] ?? $config['name'];
        $data['title'] = $title !== '' ? $title : ($data['title'] ?? $data['appName']);
        $data['flash'] = $data['flash'] ?? Session::takeFlash();

        $viewFile = dirname(__DIR__) . '/views/' . $view . '.php';
        if (!is_file($viewFile)) {
            throw new \RuntimeException('Vista no encontrada: ' . $view);
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewFile;
        $content = (string) ob_get_clean();

        require dirname(__DIR__) . '/views/layout.php';
    }
}
