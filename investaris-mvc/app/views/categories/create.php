
<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h1 class="h4 mb-0">Tambah Kategori</h1>
    </div>

    <div class="card-body">
        <form action="<?= e(base_url('categories/store')) ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">
                    Nama Kategori
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    maxlength="100"
                    value="<?= e($category['name'] ?? '') ?>"
                    placeholder="Contoh: Elektronik"
                    required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    id="description"
                    class="form-control"
                    rows="4"
                    placeholder="Masukkan deskripsi kategori"><?= e($category['description'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan Kategori
            </button>

            <a href="<?= e(base_url('categories')) ?>"
               class="btn btn-secondary">
                Batal
            </a>
        </form>
    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
