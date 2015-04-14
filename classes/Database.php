<?php
	namespace App\Classes;
  use \PDO as PDO;

  class Database {
    // Само подклюение к БД
    private $dbh;
    
    // Тип возвращаемого объекта
    private $className = 'stdObject';

    /*
     * Конструктор создает соеденение с БД.
     */
    function __construct() {
      require_once __DIR__ . '/../lib/config.inc.php';
      try {
         $this->dbh = new PDO( 'mysql:dbname=' . DB_BASE . ';host=' . DB_HOST, DB_USER, DB_PASS );
         $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        $event = new Logger($e);
        //debug($event);
        $event->save();
        throw new E403Exception('Ошибка соединения с базой данных.');
      }
    }
    
    public function setClassName($name) {
      $this->className = $name;
    }

    public function query($sql, $params = array()) {
      try {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params); 
      } catch (PDOException $e) {
        $event = new Logger();
        $event->addEvent($e);
        throw new E403Exception('Ошибка выполнения запроса к базе данных');
      }
      return $sth->fetchAll(PDO::FETCH_CLASS, $this->className); 
    }
    
    public function exec($sql, $params = array()) {
      try {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);
      } catch (PDOException $e) {
        $event = new Logger();
        $event->addEvent($e);
        throw new E403Exception('Ошибка выполнения запроса к базе данных');
      }
      if ($id = $this->dbh->lastInsertId()) {
        return $id;
      } else {
        return true;
      }
    }
  }