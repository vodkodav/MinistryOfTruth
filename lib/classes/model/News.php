<?php
  /**
   * Класс описывает объект типа "Новость",
   * расширяет класс Статьи.
   */

  class News extends Article {
    // К свойствам Статей добавляем идентификатор новости
    private $id;

    // Свойсто saved показывает, была ли новость сохранена в БД.
    // По умолчанию новость считается не сохраненной.
    private $saved = false;

    /*
     * Метод пытается сохраняет новость в БД.
     * Возворащает TRUE и устанавливает свойство saved в TRUE в случае успеха;
     * Возвращает FALSE если не удается сохранить новость или новость уже сохранена.
     */
    public function saveRecord() {
      if ($this->saved) {
        return false;
      }
      $db      = new Database();
      // Фильтруем значения для запроса.
      // По хорошему, знчения должны фильтроваться в классе Database.
      $date    = (int) $this->date;
      $title   = $db->securedVal($this->title);
      $author  = $db->securedVal($this->author);
      $content = $db->securedVal($this->content);
      $query  = 'INSERT ';
      $query .= 'INTO news (date, title, author, content) ';
      $query .= "VALUES ({$date}, '{$title}', '{$author}', '{$content}')";
      if ($db->addRecord($query)) {
        $this->saved = true;
        return true;
      } else {
       return false;
      }
    }

    /*
     * Метод получает новость из БД по идентификатору.
     * В качестве аргумента метод принимает идентификатор новости.
     * Возвращает стандартный объект в случае успеха, либо FALSE в случае провала.
     */
    private function getRecord($id) {
      $db = new Database();
      if ($record = $db->getRecord($id)) {
        return $record;
      } else {
        return false;
      }
    }

    /*
     * Метод пытается получить новость из БД по идентификатору и
     * и присвоить полученные данные текущему объекту.
     * Принимает id новости.
     * Возвращает TRUE и устанавливает saved в TRUE в случае успеха;
     * либо возвращает FALSE в случае провала.
     */
    public function loadRecord($id) {
      if ($record = $this->getRecord($id)) {
        foreach ($record as $field => $value) {
          $this->$field = $value;
        }
        $this->saved = true;
        return true;
      } else {
        return false;
      }
    }

    /*
     * Метод возращает все созданные новости в виде массива стандартнх объектов.
     * Метод получает из бд все новости и создавать новый объект типа News для каждой полученной новости.
     * В случае неудачи возвращает FALSE.
     */
    public static function loadAllRecords() {
      $db = new Database();
      $all_records = $db->getAllRecords();
      foreach ($all_records as $record) {
        $all_news["{$record->id}"] = new News();
        $all_news["{$record->id}"]->loadRecord($record->id);
      }
      if (count($all_news) > 0) {
        return $all_news;
      } else {
        return false;
      }
    }
    
    /*
     * Метод возращает все созданные новости в виде массива ассоциативных массивов.
     * Метод получает из бд все новости и помещает каждую новость в новый элемент массива.
     * В случае неудачи возвращает FALSE.
     */
    public static function getAllRecords() {
      $db = new Database();
      $all_records = $db->getAllRecords();
      foreach ($all_records as $record) {
        foreach ($record as $property => $value) {
          $item[$property] = $value;
        }
        $all_news[] = $item;
      }
      if (count($all_news) > 0) {
        return $all_news;
      } else {
        return false;
      }
    }    
  }