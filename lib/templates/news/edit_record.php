<?php
  /**
   * Файл для вывода формы добавления новости
   */
?>
<form method="post">
  <input type="hidden" name="id" value="<?= htmlentities($item->id) ?>">
  Ваше имя: <input type="text" name="author" width="100" value="<?= htmlentities($item->author) ?>"> <br>
  Заголовок: <input type="text" name="title" width="100" value="<?= htmlentities($item->title) ?>"> <br>
  Текст новости: <br>
  <textarea name="content" cols="100" rows="10"><?= htmlentities($item->content) ?></textarea> <br>
  <button type="submit">Обновить новость</button>
</form>