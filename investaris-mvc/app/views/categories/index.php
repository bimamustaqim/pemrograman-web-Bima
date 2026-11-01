
<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3">Data Kategori</h1>
        <p class="text-muted mb-0">
            Kelola kategori barang inventaris.
        </p>
    </div>

    <a href="<?= e(base_url('categories/create')) ?>"
       class="btn btn-primary">
        + Tambah Kategori
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada data kategori.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $index => $category): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= e($category['name']) ?></td>
                                <td><?= e($category['description'] ?? '') ?></td>
                                <td><?= (int) $category['item_count'] ?></td>
                                <td>
                                    <a
                                        href="<?= e(base_url('categories/edit/' . $category['id'])) ?>"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form
                                        action="<?= e(base_url('categories/delete/' . $category['id'])) ?>"
                                        method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= e(base_url()) ?>" class="btn btn-secondary">
        Kembali ke Dashboard
    </a>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
