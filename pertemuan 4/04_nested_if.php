<?php
declare(strict_types=1);

$sudahlogin = true;
$peran = 'admin';

if ($sudahlogin) {
    if ($peran === 'admin') {
        echo "selamat datang, admin. akses penuh.\n";
    } elseif ($peran === 'operator') {
        echo "selamat datang, operator. akses terbatas.\n";
    } else {
        echo "peran tidak dikenal.\n";
    }
} else {
    echo  "silahkan login terlebih dahulu.\n";
}

$terverifikasi = true;
$saldo = 12000;
if ($sudahlogin && $terverifikasi && $saldo >= 10000) {
    echo "transaksi besar diizinkan.\n";
}