<?php

class AuthController extends Controller
{
    // Menampilkan halaman login.
    public function login(): void
    {
        // Jika sudah login, arahkan ke dashboard.
        if (Middleware::isLoggedIn()) {
            $this->redirect('');
        }

        $this->view('auth/login', [
            'title' => 'Login'
        ]);
    }

    // Memproses data login.
    public function authenticate(): void
    {
        // Login hanya boleh melalui POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/login');
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validasi input.
        if ($username === '' || $password === '') {
            $this->flash('danger', 'Username dan password wajib diisi.');
            $this->redirect('auth/login');
        }

        // Memeriksa akun melalui Model User.
        $user = $this->model('User')->login($username, $password);

        if (!$user) {
            $this->flash('danger', 'Username atau password salah.');
            $this->redirect('auth/login');
        }

        // Membuat session pengguna.
        session_regenerate_id(true);
        $_SESSION['user'] = $user;

        $this->flash('success', 'Login berhasil. Selamat datang!');
        $this->redirect('');
    }

    // Memproses logout.
    public function logout(): void
    {
        // Logout hanya boleh melalui POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('');
        }

        // Menghapus session pengguna.
        unset($_SESSION['user']);

        // Mengganti ID session.
        session_regenerate_id(true);

        $this->flash('success', 'Kamu berhasil logout.');
        $this->redirect('auth/login');
    }
}