
<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h3 class="text-center mb-2">
                        Login
                    </h3>

                    <p class="text-center text-muted mb-4">
                        Sistem Inventaris Barang
                    </p>

                    <form action="<?= e(base_url('auth/authenticate')) ?>"
                          method="POST">

                        <div class="mb-3">
                            <label class="form-label">
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                placeholder="Masukkan username"
                                required
                                autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required>
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Login
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
