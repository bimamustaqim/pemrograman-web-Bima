
<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="p-4 mb-4 bg-white rounded shadow-sm">
    <h1 class="h3">Dashboard Inventaris</h1>
    <p class="text-muted">
        Selamat datang di Aplikasi Sistem Inventaris Barang.
    </p>
</div>

<div class="row g-3 mb-4">

    <!-- Total Barang -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Barang</h6>
                <h2 class="fw-bold">
                    <?= e($totalBarang) ?>
                </h2>
            </div>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Kategori</h6>
                <h2 class="fw-bold">
                    <?= e($totalKategori) ?>
                </h2>
            </div>
        </div>
    </div>

    <!-- Total Stok -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Stok</h6>
                <h2 class="fw-bold">
                    <?= e($totalStok) ?>
                </h2>
            </div>
        </div>
    </div>

    <!-- Total Transaksi -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Transaksi</h6>
                <h2 class="fw-bold">
                    <?= e($totalTransaksi) ?>
                </h2>
            </div>
        </div>
    </div>

</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
