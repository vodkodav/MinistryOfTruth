<?php
  /**
   * Файл для вывода одной новости
   */
?>
<p><a href="index.php?page=news&action=viewAll"> << Вернуься к списку новостей</a> </p>
<hr>
<h2><?= htmlentities($this->display_content['title']) ?></h2>
<p> Дата публикации: <?= date('d-m-Y H:i', $this->display_content['date']) ?></p>
<p> Автор: <?= htmlentities($this->display_content['author']) ?></p>
<p><?= nl2br(htmlentities($this->display_content['content'])) ?></p>

