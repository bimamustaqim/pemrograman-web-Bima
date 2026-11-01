
<?php

class Middleware
{
    // Memeriksa apakah pengguna sudah login.
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    // Mengarahkan pengguna yang belum login.
    public static function requireLogin(): void
    {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    // Memeriksa apakah pengguna memiliki role admin.
    public static function requireAdmin(): void
    {
        self::requireLogin();

        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/');
            exit;
        }
    }
}
