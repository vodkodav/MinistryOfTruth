<?php
  /**
   * Файл для вывода одной новости
   */
?>
<p><a href="/index.php?page=news&action=viewAll"> << Вернуться к списку новостей</a> </p>
<hr>
<h2><?= htmlentities($item['title']) ?></h2>
<p> Дата публикации: <?= date('d-m-Y H:i', $item['date']) ?></p>
<p> Автор: <?= htmlentities($item['author']) ?></p>
<p><?= nl2br(htmlentities($item['content'])) ?></p>

