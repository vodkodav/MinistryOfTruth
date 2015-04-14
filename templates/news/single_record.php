<?php
  /**
   * Шаблон для вывода одной новости
   */
  //debug($item);
?>
<h2><?= htmlentities($item->title) ?></h2>
<p> Дата публикации: <?= date('d-m-Y H:i', $item->date) ?></p>
<p> Автор: <?= htmlentities($item->author) ?></p>
<p><?= nl2br(htmlentities($item->content)) ?></p>
<hr>
<p>
  <a href="/index.php?page=admin&action=edit&record=<?= htmlentities($item->id) ?>">Редактировать</a> 
  <a href="/index.php?page=admin&action=del&record=<?= htmlentities($item->id) ?>">Удалить</a>
</p>