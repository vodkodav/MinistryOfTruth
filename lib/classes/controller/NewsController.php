<?php
  /**
   * Контроллер новостей
   */

  class NewsController extends Controller {
    private $display_content;    // Данные для отображения

    /*
     * Метод выполняет действие данного контроллера принятое по умолчанию
     * Возвращает TRUE в случае успеха или FALSE в случае провала.
     */
    public function actionDefault() {
      if ($this->actionViewAll()) {
        return true;
      } else {
        return false;
      }
    }

    /*
     * Метод выводит все новости.
     * Возвращает TRUE в случае успеха или FALSE в случае провала.
     */
    private function actionViewAll() {
      if ($this->display_content = News::getAllRecords()) {
        //include __DIR__ . '/../../../view/news/all_records.inc.php';
        $this->template =  __DIR__ . '/../../../view/news/all_records.inc.php';
        if ($this->view->setContent($this->template, $this->display_content)) {
          $this->view->display();
          return true;
        }
      } else {
        return false;
      }
    }

    /*
     * Метод выводит одну новость.
     * Возвращает TRUE в случае успеха, FALSE в случае провала.
     */
    public function actionView() {
      // Если id передан, то запарашиваем страницу конкретной новости
      if (isset($_GET['record'])) {
        $record = new News();
        // Если запрошенная новость существует, то выводим ее
        if ( $record->loadRecord(filter_input(INPUT_GET, 'record', FILTER_SANITIZE_NUMBER_INT)) ) {
          $this->display_content = $record->getArticle();
          //include __DIR__ . '/../../../view/news/single_record.inc.php';
          $this->template = __DIR__ . '/../../../view/news/single_record.inc.php';
          if ($this->view->setContent($this->template, $this->display_content)) {
            $this->view->display();
            return true;
          }
          return true;
        }
      }
      // Если не удалось получить запрошенную новость, то выводим все новости
      if ($this->actionViewAll()) {
        return true;
      // Если не удалось вывести все новости, то возвращаем false
      } else {
        return false;
      }
    }
  }