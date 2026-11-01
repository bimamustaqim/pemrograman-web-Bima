
<?php

class Category extends Model
{
    protected string $table = 'categories';

    public function all(): array
    {
        $sql = "SELECT c.*,
                (SELECT COUNT(*)
                 FROM items i
                 WHERE i.category_id = c.id) AS item_count
                FROM categories c
                ORDER BY c.name ASC";

        return $this->db->query($sql)->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO categories (name, description)
                VALUES (:name, :description)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'] ?? null
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE categories
                SET name = :name, description = :description
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null
        ]);
    }
}
