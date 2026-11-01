<?php

class HomeController extends Controller
{
    public function index(): void
    {
        // Memastikan pengguna sudah login.
        $this->requireLogin();

        // Menampilkan halaman Dashboard.
        $this->view('dashboard/index', [
            'title' => 'Dashboard'
        ]);
    }
}