
<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<?php
$currentPage = $pagination['current_page'];
$totalPages = $pagination['total_pages'];
$totalData = $pagination['total_data'];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3">Data Barang</h1>
        <p class="text-muted">Daftar barang inventaris.</p>
    </div>

    <a href="<?= e(base_url('items/create')) ?>"
       class="btn btn-primary">
        + Tambah Barang
    </a>
</div>

<!-- Form Pencarian dan Filter -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="<?= e(base_url('items')) ?>" method="GET">
            <div class="row g-3">

                <div class="col-md-5">
                    <label class="form-label">Cari Barang</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari kode, nama, atau kategori..."
                        value="<?= e($search) ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Filter Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>

                        <?php foreach ($categories as $category): ?>
                            <option
                                value="<?= e($category['id']) ?>"
                                <?= (string) $categoryId === (string) $category['id'] ? 'selected' : '' ?>>
                                <?= e($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Data per Halaman</label>
                    <select name="limit" class="form-select">
                        <?php foreach ([5, 10, 20, 50, 100] as $option): ?>
                            <option
                                value="<?= $option ?>"
                                <?= $limit === $option ? 'selected' : '' ?>>
                                <?= $option ?> Data
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        Cari
                    </button>
                </div>

            </div>
        </form>

        <div class="mt-3">
            <a href="<?= e(base_url('items')) ?>" class="btn btn-sm btn-secondary">
                Reset Pencarian
            </a>
        </div>
    </div>
</div>

<!-- Tabel Data Barang -->
<div class="card shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">
            <span class="text-muted">
                Total data: <?= $totalData ?> barang
            </span>
            <span class="text-muted">
                Halaman <?= $currentPage ?> dari <?= $totalPages ?>
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Data barang tidak ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>

                        <?php foreach ($items as $index => $item): ?>
                            <tr>
                                <td><?= (($currentPage - 1) * $limit) + $index + 1 ?></td>
                                <td><?= e($item['code']) ?></td>
                                <td><?= e($item['name']) ?></td>
                                <td><?= e($item['category_name'] ?? '-') ?></td>
                                <td>
                                    <?= e($item['quantity']) ?>
                                    <?= e($item['unit']) ?>
                                </td>
                                <td><?= e(rupiah($item['price'])) ?></td>

                                <td>
                                    <a
                                        href="<?= e(base_url('items/edit/' . $item['id'])) ?>"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form
                                        action="<?= e(base_url('items/delete/' . $item['id'])) ?>"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalMasuk<?= $item['id'] ?>">
                                        Barang Masuk
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-info"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalKeluar<?= $item['id'] ?>">
                                        Barang Keluar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Navigasi Pagination -->
        <?php if ($totalPages > 1): ?>
            <?php
            $queryParams = [
                'search' => $search,
                'category' => $categoryId,
                'limit' => $limit
            ];
            ?>

            <nav aria-label="Navigasi halaman">
                <ul class="pagination justify-content-center mt-4">

                    <!-- Tombol Sebelumnya -->
                    <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                        <a
                            class="page-link"
                            href="<?= e(base_url('items?' . http_build_query(array_merge($queryParams, ['page' => max(1, $currentPage - 1)])))) ?>">
                            Sebelumnya
                        </a>
                    </li>

                    <!-- Nomor Halaman -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $currentPage === $i ? 'active' : '' ?>">
                            <a
                                class="page-link"
                                href="<?= e(base_url('items?' . http_build_query(array_merge($queryParams, ['page' => $i])))) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Tombol Selanjutnya -->
                    <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                        <a
                            class="page-link"
                            href="<?= e(base_url('items?' . http_build_query(array_merge($queryParams, ['page' => min($totalPages, $currentPage + 1)])))) ?>">
                            Selanjutnya
                        </a>
                    </li>

                </ul>
            </nav>
        <?php endif; ?>

    </div>
</div>

<!-- Modal Barang Masuk dan Barang Keluar -->
<?php foreach ($items as $item): ?>

    <!-- Modal Barang Masuk -->
    <div class="modal fade" id="modalMasuk<?= $item['id'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="<?= e(base_url('transactions/stockIn')) ?>" method="POST">

                    <div class="modal-header">
                        <h5 class="modal-title">Barang Masuk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="item_id" value="<?= e($item['id']) ?>">

                        <p>
                            Nama Barang:
                            <strong><?= e($item['name']) ?></strong>
                        </p>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Barang Masuk</label>
                            <input type="number" name="quantity" class="form-control" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="notes" class="form-control" rows="3"
                                      placeholder="Masukkan catatan transaksi"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            Simpan Barang Masuk
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal Barang Keluar -->
    <div class="modal fade" id="modalKeluar<?= $item['id'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="<?= e(base_url('transactions/stockOut')) ?>" method="POST">

                    <div class="modal-header">
                        <h5 class="modal-title">Barang Keluar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="item_id" value="<?= e($item['id']) ?>">

                        <p>
                            Nama Barang:
                            <strong><?= e($item['name']) ?></strong>
                        </p>

                        <p>
                            Stok Saat Ini:
                            <strong><?= e($item['quantity']) ?> <?= e($item['unit']) ?></strong>
                        </p>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Barang Keluar</label>
                            <input type="number" name="quantity" class="form-control" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="notes" class="form-control" rows="3"
                                      placeholder="Masukkan catatan transaksi"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            Simpan Barang Keluar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>

<a href="<?= e(base_url('/')) ?>" class="btn btn-secondary mt-3">
    Kembali ke Dashboard
</a>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
