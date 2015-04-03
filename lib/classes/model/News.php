<?php
  /**
   * Класс описывает модель новостей
   */

  class News extends Article {
    // Свойсто saved показывает, была ли новость сохранена в БД.
    // По умолчанию новость считается не сохраненной.
    private $saved = false;
    
    // Таблица БД предназначенная для хранения данных данной модели
    private static $dbTable = 'news';


    /*
     * В конструкторе вызываем конструктор родительского класса и 
     * задаем таблицу БД с которой будем работать.
     */
    public function __construct( $content = 'Большой Брат следит за тобой!',
                                 $title   = 'Памятка гражданину Океании',
                                 $author  = 'Министерство Правды',
                                 $date    = null) {
      parent::__construct($content, $title, $author, $date);
    }

    /*
     * Метод пытается сохраняет новость в БД.
     * Возворащает TRUE и устанавливает свойство saved в TRUE в случае успеха;
     * Возвращает FALSE если не удается сохранить новость или новость уже сохранена.
     */
    public function saveRecord() {
      if ($this->saved) {
        return false;
      }
      $db      = new Database(self::$dbTable);
      // Фильтруем значения для запроса.
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
      $db = new Database(self::$dbTable);
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
      $db = new Database(self::$dbTable);
      $allRecords = $db->getAllRecords();
      foreach ($allRecords as $record) {
        $all_news["{$record->id}"] = new News();
        $all_news["{$record->id}"]->loadRecord($record->id);
      }
      if (count($allNews) > 0) {
        return $allNews;
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
      $db = new Database(self::$dbTable);
      $allRecords = $db->getAllRecords();
      foreach ($allRecords as $record) {
        foreach ($record as $property => $value) {
          $item[$property] = $value;
        }
        $allNews[] = $item;
      }
      if (count($allNews) > 0) {
        return $allNews;
      } else {
        return false;
      }
    }    
  }