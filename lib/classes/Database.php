<?php
	/**
	 * Класс отвечает за подключение и работу с БД.
	 */

  class Database {
    // Само подклюение к БД
    private $dbh;
    
    // Тип возвращаемого объекта
    private $className = 'stdObject';

    /*
     * Конструктор создает соеденение с БД.
     */
    function __construct() {
      require_once __DIR__ . '/../config.inc.php';
      $this->dbh = new PDO( 'mysql:dbname=' . DB_BASE . ';host=' . DB_HOST, 
                            DB_USER, 
                            DB_PASS );
    }
    
    public function setClassName($name) {
      $this->className = $name;
    }

    public function query($sql, $params = array()) {
      $sth = $this->dbh->prepare($sql);
      $sth->execute($params);
      return $sth->fetchAll(PDO::FETCH_CLASS, $this->className); 
    }
    
    public function exec($sql, $params = array()) {
      $sth = $this->dbh->prepare($sql);
      if ($sth->execute($params)) {
        if ($id = $this->dbh->lastInsertId()) {
          return $id;
        } else {
          return true;
        }
      } else {
        return false;
      }
    }
    
//    /*
//     * Метод добавлет новую запись в БД.
//     * В качестве аргумента принимает SQL-запрос.
//     * Возворщает TRUE в случае успеха или FALSE в случае провала.
//     */
//    public function addRecord($query) {
//      mysql_query($query, $this->conn);
//      if (mysql_insert_id($this->conn)) {
//        return true;
//      } else {
//        return false;
//      }
//    }
//
//    /*
//     * Метод обновляет существующую в БД запись.
//     * В качестве аргумента принимает SQL-запрос.
//     * Возворщает TRUE в случае успеха или FALSE в случае провала.
//     */
//    public function updateRecord($query) {
//      mysql_query($query, $this->conn);
//      if (mysql_affected_rows($this->conn) > 0) {
//        return true;
//      } else {
//        return false;
//      }
//    }
//
//    /*
//     * Метод получает одну запись по ее идентифиатору.
//     * В качестве аргумнта принимает id записи.
//     * Возвращает запись в виде ассоцитивого массива в случе успеха
//     * или FALSE в случае провала.
//     */
//    public function getRecord($id) {
//      $id = (int) $id;
//      //$record = array();
//      $query  = 'SELECT * ';
//      $query .= "FROM {$this->table} ";
//      $query .= "WHERE id = {$id}";
//      $result = mysql_query($query, $this->conn);
//      if (mysql_num_rows($result) > 0) {
//        $record = mysql_fetch_object($result);
//        return $record;
//      } else {
//        return false;
//      }
//    }
//
//    /*
//     * Метод получает все записи из таблицы с которой работает объект.
//     * Если нужно вернуть результат отсортированный в обратном порядке, то в качестве параметра функци передается TRUE.
//     * Возращает массив объектов,
//     * каждый объект содержит одну строку результата запроса,
//     * или false в случае, если не удалось выполнить запрос, либо нет записей.
//     *
//     * По хорошему надо бы плучать только id записей,
//     * а если нужны все записи, то дергать для каждого полученного значения getRecord
//     */
//    public function getAllRecords($desc = false) {
//      $all_records = array();
//      $query  = 'SELECT * ';
//      $query .= "FROM {$this->table}";
//      if ($desc) {
//        $query .= ' ORDER BY id DESC';
//      }
//      $result = mysql_query($query, $this->conn);
//      if (mysql_num_rows($result) > 0) {
//        while ($record = mysql_fetch_object($result)) {
//          $all_records[] = $record;
//        }
//        return $all_records;
//      } else {
//        return false;
//      }
//    }
  }