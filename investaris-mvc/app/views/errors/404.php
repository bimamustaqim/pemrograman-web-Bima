
<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="container text-center py-5">
    <h1 class="display-1 fw-bold text-danger">404</h1>

    <h2 class="mb-3">Halaman Tidak Ditemukan</h2>

    <p class="text-muted mb-4">
        Maaf, halaman yang kamu cari tidak tersedia
        atau alamat URL yang dimasukkan salah.
    </p>

    <a href="<?= base_url('/') ?>" class="btn btn-primary">
        Kembali ke Dashboard
    </a>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
