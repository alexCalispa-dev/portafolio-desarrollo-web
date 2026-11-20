<?php

declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function base_path(): string
{
    $script = (string) ($_SERVER['SCRIPT_NAME'] ?? '');
    $directory = str_replace('\\', '/', dirname($script));

    return $directory === '' || $directory === '.' || $directory === '/' ? '' : rtrim($directory, '/');
}

function url(string $path = '/'): string
{
    return base_path() . '/index.php/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return base_path() . '/' . ltrim($path, '/');
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(\App\Core\Session::token()) . '">';
}

function old_value(array $values, string $key, string $default = ''): string
{
    return e((string) ($values[$key] ?? $default));
}

function selected(?string $current, string $value): string
{
    return (string) $current === $value ? ' selected' : '';
}

function valid_date(?string $value): bool
{
    if ($value === null || !preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $parts)) {
        return false;
    }

    return checkdate((int) $parts[2], (int) $parts[3], (int) $parts[1]);
}

function safe_path(?string $path, string $default = '/'): string
{
    $path = trim((string) $path);
    if ($path === '' || $path[0] !== '/' || str_starts_with($path, '//')) {
        return $default;
    }

    return $path;
}

function truncate(?string $value, int $length = 80): string
{
    $value = trim((string) $value);

    return mb_strlen($value) > $length ? mb_substr($value, 0, $length - 1) . '…' : $value;
}
