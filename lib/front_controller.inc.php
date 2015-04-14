<?php
	/**
	 * Точка входа в приложение
	 */

	// Для корректной работы файлу требуются служебные функции
	require_once __DIR__ . '/service.inc.php';

  // Определяем, какую страницу сайта запросил пользователь
  /*
   * Если GETом переданн параметр page и существует класс контроллера с соответсвующим именем,
   * то устанавлиеваем его значение в переменную $controller, иначе присваиваем значение по умолчанию.
   */
  if ( isset($_GET['page'])
        and !empty($_GET['page'])
        and class_exists('App\\Classes\\Controller\\' . filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING)) ) {
    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
  } else {
    $page = 'News';
  }

  // Задаем имя контроллера
  $controller = 'App\\Classes\\Controller\\' . $page;
  // Подключам нужный контроллер
  $controller = new $controller();

  /*
   * Если GETом переданн параметр action и у выбранного контроллера существует такой метод,
   * то устанавлиеваем его значение в переменную $action, иначе присваиваем значение по умолчанию.   *
   */
  if ( isset($_GET['action'])
        and is_callable(array($controller , 'action' . filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING))) ) {
    $action = 'action' . filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
  } else {
    $action = 'actionDefault';
  }

  try {
    $controller->$action();
  } catch (App\Classes\E404Ecxeption $e) {
    $view = new App\Classes\View('error.php');
    $view->addHeader($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    $view->message = $e->getMessage();
    $view->display();
  }
  

