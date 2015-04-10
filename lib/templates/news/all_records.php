<?php
  /**
   * Шаблон для вывода всех новостей
   */
?>
<p>
  <a href="/index.php?page=admin&action=new">Добавить новость</a>
  <a href="/index.php?page=admin&action=viewlog">Журнал событий</a>
</p>
<hr>
<ul>
  <?php foreach ($allItems as $record): ?>
    <li>
      <?= date('d-m-Y H:i', $record->date) ?>
      <a href="/index.php?page=news&action=view&record=<?= $record->id ?>">
        <?= htmlentities($record->title) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>