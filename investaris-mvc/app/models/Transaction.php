
<?php

class Transaction extends Model
{
    protected string $table = 'transactions';

    // Menyimpan transaksi dan memperbarui stok barang.
    public function create(array $data): bool
    {
        try {
            // Memulai transaksi database.
            $this->db->beginTransaction();

            // Mencatat transaksi masuk atau keluar.
            $sql = "INSERT INTO transactions
                    (item_id, user_id, type, quantity, notes)
                    VALUES
                    (:item_id, :user_id, :type, :quantity, :notes)";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                'item_id' => $data['item_id'],
                'user_id' => $data['user_id'],
                'type' => $data['type'],
                'quantity' => $data['quantity'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Menentukan apakah stok ditambah atau dikurangi.
            $operator = ($data['type'] === 'IN') ? '+' : '-';

            $sql = "UPDATE items
                    SET quantity = quantity {$operator} :quantity
                    WHERE id = :item_id";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                'quantity' => $data['quantity'],
                'item_id' => $data['item_id'],
            ]);

            // Memeriksa stok setelah perubahan.
            $stmt = $this->db->prepare(
                "SELECT quantity FROM items WHERE id = :item_id"
            );

            $stmt->execute([
                'item_id' => $data['item_id'],
            ]);

            $stok = $stmt->fetchColumn();

            // Jika stok negatif, batalkan seluruh transaksi.
            if ($stok === false || (int) $stok < 0) {
                $this->db->rollBack();
                return false;
            }

            // Menyimpan seluruh perubahan.
            $this->db->commit();

            return true;

        } catch (PDOException $e) {
            // Membatalkan perubahan jika terjadi kesalahan.
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }
}
