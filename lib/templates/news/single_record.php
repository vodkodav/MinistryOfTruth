<?php
  /**
   * Файл для вывода одной новости
   */
?>
<p><a href="/index.php?page=news&action=viewAll"> << Вернуться к списку новостей</a> </p>
<hr>
<h2><?= htmlentities($this->content['title']) ?></h2>
<p> Дата публикации: <?= date('d-m-Y H:i', $this->content['date']) ?></p>
<p> Автор: <?= htmlentities($this->content['author']) ?></p>
<p><?= nl2br(htmlentities($this->content['content'])) ?></p>

