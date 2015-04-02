<?php
  /**
   * Файл для вывода формы добавления новости
   */
?>
<form method="post">
  Ваше имя: <input type="text" name="author" width="100"> <br>
  Заголовок: <input type="text" name="title" width="100"> <br>
  Текст новости: <br>
  <textarea name="content" cols="100" rows="10"></textarea> <br>
  <button type="submit" name="submit" value="create_record">Отправить новость</button>
</form>