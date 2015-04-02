<?php
  /**
   * Контроллер новостей
   */

  class NewsController extends Controller {
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
      if ($displayContent = News::getAllRecords()) {
        $template = 'news/all_records.php';
        $view = new View();
        if ($view->setContent($template, $displayContent)) {
          $view->display();
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
          $displayContent = $record->getArticle();
          $template = 'news/single_record.php';
          $view = new View();
          if ($view->setContent($template, $displayContent)) {
            $view->display();
            return true;
          }
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