<?php

namespace utilities;

use app\MagazineController;
use i18n\I18n;
use logger\Logger;
use pdo\PDOWrapper;

class DefaultsProvider
{
  protected PDOWrapper $pdoWrapper;
  protected Logger $logger;
  protected I18n $i18n;
  protected MagazineController $magazineController;
  protected \Twig\Environment $twig;

  function __construct(PDOWrapper $pdoWrapper)
  {
    $this->pdoWrapper = $pdoWrapper;
  }

  function getPDOWrapper(): PDOWrapper
  {
    return $this->pdoWrapper;
  }

  function getI18n(string $locale = ''): I18n
  {
    if (!isset($this->i18n)) {
      $this->i18n = new I18n($locale);
    } elseif (!empty($locale) && $this->i18n->getLocale() != $locale) {
      $this->i18n->setLocale($locale);
    }
    return $this->i18n;
  }

  function getLogger(): Logger
  {
    if (!isset($this->logger)) {
      $this->logger = new Logger(getenv('LOG_LEVEL'));
    }

    return $this->logger;
  }

  function getMagazineController(): MagazineController
  {
    if (!isset($this->magazineController)) {
      $this->magazineController = new MagazineController($this);
    }

    return $this->magazineController;
  }

  function getTwig(): \Twig\Environment
  {
    if (!isset($this->twig)) {
      $loader = new \Twig\Loader\FilesystemLoader('./src/templates/src');
      $this->twig = new \Twig\Environment($loader, [
        'cache' => './src/templates/cache',
      ]);
    }

    return $this->twig;
  }
}
