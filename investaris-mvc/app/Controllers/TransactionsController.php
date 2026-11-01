<?php

class TransactionsController extends Controller
{
    // Menampilkan riwayat transaksi.
    public function index(): void
    {
        $this->requireLogin();

        $this->view('transactions/index', [
            'title' => 'Riwayat Transaksi',
            'transactions' => $this->model('Transaction')->all(),
        ]);
    }

    // Memproses barang masuk.
    public function stockIn(): void
    {
        $this->requireLogin();

        $this->store(
            'IN',
            'Barang masuk berhasil dicatat!'
        );
    }

    // Memproses barang keluar.
    public function stockOut(): void
    {
        $this->requireLogin();

        $this->store(
            'OUT',
            'Barang keluar berhasil dicatat!'
        );
    }

    // Proses penyimpanan transaksi.
    private function store(string $type, string $msg): void
    {
        // Transaksi hanya boleh melalui POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('transactions');
        }

        $itemId = (int) ($_POST['item_id'] ?? 0);
        $qty = (int) ($_POST['quantity'] ?? 0);

        // Validasi data.
        if ($itemId <= 0 || $qty <= 0) {
            $this->flash('danger', 'Data tidak valid.');
            $this->redirect('items');
        }

        // Menyimpan transaksi melalui Model.
        $ok = $this->model('Transaction')->create([
            'item_id' => $itemId,
            'user_id' => $_SESSION['user']['id'],
            'type' => $type,
            'quantity' => $qty,
            'notes' => trim($_POST['notes'] ?? '') ?: null,
        ]);

        // Menampilkan pesan hasil transaksi.
        $this->flash(
            $ok ? 'success' : 'danger',
            $ok ? $msg : 'Gagal. Stok tidak mencukupi.'
        );

        $this->redirect('items');
    }
}