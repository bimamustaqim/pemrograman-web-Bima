
<?php

define('ROOT_PATH', dirname(__DIR__, 2));

function loadEnv(string $file): void
{
    if (!file_exists($file)) {
        return;
    }

    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$name, $value] = array_map('trim', explode('=', $line, 2));

        $_ENV[$name] = trim($value, "\"'");
        putenv("$name=$value");
    }
}

loadEnv(ROOT_PATH . '/public/.env');

function env(string $key, $default = null)
{
    $value = $_ENV[$key] ?? getenv($key);

    return ($value === false || $value === null || $value === '')
        ? $default
        : $value;
}
