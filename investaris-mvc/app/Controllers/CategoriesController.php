
<?php

class CategoriesController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $this->view('categories/index', [
            'title' => 'Data Kategori',
            'categories' => $this->model('Category')->all(),
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->view('categories/create', [
            'title' => 'Tambah Kategori',
            'category' => [
                'name' => '',
                'description' => '',
            ],
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $input = array_map('trim', $_POST);

        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/create');
        }

        $this->model('Category')->create([
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);

        $this->flash('success', 'Kategori berhasil ditambahkan.');
        $this->redirect('categories');
    }

    public function edit(int $id): void
    {
        $this->requireLogin();
        $category = $this->model('Category')->find($id);

        if (!$category) {
            $this->flash('danger', 'Kategori tidak ditemukan.');
            $this->redirect('categories');
        }

        $this->view('categories/edit', [
            'title' => 'Edit Kategori',
            'category' => $category,
        ]);
    }

    public function update(int $id): void
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $input = array_map('trim', $_POST);

        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/edit/' . $id);
        }

        $category = $this->model('Category')->find($id);

        if (!$category) {
            $this->flash('danger', 'Kategori tidak ditemukan.');
            $this->redirect('categories');
        }

        $this->model('Category')->update($id, [
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);

        $this->flash('success', 'Kategori berhasil diperbarui.');
        $this->redirect('categories');
    }

    public function delete(int $id): void
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $category = $this->model('Category')->find($id);

        if (!$category) {
            $this->flash('danger', 'Kategori tidak ditemukan.');
            $this->redirect('categories');
        }

        try {
            $this->model('Category')->delete($id);
            $this->flash('success', 'Kategori berhasil dihapus.');
        } catch (PDOException $e) {
            $this->flash(
                'danger',
                'Kategori tidak dapat dihapus karena masih digunakan oleh barang.'
            );
        }

        $this->redirect('categories');
    }
}
