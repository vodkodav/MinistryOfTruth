<?php
	/**
	 * Класс отвечает за подключение и работу с БД.
   * По хорошему нужно сделать, чтобы конфиг по умолчанию инклюдился из какого-нибудь файла конфигурации.
	 */

  class Database {
    // Параметры подключения к БД

    // Таблица БД c которой работает объект работает по умолчанию.
    // Если не заданно другое значение, то работает с таблицей news.
    private $table = '';

    // Само подклюение к БД
    private $conn;

    /*
     * Конструктор создает соеденение с БД.
     * В качестве аргументов принимает параметры соеденения,
     * если параметры не заданы, то использует параметры по умолчанию.
     */
    function __construct($table) {
      require_once __DIR__ . '/../config.inc.php';

      $this->conn = mysql_connect(DB_HOST, DB_USER, DB_PASS)
        // Если подключение не удалось, то нет смысла продолжат выполение скрипта
        or die(mysqli_connect_error());

      mysql_select_db(DB_BASE, $this->conn);
      $this->table = $table;
    }

    /*
     * Методом можно переопределить таблицу с которой работает БД
     */
    public function setTable($tableName) {
      $this->table = mysql_real_escape_string($tableName);
    }

    /*
     * Метод экранирует строку для безопасного использования в SQL-запросе.
     * Принимает любое значени и
     * возвращает его в виде строки подготовленно для использования в SQL-запросе.
     */
    public function securedVal($value) {
      return mysql_real_escape_string((string) $value, $this->conn);
    }

    /*
     * Метод служит для выполнения любого запроса к БД.
     * В качестве аргумента принимает SQL-запрос.
     *
     */
    private function query($sql) {
      return false;
      // Пока функция ничего не делает. Заразервировано для будущих нужд.
    }

    /*
     * Метод добавлет новую запись в БД.
     * В качестве аргумента принимает SQL-запрос.
     * Возворщает TRUE в случае успеха или FALSE в случае провала.
     */
    public function addRecord($query) {
      mysql_query($query, $this->conn);
      if (mysql_insert_id($this->conn)) {
        return true;
      } else {
        return false;
      }
    }

    /*
     * Метод обновляет существующую в БД запись.
     * В качестве аргумента принимает SQL-запрос.
     * Возворщает TRUE в случае успеха или FALSE в случае провала.
     */
    public function updateRecord($query) {
      mysql_query($query, $this->conn);
      if (mysql_affected_rows($this->conn) > 0) {
        return true;
      } else {
        return false;
      }
    }

    /*
     * Метод получает одну запись по ее идентифиатору.
     * В качестве аргумнта принимает id записи.
     * Возвращает запись в виде ассоцитивого массива в случе успеха
     * или FALSE в случае провала.
     */
    public function getRecord($id) {
      $id = (int) $id;
      //$record = array();
      $query  = 'SELECT * ';
      $query .= "FROM {$this->table} ";
      $query .= "WHERE id = {$id}";
      $result = mysql_query($query, $this->conn);
      if (mysql_num_rows($result) > 0) {
        $record = mysql_fetch_object($result);
        return $record;
      } else {
        return false;
      }
    }

    /*
     * Метод получает все записи из таблицы с которой работает объект.
     * Если нужно вернуть результат отсортированный в обратном порядке, то в качестве параметра функци передается TRUE.
     * Возращает массив объектов,
     * каждый объект содержит одну строку результата запроса,
     * или false в случае, если не удалось выполнить запрос, либо нет записей.
     *
     * По хорошему надо бы плучать только id записей,
     * а если нужны все записи, то дергать для каждого полученного значения getRecord
     */
    public function getAllRecords($desc = false) {
      $all_records = array();
      $query  = 'SELECT * ';
      $query .= "FROM {$this->table}";
      if ($desc) {
        $query .= ' ORDER BY id DESC';
      }
      $result = mysql_query($query, $this->conn);
      if (mysql_num_rows($result) > 0) {
        while ($record = mysql_fetch_object($result)) {
          $all_records[] = $record;
        }
        return $all_records;
      } else {
        return false;
      }
    }
  }