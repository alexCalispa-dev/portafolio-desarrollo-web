<?php

declare(strict_types=1);

require dirname(__DIR__, 2) . '/app/core/functions.php';

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $file = dirname(__DIR__) . '/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

\App\Core\Session::start();

try {
    \App\Core\Migrator::install();
} catch (\Throwable $exception) {
    \App\Core\View::render('errors/install', [
        'title' => 'Error de instalacion',
        'detail' => $exception->getMessage(),
    ]);
    exit;
}
