<?php
  /**
   * Контроллер админки
   * нужно добавить свойста содержащие REQUEST_METHOD
   */

  class AdminController extends Controller {
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
        $newRecord->save();
      }
      // После обработки формы перенаправляем на главную страницу
      header('Location: index.php');
    }

    /*
     * Метод проверят REQUEST_METHOD и если он не POST,
     * то выводит форму новой новости
     */
    public function actionNew() {
      if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) !== 'POST') {
        if ($view = new View('news/new_record.php')) {
          $view->display();
        }
      } else {
        $this->actionSave();
      }
    }
    
    public function actionDel() {
      if (isset($_GET['record'])) {        
        // Если запрошенная новость существует, то удаляем ее
        if ( $record = NewsModel::findById(filter_input(INPUT_GET, 'record', FILTER_SANITIZE_NUMBER_INT)) ) {
          $record->delete();
        }  
      }
      // После выполнения действия перенаправляем на главную страницу
      header('Location: index.php');
    }
    
    public function actionEdit() {
      if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) !== 'POST') {
        if (isset($_GET['record'])) {        
          // Если запрошенная новость существует, то выводим форму редактирования
          if ( $record = NewsModel::findById(filter_input(INPUT_GET, 'record', FILTER_SANITIZE_NUMBER_INT)) ) {
            $view = new View('news/edit_record.php');
            $view->item = $record;
            $view->display();    
          }
        }
      } else {
        $this->actionSave();
      }
    }
  }