<?php

class HomeController extends Controller
{
    public function index(): void
    {
        // Memastikan pengguna sudah login.
        $this->requireLogin();

        // Mengambil data statistik.
        $itemModel = $this->model('Item');
        $categoryModel = $this->model('Category');
        $transactionModel = $this->model('Transaction');

        $totalBarang = $itemModel->totalBarang();
        $totalKategori = $categoryModel->count();
        $totalStok = $itemModel->totalStok();
        $totalTransaksi = $transactionModel->totalTransaksi();

        // Mengirim data statistik ke halaman dashboard.
        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'totalBarang' => $totalBarang,
            'totalKategori' => $totalKategori,
            'totalStok' => $totalStok,
            'totalTransaksi' => $totalTransaksi
        ]);
    }
}