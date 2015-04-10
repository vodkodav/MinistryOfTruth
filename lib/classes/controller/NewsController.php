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
      $this->actionViewAll();
    }

    /*
     * Метод выводит все новости.
     */
    private function actionViewAll() {
      try {
        $allRecords = NewsModel::findAll();
      } catch (E403Exception $e) {
        $view = new View('error.php');
        $view->addHeader($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
        $view->message = $e->getMessage();
        $view->display();
      }
      $view = new View('news/all_records.php');
      if (empty($allRecords)) {
        throw new E404Ecxeption('Не удалось получить список новостей');
      }
      $view->allItems = $allRecords;
      $view->display();
      //return true;
    }

    /*
     * Метод выводит одну новость.
     * Возвращает TRUE в случае успеха, FALSE в случае провала.
     */
    public function actionView() {
      // Если id передан, то запарашиваем страницу конкретной новости
      if (isset($_GET['record'])) {
        try {
          $record = NewsModel::findById(filter_input(INPUT_GET, 'record', FILTER_SANITIZE_NUMBER_INT));
        } catch (E403Exception $e) {
          $view = new View('error.php');
          $view->addHeader($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
          $view->message = $e->getMessage();
          $view->display();
        }
        if (empty($record)) {
          throw new E404Ecxeption('Не удалось найти новость');
        }
        $view = new View('news/single_record.php');
        $view->item = $record;
        $view->display();
      } else {
        return false;
      }
    }
  }