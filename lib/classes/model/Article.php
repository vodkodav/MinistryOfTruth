<?php
  /**
   * Класс служит для наследования от него объекто типа Статья.
   */

  abstract class Article {
    // Инициализация свойств
    protected $id;            // id статиь в БД
    protected $author;        // Автор статьи
    protected $title;         // Заголовок статьи
    protected $content;       // Содержание статьи
    protected $date;          // Дата создания статьи

    /*
     * Конструктор задает значения свойств.
     */
    function __construct($content, $title, $author, $date) {
      $this->author = $author;
      $this->title = $title;
      $this->content = $content;
      $this->setDate($date);
    }

    /*
     * Метод возвращает статью в виде ассоцитивного массива
     */
    public function getArticle() {
      foreach ($this as $key => $value) {
        $article[$key] = $value;
      }
      return $article;
    }

    /*
     * Метод задает дату создания статьи.
     * В качетсве аргумента передается необязательный параметр $date в виде unix timestamp.
     * По умолчанию пармеру присваивается текущее дата и время.
     */
    private function setDate($date = null) {
      if ($date) {
        $this->date = $date;
      } else {
        $this->date = time();
      }
    }
  }