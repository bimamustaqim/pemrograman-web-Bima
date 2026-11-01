
<?php

class ItemsController extends Controller
{
   
public function index(): void
{
    $this->requireLogin();

    // Mengambil kata pencarian.
    $search = trim($_GET['search'] ?? '');

    // Mengambil kategori.
    $categoryId = $_GET['category'] ?? '';

    if ($categoryId !== '' && !ctype_digit((string) $categoryId)) {
        $categoryId = '';
    }

    // Mengambil nomor halaman.
    $page = max(1, (int) ($_GET['page'] ?? 1));

    // Mengambil jumlah data per halaman.
    $limit = (int) ($_GET['limit'] ?? 10);

    $allowedLimits = [5, 10, 20, 50, 100];

    if (!in_array($limit, $allowedLimits, true)) {
        $limit = 10;
    }

    // Mengambil data barang.
    $result = $this->model('Item')->paginate(
        $limit,
        $page,
        $search,
        $categoryId
    );

    // Mengirim data ke halaman.
    $this->view('items/index', [
        'title' => 'Data Barang',
        'items' => $result['data'],
        'pagination' => $result,
        'categories' => $this->model('Category')->all(),
        'search' => $search,
        'categoryId' => $categoryId,
        'limit' => $limit,
    ]);
}

    // Menampilkan formulir tambah barang.
    public function create(): void
    {
        $this->requireLogin();
        $this->view('items/create', [
            'title' => 'Tambah Barang',
            'item' => [
                'code' => '',
                'name' => '',
                'category_id' => '',
                'quantity' => 0,
                'unit' => 'unit',
                'price' => 0,
                'entry_date' => '',
                'description' => '',
            ],
            'categories' => $this->model('Category')->all(),
        ]);
    }

    // Menyimpan barang baru.
    public function store(): void
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $input = array_map('trim', $_POST);

        if (
            empty($input['code']) ||
            empty($input['name']) ||
            !isset($input['quantity'], $input['price']) ||
            !is_numeric($input['quantity']) ||
            !is_numeric($input['price']) ||
            (int) $input['quantity'] < 0 ||
            (float) $input['price'] < 0
        ) {
            $this->flash('danger', 'Periksa kembali kode, nama, jumlah, dan harga barang.');
            $this->redirect('items/create');
        }

        $this->model('Item')->create([
            'code' => $input['code'],
            'name' => $input['name'],
            'category_id' => $input['category_id'] ?? '',
            'quantity' => (int) $input['quantity'],
            'unit' => $input['unit'] ?: 'unit',
            'price' => (float) $input['price'],
            'entry_date' => $input['entry_date'] ?? '',
            'description' => $input['description'] ?? '',
        ]);

        $this->flash('success', 'Barang berhasil ditambahkan.');
        $this->redirect('items');
    }

    // Menampilkan formulir edit barang.
    public function edit(int $id): void
    {
        $this->requireLogin();
        $item = $this->model('Item')->find($id);

        if (!$item) {
            $this->flash('danger', 'Barang tidak ditemukan.');
            $this->redirect('items');
        }

        $this->view('items/edit', [
            'title' => 'Edit Barang',
            'item' => $item,
            'categories' => $this->model('Category')->all(),
        ]);
    }

    // Memperbarui barang.
    public function update(int $id): void
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $input = array_map('trim', $_POST);

        if (
            empty($input['code']) ||
            empty($input['name']) ||
            !isset($input['quantity'], $input['price']) ||
            !is_numeric($input['quantity']) ||
            !is_numeric($input['price']) ||
            (int) $input['quantity'] < 0 ||
            (float) $input['price'] < 0
        ) {
            $this->flash('danger', 'Periksa kembali kode, nama, jumlah, dan harga barang.');
            $this->redirect('items/edit/' . $id);
        }

        $item = $this->model('Item')->find($id);

        if (!$item) {
            $this->flash('danger', 'Barang tidak ditemukan.');
            $this->redirect('items');
        }

        $this->model('Item')->update($id, [
            'code' => $input['code'],
            'name' => $input['name'],
            'category_id' => $input['category_id'] ?? '',
            'quantity' => (int) $input['quantity'],
            'unit' => $input['unit'] ?: 'unit',
            'price' => (float) $input['price'],
            'entry_date' => $input['entry_date'] ?? '',
            'description' => $input['description'] ?? '',
        ]);

        $this->flash('success', 'Barang berhasil diperbarui.');
        $this->redirect('items');
    }

    // Menghapus barang.
    public function delete(int $id): void
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $item = $this->model('Item')->find($id);

        if (!$item) {
            $this->flash('danger', 'Barang tidak ditemukan.');
            $this->redirect('items');
        }

        try {
            $this->model('Item')->delete($id);
            $this->flash('success', 'Barang berhasil dihapus.');
        } catch (PDOException $e) {
            $this->flash('danger', 'Barang tidak dapat dihapus karena masih memiliki riwayat transaksi.');
        }

        $this->redirect('items');
    }
}
