<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'diploma_php';
    private $username = 'diplom_user';
    private $password = '123456789Qwer1';
    private $conn;

    public function __construct() {
        $this->connect();
    }

    // Метод для установки соединения с базой данных
    private function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

    // Метод для выполнения запросов SELECT
    public function query($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Метод для выполнения INSERT, UPDATE, DELETE запросов
    public function execute($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        return $stmt->execute();
    }

    // Метод для вставки записи
    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->execute($query, $data);
    }

    // Метод для обновления записи
    public function update($table, $data, $where) {
        $columns = "";
        foreach ($data as $key => $value) {
            $columns .= "$key = :$key, ";
        }
        $columns = rtrim($columns, ", ");
        $query = "UPDATE $table SET $columns WHERE $where";
        return $this->execute($query, $data);
    }

    // Метод для удаления записи
    public function delete($table, $where) {
        $query = "DELETE FROM $table";
        if(count($where) >= 1) {
            $where_str = '';
            foreach ($where as $key => $value) {
                $where_str .= $key . '=' . $value . ' AND ';
            }
            $where_str = rtrim($where_str, ' AND ');
            $query .= " WHERE $where_str";
        }
        return $this->execute($query);
    }

    // Метод для выборки записей по условию
    public function selectWhere($table, $columns, $where) {
        if(count($columns) >= 1)
            $columns_str = implode(", ", $columns);
        else
            $columns_str = '*';
        $query = "SELECT $columns_str FROM $table";
        if(count($where) >= 1) {
            $where_str = '';
            foreach ($where as $key => $value) {
                $where_str .= $key . '=' . $value . ' AND ';
            }
            $where_str = rtrim($where_str, ' AND ');
            $query .= " WHERE $where_str";
        }
        return $this->query($query);
    }
}
?>
