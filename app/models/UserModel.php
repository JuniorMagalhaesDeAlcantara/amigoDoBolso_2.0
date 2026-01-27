<?php

class UserModel extends Model
{
    protected $table = 'users';

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function register($name, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $this->create([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    public function verifyPassword($email, $password)
    {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function getUserGroups($userId)
    {
        $sql = "SELECT g.* FROM `groups` g
            INNER JOIN group_members gm ON g.id = gm.group_id
            WHERE gm.user_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getAll()
    {
        $sql = "SELECT id, name, email, created_at FROM {$this->table} ORDER BY name ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca usuário por ID
     */
    public function getById($id)
    {
        $sql = "SELECT id, name, email, created_at, updated_at 
                FROM {$this->table} 
                WHERE id = :id 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Busca usuário por email
     */
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE email = :email 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cria um token de recuperação de senha
     */
    public function createPasswordResetToken($userId, $token, $expiry)
    {
        try {
            // Remove tokens antigos do usuário
            $sql = "DELETE FROM password_resets WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);

            // Cria novo token
            $sql = "INSERT INTO password_resets (user_id, token, expires_at, created_at) 
                    VALUES (:user_id, :token, :expires_at, NOW())";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'user_id' => $userId,
                'token' => $token,
                'expires_at' => $expiry
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao criar token de recuperação: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Valida um token de recuperação de senha
     */
    /**
     * Valida um token de recuperação de senha
     */
    public function validatePasswordResetToken($token)
    {
        try {
            // Limpa tokens expirados antes de validar
            $this->cleanExpiredTokens();

            $sql = "SELECT pr.*, u.email, u.name 
                FROM password_resets pr
                INNER JOIN users u ON pr.user_id = u.id
                WHERE pr.token = :token 
                AND pr.expires_at > NOW()
                AND pr.used_at IS NULL
                LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['token' => $token]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                error_log("Token inválido ou expirado: " . substr($token, 0, 10) . "...");
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao validar token: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Atualiza a senha do usuário
     */
    public function updatePassword($userId, $hashedPassword)
    {
        try {
            $sql = "UPDATE {$this->table} 
                    SET password = :password, 
                        updated_at = NOW() 
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'password' => $hashedPassword,
                'id' => $userId
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar senha: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Marca um token como usado
     */
    public function deletePasswordResetToken($token)
    {
        try {
            $sql = "UPDATE password_resets 
                    SET used_at = NOW() 
                    WHERE token = :token";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['token' => $token]);
        } catch (PDOException $e) {
            error_log("Erro ao deletar token: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove tokens expirados (pode ser executado periodicamente)
     */
    public function cleanExpiredTokens()
    {
        try {
            $sql = "DELETE FROM password_resets 
                    WHERE expires_at < NOW() 
                    OR used_at IS NOT NULL";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao limpar tokens expirados: " . $e->getMessage());
            return false;
        }
    }
}
