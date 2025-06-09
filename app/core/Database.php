<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $dbh;
    private $stmt;
    private $error;

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Database Connection Error: " . $this->error);
            throw new Exception("Nie można połączyć się z bazą danych");
        }
    }

    public function query($sql) {
        try {
            $this->stmt = $this->dbh->prepare($sql);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Query Preparation Error: " . $this->error . " in query: " . $sql);
            throw new Exception("Błąd przygotowania zapytania");
        }
    }

    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        try {
            $this->stmt->bindValue($param, $value, $type);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Parameter Binding Error: " . $this->error);
            throw new Exception("Błąd wiązania parametrów");
        }
    }

    public function execute() {
        try {
            return $this->stmt->execute();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Query Execution Error: " . $this->error);
            throw new Exception("Błąd wykonania zapytania");
        }
    }

    public function resultSet() {
        try {
            $this->execute();
            return $this->stmt->fetchAll();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Result Set Error: " . $this->error);
            throw new Exception("Błąd pobierania wyników");
        }
    }

    public function single() {
        try {
            $this->execute();
            return $this->stmt->fetch();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Single Result Error: " . $this->error);
            throw new Exception("Błąd pobierania wyniku");
        }
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }

    public function commit() {
        return $this->dbh->commit();
    }

    public function rollBack() {
        return $this->dbh->rollBack();
    }

    public function getAll($table) {
        $this->query("SELECT * FROM {$table} ORDER BY id DESC");
        return $this->resultSet();
    }

    public function getById($table, $id) {
        $this->query("SELECT * FROM {$table} WHERE id = :id");
        $this->bind(':id', $id);
        return $this->single();
    }

    public function insert($table, $data) {
        $fields = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        
        $this->query("INSERT INTO {$table} ({$fields}) VALUES ({$values})");
        
        foreach($data as $key => $value) {
            $this->bind(':' . $key, $value);
        }
        
        try {
            return $this->execute();
        } catch(Exception $e) {
            return false;
        }
    }

    public function update($table, $id, $data) {
        $fields = '';
        foreach($data as $key => $value) {
            $fields .= "{$key} = :{$key}, ";
        }
        $fields = rtrim($fields, ', ');
        
        $this->query("UPDATE {$table} SET {$fields} WHERE id = :id");
        
        foreach($data as $key => $value) {
            $this->bind(':' . $key, $value);
        }
        $this->bind(':id', $id);
        
        try {
            return $this->execute();
        } catch(Exception $e) {
            return false;
        }
    }

    public function delete($table, $id) {
        $this->query("DELETE FROM {$table} WHERE id = :id");
        $this->bind(':id', $id);
        
        try {
            return $this->execute();
        } catch(Exception $e) {
            return false;
        }
    }

    public function count($table, $where = '') {
        $sql = "SELECT COUNT(*) as count FROM {$table}";
        if($where) {
            $sql .= " WHERE {$where}";
        }
        
        $this->query($sql);
        $result = $this->single();
        return $result->count;
    }

    public function search($table, $field, $value) {
        $this->query("SELECT * FROM {$table} WHERE {$field} LIKE :value");
        $this->bind(':value', '%' . $value . '%');
        return $this->resultSet();
    }
} 