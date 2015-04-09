<?php
  /**
   * Класс описывает абстрактную модель данных нашего сайта.
   */

  abstract class AbstractModel implements Iterator{
//    // Инициализация свойств
//    protected $id;            // id статиь в БД
//    protected $author;        // Автор статьи
//    protected $title;         // Заголовок статьи
//    protected $content;       // Содержание статьи
//    protected $date;          // Дата создания статьи

    // Массив содержит свойства объекта
    protected $fields = array();
    
    // Таблица БД содержащая данные модели
    protected static $table = '';

    /*
     * Геттер и сеттер для неопределенных свойств объекта
     */
    public function __set($name, $value) {
      $this->fields["{$name}"] = $value;
    }
    
    public function __get($name) {
      return $this->fields["{$name}"];
    }
    
    public function __isset($name) {
      return isset($this->fields["{$name}"]);
    }

    public function edit($name, $value) {
      if (isset($this->fields["{$name}"])) {
        $this->fields["{$name}"] = $value;
        return true;
      } else {
        return false;
      }
    }
    
    public static function findAll() {
      $db = new Database;
      $db->setClassName(get_called_class());
      $sql = 'SELECT * FROM ' . static::$table;
      return $db->query($sql);
    }
 
    public static function findById($id) {
      $db = new Database;
      $db->setClassName(get_called_class());
      $sql = 'SELECT * FROM ' . static::$table . ' WHERE id=:id';
      $params[':id'] = $id; 
      return $db->query($sql, $params)[0];
    }
    
    public static function findByColumn($column, $value) {
      $db = new Database;
      $db->setClassName(get_called_class());
      $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $column . ' = :'. $column;
      $params[":{$column}"] = $value;
      return $db->query($sql, $params);
    }
    
    protected function insert() {
      $db = new Database;
      $names = array();
      $params = array();
      foreach ($this->fields as $name => $value) {
        $names[":{$name}"] = $name;
        $params[":{$name}"] = $value;
      }
      $db->setClassName(get_called_class());
      $sql  = 'INSERT '; 
      $sql .= 'INTO ' . static::$table . ' (' . implode(', ', $names) . ') ';
      $sql .= 'VALUES (' . implode(', ', array_keys($names)) . ')';
      if ($this->id = $db->exec($sql, $params)) {
        return true;
      } else {
        return false;
      }
    }
    
    protected function update() {
      $db = new Database;
      $names = array();
      $params = array();
      foreach ($this->fields as $name => $value) {
        $names[] = $name;
        $params[":{$name}"] = $value;
      }
      $sql  = 'UPDATE ' . static::$table . ' SET ';
      while ($name = array_shift($names)) {
        $sql .= $name . ' = :' . $name;
        $sql .= ($names) ? ', ' : ' ' ;
      }
      $sql .= 'WHERE id = ' . $params[':id'];
      $this->id = $db->exec($sql, $params);
    }
    
    public function delete() {
      $db = new Database;
      $sql = 'DELETE FROM ' . static::$table . ' WHERE id = :id';
      $params[':id'] = $this->fields['id'];
      $db->exec($sql, $params);
    }
    
    public function save() {
      if (isset($this->fields['id'])) {
        //die('update');
        $this->update();
      } else {
        //die('insert');
        $this->insert();
      }
    }
    
    // Реализация методов интерфейса Iterator
    public function current() {
      return current($this->fields);
    }

    public function key() {
      return key($this->fields);
    }

    public function next() {
      return next($this->fields);
    }

    public function rewind() {
      return reset($this->fields);
    }

    public function valid() {
      return isset($this->fields[$this->key()]);
    }
    
  }