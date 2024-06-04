<?php

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Метод регистрации пользователя
    public function register($email, $password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        return $this->db->insert('users', [
            'login' => $email,
            'pass' => $hashed_password
        ]);
    }

    // Метод входа в систему
    public function login($login, $password) {
        $user = $this->db->query('SELECT * FROM users WHERE login = :login', ['login' => $login]);

        if ($user && password_verify($password, $user[0]['pass'])) {
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['login'] = $user[0]['login'];
            return true;
        }

        return false;
    }

    // Метод проверки, авторизован ли пользователь
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Метод выхода из системы
    public function logout() {
        session_unset();
        session_destroy();
    }

    // Метод получения текущего пользователя
    public function getUser() {
        if ($this->isLoggedIn()) {
            return [
                'user_id' => $_SESSION['user_id'],
                'login' => $_SESSION['login']
            ];
        }

        return null;
    }
}
?>
