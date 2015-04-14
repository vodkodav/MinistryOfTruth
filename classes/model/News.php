<?php
  namespace App\Classes\Model;

  class News extends Main {
    // Таблица БД предназначенная для хранения данных данной модели
    protected static $table = 'news';
    
    /*
     * У новостей должны быть заданы автор, заголовок и время
     * Не нравится мне этот метод, нужно переделать. 
     * Возможно стоит добавить класс для валидации данных.
     */
    public function save() {
      if (empty($this->author)) {
        $this->author = 'Министерство Правды';
      }
      if (empty($this->title)) {
        $this->title = 'Объявление';
      }
      $this->date = time();
      parent::save();
    }
  }