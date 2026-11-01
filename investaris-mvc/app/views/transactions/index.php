
<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3">Riwayat Transaksi</h1>
        <p class="text-muted">
            Daftar seluruh transaksi barang masuk dan keluar.
        </p>
    </div>

    <a href="<?= e(base_url('items')) ?>"
       class="btn btn-secondary">
        Kembali ke Barang
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Barang</th>
                        <th>ID Pengguna</th>
                        <th>Jenis Transaksi</th>
                        <th>Jumlah</th>
                        <th>Catatan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($transactions)): ?>

                        <tr>
                            <td colspan="7"
                                class="text-center text-muted py-4">
                                Belum ada riwayat transaksi.
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php foreach ($transactions as $index => $transaction): ?>

                            <tr>
                                <td><?= $index + 1 ?></td>

                                <td>
                                    <?= e($transaction['item_id']) ?>
                                </td>

                                <td>
                                    <?= e($transaction['user_id']) ?>
                                </td>

                                <td>
                                    <?php if ($transaction['type'] === 'IN'): ?>

                                        <span class="badge bg-success">
                                            Barang Masuk
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-danger">
                                            Barang Keluar
                                        </span>

                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?= e($transaction['quantity']) ?>
                                </td>

                                <td>
                                    <?= e($transaction['notes'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= e($transaction['created_at'] ?? '-') ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
