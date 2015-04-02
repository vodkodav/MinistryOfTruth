<?php
  /**
   * Класс для вывода данных
   */

  class View  {
    // Пути к шаблоном для вывода данных
    private $header;
    private $body;
    private $footer;

    // Контент для вывода
    private $display_content;

    /*
     * Конструктором задаем значения по умолчанию
     */
    public function __construct() {
      $this->header = __DIR__ . '/../../../view/header.inc.php';
      //$this->setBody($body);
      $this->footer = __DIR__ . '/../../../view/footer.inc.php';
      //$this->display_content = $display_content;
    }

    /*
     * Метод задает значение body.
     * В качетве аргумента принимает путь к файлу-шаблону.
     * Если путь существует, утанавливает путь свойству body и возращает TRUE, иначе возвращает FALSE
     */
    private function setBody($path) {
      if (file_exists($path)) {
        $this->body = $path;
        return true;
      } else {
        return false;
      }
    }

    /*
     * Метод задает контент для отображения.
     * В качестве аргументов принимает адрес шаблона и данные для заполнения шаблона.
     * На случай, если шаблону не требуется данные, парметр display_content - не обязательный.
     * Возвращает TRUE в случае успеха или FALSE в случае провала.
     */
    public function setContent($template, $display_content = null) {
      if ($this->setBody($template)) {
        $this->display_content = $display_content;
        return true;
      } else {
        return false;
      }

    }
    /*
     * Метод выводит данные в браузер.
     *
     */
    public function display() {
      if ($this->body) {
        include $this->header;
        include $this->body;
        include $this->footer;
        return true;
      } else {
        return false;
      }
    }
  }