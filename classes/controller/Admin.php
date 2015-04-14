<?php
  namespace App\Classes\Controller;
  use App\Classes\Model\News as NewsModel;
  use App\Classes\View as View;
  use App\Classes\E403Exception as E403Exception;
  use App\Classes\Logger as Logger;

  class Admin extends Main {
    /*
     * Метод просто вызывает actionNew
     */
    public function actionDefault() {
      $this->actionNew();
    }

    /*
     * Метод обрабатывает форму
     */
    private function actionSave() {
      $newRecord = new NewsModel();
      foreach ($_POST as $field => $value) {
        $newRecord->$field = $value;
      }
      //debug($newRecord);
      //debug(isset($newRecord->content));
      //debug(empty($newRecord->content));
      if (!empty($newRecord->content)) {
        try {
          $newRecord->save();
        } catch (E403Exception $e) {
          $view = new View('error.php');
          $view->addHeader($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
          $view->message = $e->getMessage();
          $view->display();
        }
      }
      // После обработки формы перенаправляем на главную страницу
      header('Location: index.php');
      exit;
    }

    /*
     * Метод проверят REQUEST_METHOD и если он не POST,
     * то выводит форму новой новости
     */
    public function actionNew() {
      if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) !== 'POST') {
        $view = new View('news/new_record.php');
        $view->display();
      } else {
        $this->actionSave();
      }
    }
    
    public function actionDel() {
      if (isset($_GET['record'])) {        
        // Если запрошенная новость существует, то удаляем ее
        try {
          $record = NewsModel::findById(filter_input(INPUT_GET, 'record', FILTER_SANITIZE_NUMBER_INT));
        } catch (E403Exception $e) {
          $view = new View('error.php');
          $view->addHeader($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
          $view->message = $e->getMessage();
          $view->display();
        } 
        $record->delete();
      }
      // После выполнения действия перенаправляем на главную страницу
      header('Location: index.php');
      exit;
    }
    
    public function actionEdit() {
      if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) !== 'POST') {
        if (isset($_GET['record'])) {
          // Если запрошенная новость существует, то выводим форму редактирования
          try { 
            $record = NewsModel::findById(filter_input(INPUT_GET, 'record', FILTER_SANITIZE_NUMBER_INT));
          } catch (E403Exception $e) {
            $view = new View('error.php');
            $view->addHeader($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            $view->message = $e->getMessage();
            $view->display();
          }
          $view = new View('news/edit_record.php');
          $view->item = $record;
          $view->display();    
        } 
      } else {
        $this->actionSave();
      }
    }
    
    public function actionViewLog() {
      $view = new View('events.php');
      $log = new Logger;
      //debug($log->readAllEvents());
      $view->events = $log->readAllEvents();
      $view->display();
    }
  }