<?php
  namespace App\Classes\Model;
  use App\Classes\Database as Database;

  abstract class Main implements \Iterator{
    // Массив содержит свойства объекта
    protected $fields = array();
    
    // Таблица БД содержащая данные модели
    protected static $table = '';

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
//      $allRecods = $db->query($sql);
//      if (!$allRecods) {
//        throw new E404Ecxeption('Не удается получить список новостей.');
//      }
      return $db->query($sql);
    }
 
    public static function findById($id) {
      $db = new Database;
      $db->setClassName(get_called_class());
      $sql = 'SELECT * FROM ' . static::$table . ' WHERE id=:id';
      $params[':id'] = $id;
//      $record = $db->query($sql, $params)[0];
//      if (!$record) {
//        throw new E404Ecxeption('Не удается найти новость.');
//      }
      return $db->query($sql, $params)[0];
    }
    
    public static function findByColumn($column, $value) {
      $db = new Database;
      $db->setClassName(get_called_class());
      $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $column . ' = :'. $column;
      $params[":{$column}"] = $value;
//      $record = $db->query($sql, $params);
//      if (!$record) {
//        throw new E404Ecxeption('Не удается найти новость.');
//      }
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
        //echo $name, '<br>';
        if ('id' == $name) {
          continue;
        }
        $names[] = $name;
        $params[":{$name}"] = $value;
      }
      $sql  = 'UPDATE ' . static::$table . ' SET ';
      while ($name = array_shift($names)) {
        $sql .= $name . ' = :' . $name;
        $sql .= ($names) ? ', ' : ' ' ;
      }
      $sql .= 'WHERE id = ' . $this->id;
      $this->id = $db->exec($sql, $params);
    }
    
    public function delete() {
      $db = new Database;
      $sql = 'DELETE FROM ' . static::$table . ' WHERE id = :id';
      $params[':id'] = $this->id;
      $db->exec($sql, $params);
    }
    
    public function save() {
      if (isset($this->id)) {
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