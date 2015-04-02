<?php
  /**
   * Файл для вывода всех новостей
   */
?>
<p><a href="index.php?page=admin&action=new">Добавить новость</a></p>
<hr>
<ul>
  <?php foreach ($this->display_content as $id => $record):
    /*
     * Не уверен, что это можно делать в шаблоне для вывода,
     * нужно подумать, куда перенести или как исправить.
     * Наверное, логичнее всего ковырять класс News
     */
    $record = $record->getArticle(); ?>
    <li>
      <?=  date('d-m-Y H:i', $record['date']) ?>
      <a href="index.php?page=news&action=view&record=<?= $id ?>">
        <?= htmlentities($record['title']) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>