<?php
  /**
   * Created by PhpStorm.
   * User: Sasha
   * Date: 31.03.2015
   * Time: 16:52
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
      if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        //include __DIR__ . '/../../../view/news/new_record.inc.php';
        $this->template =  __DIR__ . '/../../../view/news/new_record.inc.php';
        if ($this->view->setContent($this->template)) {
          $this->view->display();
        }
      } else {
        $this->actionAdd();
      }
    }
  }