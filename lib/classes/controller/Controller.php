<?php
  /**
   * Абстрактнй конроллер
   */

  abstract class Controller {
    protected $view;               // Свойство отвечает за вывод данных
    protected $template;           // Шаблон для вывода

    /*
     * В конструкторе создаем представление
     */
    public function __construct() {
      $this->view = new View();
    }

    /*
     * Метод для выбора дейстия по умолчанию
     */
    public abstract function actionDefault();

  }