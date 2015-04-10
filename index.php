<?php
  // Тут будет отладочный код
//  require_once __DIR__ . '/lib/service.inc.php';
//  $var = NewsModel::findByColumn('author', 'Автор');
//  debug($var);
//
//  $var = new NewsModel;
//  $var->author = 'Автор';
//  $var->title = 'Hello world';
//  $var->content = 'Содержимое новости.';
//  $var->date = time();
//  //debug($var);
//  $var->save();
//  
//  $var = NewsModel::findById(31);
//  $var->edit('content', 'Hello world!');
//  //debug($var);
//  $var->save();
//  $var = NewsModel::findById(31);
//  
//  $var = NewsModel::findByColumn('title', 'Объявление');
//  debug($var);
  // Конец отладочного кода
  
  // Вызываем основной контроллер
	require_once 'lib/controller.inc.php';