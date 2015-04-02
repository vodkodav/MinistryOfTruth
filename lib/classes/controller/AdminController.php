<?php
  /**
   * Контроллер админки
   */

  class AdminController extends Controller {
    /*
     * Метод просто вызывает actionNew
     */
    public function actionDefault() {
      $this->actionNew();
    }

    /*
     * Метод вызывает обработчик формы добавления новости
     */
    private function actionAdd() {
      require_once __DIR__ . '/../../handlers/news/add_record.inc.php';
      // После обработки формы перенаправляем на главную страницу
      header('Location: index.php');
    }

    /*
     * Метод проверят REQUEST_METHOD и если он не POST,
     * то выводит форму новой новости
     */
    public function actionNew() {
      if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) !== 'POST') {
        $template =  'news/new_record.php';
        $view = new View();
        if ($view->setContent($template)) {
          $view->display();
        }
      } else {
        $this->actionAdd();
      }
    }
  }