<?php
  /**
   * Класс отвечает за представление данных
   */

  class View  {
    // Путь к шаблонам
    private $templatesPath;
    
    // Именя шаблонов для вывода данных
    private $header;
    private $body;
    private $footer;

    // Контент для вывода
    private $content;

    /*
     * Конструктором задаем значения по умолчанию
     */
    public function __construct($template) {
      $this->templatesPath = __DIR__ . '/../../templates/';
      $this->header = $this->templatesPath . 'header.php';
      $this->footer = $this->templatesPath . 'footer.php';
      $this->setBody($template)
        or die('Не удалось задать шаблон.');
    }

    /*
     * Метод задает значение body.
     * В качетве аргумента принимает имя шаблона.
     * Если путь к файлу существует, утанавливает body и возращает TRUE, иначе возвращает FALSE
     */
    private function setBody($template) {
      $template = $this->templatesPath . $template;
      if (file_exists($template)) {
        $this->body = $template;
        return true;
      } else {
        return false;
      }
    }

    /*
     * Метод задает контент для отображения.
     * В качестве аргументов принимает данные для заполнения шаблона.     * 
     * Возвращает TRUE в случае успеха или FALSE в случае провала.
     */
    public function setContent($content) {
      if (!empty($content)) {
        $this->content = $content;
        return true;
      } else {
        return false;
      }
    }
    
    /*
     * Метод для вывода представления.
     * Возвращает TRUE в случае успеха или FALSE в случае провала.
     */
    public function display() {
      if ($this->body) {        // Можно вызвать только если задан body
        include $this->header;
        include $this->body;
        include $this->footer;
        return true;
      } else {
        return false;
      }
    }
  }