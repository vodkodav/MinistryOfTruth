<?php
  /**
   * Класс отвечает за представление данных
   */

  class View{
    // Путь к шаблонам
    // По хорошему, должен быть статическим
    private $templatesPath;
    
    // Дополнительные http headers
    private $httpHeaders = array();

    // Именя шаблонов для вывода данных
    private $header;
    private $body;
    private $footer;

    // Контент для вывода
    private $content = array();

    /*
     * Конструктором задаем значения по умолчанию
     */
    public function __construct($template) {
      $this->templatesPath = __DIR__ . '/../../templates/';
      $this->header = $this->templatesPath . 'header.php';
      $this->footer = $this->templatesPath . 'footer.php';
      $this->setBody($template);
    }

    /*
     * Метод вызывается при попытке установить значение неопределеного свойства.
     * Метод получает в качестве аргументов имя свойства (key) и значение свойста (value).
     * Метод добавляет в массив content новый элемент с ключем key и значением value. 
     */
    public function __set($key, $value) {
      $this->content[$key] = $value;
    }
    
    public function __get($key) {
      return $this->content[$key];
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

    public function addHeader($header) {
      $this->httpHeaders[] = (string) $header;
    }
    
    /*
     * Метод создает страницу представления и записывает в буфер.
     * Возвращает содержимое бефера в случае успеха или FALSE в случае провала.
     */
    private function render() {
      if ($this->body) {
        // Готовим контент к выводу
        foreach ($this->content as $key => $value) {
          $$key = $value;
        }
        // Начинаем буферизацию
        ob_start();
        // Если заданы дополнительные headers, то сначала посылаем их
        if (!empty($this->httpHeaders)) {
          foreach ($this->httpHeaders as $httpHeader) {
            header($httpHeader);
          }
        }
        // Выводим все шаблоны
        include $this->header;
        include $this->body;
        include $this->footer;
        // Сохраняем буфер в переменную
        $render = ob_get_contents();
        // Заканчиваем буферизиацию 
        ob_end_clean();
        return $render;
      } else {
        return false;
      }
    }
    
    /*
     * Метод выводит данные.
     * Выводит данные в случае успеха или возвращает FALSE в случае провала.
     */
    public function display() {
      if ($render = $this->render()) {
        echo $render;
        exit;
      } else {
        return false;
      }
    }
  }