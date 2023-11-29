<?php

namespace Model;

use DotEnv;

class Database {

  private DotEnv $dotenv;
  private $host;
  private $user;
  private $pass;
  private $db_name;
  public $conn = null;

  public function __construct() {
    $this->dotenv = new DotEnv(APP_ROOT . DIRECTORY_SEPARATOR . '.env');
    $this->dotenv->load();
    $this->host = \getenv('HOST');
    $this->user = \getenv('USER');
    $this->pass = \getenv('PASS');
    $this->db_name = \getenv('DB_NAME');
    $this->connect();
  }

  public function connect() {
    $this->conn = new \mysqli($this->host, $this->user, $this->pass, $this->db_name);
    if ($this->conn->connect_error) {
      die('Error de conexión: ' . $this->conn->connect_error);
    }
    return $this->conn;
  }

  public function exeQuery($sql, $data) {
    $stmt = $this->conn->prepare($sql);
    $valores = array_values($data);
    $tipo = str_repeat('s', count($valores));
    $stmt->bind_param($tipo, ...$valores);
    $stmt->execute();
    return $stmt;
  }

  public function selectAll($cols, $table, $data = []) {
    $sql = "SELECT ";
    $i = 0;
    foreach ($cols as $key => $value) {
      if ($i === 0) {
        $sql = $sql . " $value";
      } else {
        $sql = $sql . " , $value";
      }
      $i++;
    }
    $sql = $sql . " FROM $table";
    if (empty($data)) {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      return $records;
    } else {
      $i = 0;
      foreach ($data as $key => $value) {
        if ($i === 0) {
          $sql = $sql . " WHERE $key=?";
        } else {
          $sql = $sql . " AND $key=?";
        }
        $i++;
      }
      $stmt = $this->exeQuery($sql, $data);
      $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      return $records;
    }
  }

  public function selectAllJoin($tables_cols,$join, $data = []){
    $sql = "SELECT ";
    $i = 0;
    foreach ($tables_cols as $key => $value){
      if ($i === 0){
        $sql = $sql . " $key.$value";
      } else {
        $sql = $sql . " , $key.$value";
      }
      $i++;
    }
    $sql = $sql . " FROM";
    $i = 0;
    foreach ($join as $key => $value){
      if ($i === 0){
        $sql = $sql . " $key JOIN";
      } else {
        $sql = $sql . " $key";
      }
      $i++;
    }
    $sql = $sql . " ON";
    $i = 0;
    foreach ($join as $key => $value){
      if ($i === 0){
        $sql = $sql . " $key.$value=";
      } else {
        $sql = $sql . "$key.$value";
      }
      $i++;
    }
    if (empty($data)) {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      return $records;
    } else {
      $i = 0;
      foreach ($data as $key => $value){
        if ($i === 0){
          $sql = $sql . " WHERE $key=?";
        } else {
          $sql = $sql . " AND $key=?";
        }
        $i++;
      }
      $stmt = $this->exeQuery($sql, $data);
      $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      return $records;
    }
  }

  public function selectOne($cols, $table, $data) {
    $sql = "SELECT ";
    $i = 0;
    if ($cols == 'all') {
      $sql = $sql . " *";
    } else {
      foreach ($cols as $key => $value) {
        if ($i === 0) {
          $sql = $sql . " $value";
        } else {
          $sql = $sql . " , $value";
        }
        $i++;
      }
    }
    $sql = $sql . " FROM $table";
    $i = 0;
    foreach ($data as $key => $value) {
      if ($i === 0) {
        $sql = $sql . " WHERE $key=?";
      } else {
        $sql = $sql . " AND $key=?";
      }
      $i++;
    }
    $sql = $sql . " LIMIT 1";
    $stmt = $this->exeQuery($sql, $data);
    $records = $stmt->get_result()->fetch_assoc();
    return $records;
  }

  function create($table, $data) {
    $sql = "INSERT INTO $table SET ";
    $i = 0;
    foreach ($data as $key => $value) {
      if ($i === 0) {
        $sql = $sql . " $key=?";
      } else {
        $sql = $sql . ", $key=?";
      }
      $i++;
    }
    $stmt = $this->exeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
  }

  public function update($table, $context, $id, $data) {
    $sql = "UPDATE $table SET ";
    $i = 0;
    foreach ($data as $key => $value) {
      if ($i === 0) {
        $sql = $sql . " $key=?";
      } else {
        $sql = $sql . ", $key=?";
      }
      $i++;
    }
    $sql = $sql . " WHERE $context=?";
    $data[$context] = $id;
    $stmt = $this->exeQuery($sql, $data);
    return $stmt->affected_rows;
  }
  

  public function delete($table, $id) {
    foreach ($id as $key => $value) {
      $sql = "DELETE FROM $table WHERE $key=?";
    }
    $stmt = $this->exeQuery($sql, $id);
    return $stmt->affected_rows;
  }

  public function __destruct() {
    mysqli_close($this->conn);
  }
}