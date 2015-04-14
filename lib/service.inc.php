<?php
	/**
	 * Файл содержит служебные функции
	 */

  // Функция выводит переменную и останавливает выпонение скрипта.
  function debug($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    exit;
  }

  // Функция для автоматической загрузки классов
  function __autoload($className) {
    //debug($className);
    
    $classPath = explode('\\', $className);
    $classPath[0] = __DIR__ . DIRECTORY_SEPARATOR . '..';
    $classPath = implode(DIRECTORY_SEPARATOR, $classPath) . '.php';
    //debug($classPath);
    if (file_exists($classPath)) {
      require $classPath;
    }

//    if (file_exists(__DIR__ . '/classes/controller/' . $class_name . '.php')) {
//      require __DIR__ . '/classes/controller/' . $class_name . '.php';
//
//    } elseif (file_exists(__DIR__ . '/classes/model/' . $class_name . '.php')) {
//      require __DIR__ . '/classes/model/' . $class_name . '.php';
//
//    } elseif (file_exists(__DIR__ . '/classes/' . $class_name . '.php')) {
//      require __DIR__ . '/classes/' . $class_name . '.php';
//    }
  }