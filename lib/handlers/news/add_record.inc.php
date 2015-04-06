<?php
  /**
   * Обработчик формы news/new_record.php
   * Возможно для обработчиков нужен новый класс?
   */

    $author  = trim(filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING));
    $title   = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $content = trim(filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING));

    // Создаем новую новость в зависимости от полученных из формы данных.
    // Охватывает не все возможные варинты, возможо стоит доделать.
    if (!empty($content) and !empty($title) and !empty($author)) {
      $new_record = new News($content, $title, $author);
    } elseif (!empty($content) and !empty($title)) {
      $new_record = new News($content, $title);
    } elseif (!empty($content)) {
      $new_record = new News($content);
    } else {
      // По умолчанию создаем новость - заглушку
      $new_record = new News();
    }
    // Сохраняем новость в БД
    $new_record->saveRecord();