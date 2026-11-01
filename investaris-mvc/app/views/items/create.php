
<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<h1 class="h3 mb-4">Tambah Barang</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= e(base_url('items/store')) ?>" method="POST">

            <div class="mb-3">
                <label for="code" class="form-label">Kode Barang</label>
                <input
                    type="text"
                    name="code"
                    id="code"
                    class="form-control"
                    maxlength="20"
                    required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nama Barang</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    maxlength="150"
                    required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">-- Tanpa Kategori --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= e($category['id']) ?>">
                            <?= e($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label">Jumlah Stok</label>
                    <input
                        type="number"
                        name="quantity"
                        id="quantity"
                        class="form-control"
                        min="0"
                        value="0"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="unit" class="form-label">Satuan</label>
                    <input
                        type="text"
                        name="unit"
                        id="unit"
                        class="form-control"
                        maxlength="20"
                        value="unit"
                        required>
                </div>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Harga Barang (Rp)</label>
                <input
                    type="number"
                    name="price"
                    id="price"
                    class="form-control"
                    min="0"
                    step="0.01"
                    value="0"
                    required>
            </div>

            <div class="mb-3">
                <label for="entry_date" class="form-label">Tanggal Masuk</label>
                <input
                    type="date"
                    name="entry_date"
                    id="entry_date"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea
                    name="description"
                    id="description"
                    class="form-control"
                    rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan Barang
            </button>

            <a href="<?= e(base_url('items')) ?>"
               class="btn btn-secondary">
                Batal
            </a>

        </form>
    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
