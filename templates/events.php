<?php
  /**
   * Шаблон для вывода всех новостей
   */
  //debug($this->events);
?>
<ul>
  <?php foreach ($this->events as $event): ?>
    <li>
        <?= htmlentities($event) ?>
    </li>
  <?php endforeach; ?>
</ul>