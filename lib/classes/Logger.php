<?php
  /**
   * Description of Logger
   *
   * @author Sasha
   */
  class Logger {
    private $logFile;         // Файл для записи событий
    //private $event = array(); // Массив содержит собитие
    
    public function __construct() {
      $this->logFile = __DIR__ . '/../../events.txt';
    }
    
    public function readAllEvents() {
      $allEvents = file($this->logFile);
      return $allEvents;
    }

    public function addEvent(Exception $e) {
      //debug(is_writeable($this->logFile));
      $event['date'] = date('d-m-Y H:i');
      $event['place'] = $e->getFile() . ' line: ' . $e->getLine();
      $event['message'] = $e->getMessage();
      //debug($event);
      $data = implode(' - ', $event) . " \n";
      file_put_contents($this->logFile, $data, FILE_APPEND);
    }
  }
  