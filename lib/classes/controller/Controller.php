<?php
  /**
   * Абстрактнй конроллер
   */

  abstract class Controller {
    /*
     * Метод для выбора дейстия по умолчанию
     */
    public abstract function actionDefault();
  }