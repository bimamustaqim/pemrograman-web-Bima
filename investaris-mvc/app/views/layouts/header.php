
<?php $flash = take_flash(); ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?= isset($title) ? e($title) . ' - ' : '' ?><?= APP_NAME ?>
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="<?= e(base_url('/')) ?>">
            <?= APP_NAME ?>
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="<?= e(base_url('/')) ?>">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= e(base_url('categories')) ?>">
                        Kategori
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= e(base_url('items')) ?>">
                        Data Barang
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= e(base_url('transactions')) ?>">
                        Riwayat Transaksi
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav">

                <?php if (Middleware::isLoggedIn()): ?>

                    <li class="nav-item">
                        <span class="nav-link">
                            Halo, <?= e($_SESSION['user']['full_name']) ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <form action="<?= e(base_url('auth/logout')) ?>"
                              method="POST">
                            <button type="submit"
                                    class="btn btn-outline-light btn-sm mt-1">
                                Logout
                            </button>
                        </form>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="<?= e(base_url('auth/login')) ?>">
                            Login
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>

<main class="container py-4">

    <?php if ($flash): ?>
        <div class="alert alert-<?= e($flash['type']) ?>">
            <?= e($flash['message']) ?>
        </div>
    <?php endif; ?>
