
<?php

class Logger
{
    private static string $logDir = ROOT_PATH . '/logs/errors';

    // Mencatat error ke dalam file JSON.
    public static function error(string $message, array $context = []): void
    {
        // Membuat folder logs/errors jika belum tersedia.
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0777, true);
        }

        // Menyimpan informasi error ke file JSON.
        file_put_contents(
            self::$logDir . '/error-' . date('YmdHis') . '.json',
            json_encode([
                'timestamp' => date('Y-m-d H:i:s'),
                'message' => $message,
                'context' => $context
            ], JSON_PRETTY_PRINT)
        );
    }
}
