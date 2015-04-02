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
        and class_exists(filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) . 'Controller') ) {
    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
  } else {
    $page = 'news';
  }

  // Задаем имя контроллера
  $controller = $page . 'Controller';
  // Подключам нужный контроллер
  $controller = new $controller();

  /*
   * Если GETом переданн параметр action и у выбранного контроллера существует такой метод,
   * то устанавлиеваем его значение в переменную $action, иначе присваиваем значение по умолчанию.   *
   */
  if ( isset($_GET['action'])
        //and method_exists($controller , 'action' . filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING)) ) {
        and is_callable(array($controller , 'action' . filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING))) ) {
    $action = 'action' . filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
  } else {
    $action = 'actionDefault';
  }

  // Выполняем действие
  $controller->$action();

