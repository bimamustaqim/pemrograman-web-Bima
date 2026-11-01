
<?php

class Item extends Model
{
    protected string $table = 'items';

    // Mengambil semua barang beserta nama kategorinya.
    public function all(): array
    {
        $sql = "SELECT i.*, c.name AS category_name
                FROM items i
                LEFT JOIN categories c ON c.id = i.category_id
                ORDER BY i.name ASC";

        return $this->db->query($sql)->fetchAll();
    }

    // Mengambil data barang dengan paginasi, pencarian, dan filter.
    public function paginate(
        int $limit = 10,
        int $page = 1,
        string $search = '',
        string $categoryId = ''
    ): array {
        $offset = ($page - 1) * $limit;

        $where = [];
        $params = [];

        // Pencarian berdasarkan kode, nama barang, atau kategori.
        if ($search !== '') {
            $where[] = "(i.code LIKE :search
                         OR i.name LIKE :search
                         OR c.name LIKE :search)";

            $params['search'] = '%' . $search . '%';
        }

        // Filter berdasarkan kategori.
        if ($categoryId !== '') {
            $where[] = "i.category_id = :category_id";
            $params['category_id'] = (int) $categoryId;
        }

        $whereSql = $where
            ? 'WHERE ' . implode(' AND ', $where)
            : '';

        // Menghitung jumlah seluruh data sesuai filter.
        $count = $this->db->prepare(
            "SELECT COUNT(*)
             FROM items i
             LEFT JOIN categories c ON i.category_id = c.id
             {$whereSql}"
        );

        $count->execute($params);
        $total = (int) $count->fetchColumn();

        // Mengambil data sesuai halaman.
        $stmt = $this->db->prepare(
            "SELECT i.*, c.name AS category_name
             FROM items i
             LEFT JOIN categories c ON i.category_id = c.id
             {$whereSql}
             ORDER BY i.id DESC
             LIMIT {$limit} OFFSET {$offset}"
        );

        $stmt->execute($params);

        return [
            'data' => $stmt->fetchAll(),
            'current_page' => $page,
            'total_pages' => (int) ceil($total / max($limit, 1)),
            'total_data' => $total
        ];
    }

    // Menambahkan barang baru.
    public function create(array $data): bool
    {
        $sql = "INSERT INTO items
                (code, name, category_id, quantity, unit, price,
                 entry_date, description)
                VALUES
                (:code, :name, :category_id, :quantity, :unit, :price,
                 :entry_date, :description)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'code' => $data['code'],
            'name' => $data['name'],
            'category_id' => $data['category_id'] ?: null,
            'quantity' => $data['quantity'],
            'unit' => $data['unit'],
            'price' => $data['price'],
            'entry_date' => $data['entry_date'] ?: null,
            'description' => $data['description'] ?: null,
        ]);
    }

    // Memperbarui data barang.
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE items SET
                    code = :code,
                    name = :name,
                    category_id = :category_id,
                    quantity = :quantity,
                    unit = :unit,
                    price = :price,
                    entry_date = :entry_date,
                    description = :description
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'code' => $data['code'],
            'name' => $data['name'],
            'category_id' => $data['category_id'] ?: null,
            'quantity' => $data['quantity'],
            'unit' => $data['unit'],
            'price' => $data['price'],
            'entry_date' => $data['entry_date'] ?: null,
            'description' => $data['description'] ?: null,
        ]);
    }
}
