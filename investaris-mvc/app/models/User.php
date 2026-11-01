
<?php

class User extends Model
{
    protected string $table = 'users';

    // Mencari pengguna berdasarkan username.
    public function findByUsername(string $username): array|false
    {
        $sql = "SELECT * FROM users
                WHERE username = :username
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'username' => $username
        ]);

        return $stmt->fetch();
    }

    // Memeriksa username dan password pengguna.
    public function login(string $username, string $password): array|false
    {
        $user = $this->findByUsername($username);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Jangan menyimpan password ke dalam session.
        unset($user['password']);

        return $user;
    }
}
