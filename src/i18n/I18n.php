<?php

namespace i18n;

class I18n
{
  const I18N_DIRECTORY = '/assets/i18n/';

  protected array $i18nArray;
  protected string $locale;

  function __construct(string $locale = 'en')
  {
    $this->i18nArray = $this->getFileContent($locale);
  }

  public function get(string $key, array $replacements = []): string
  {
    if (isset($this->i18nArray[$key])) {
      $retValue = $this->i18nArray[$key];
      foreach ($replacements as $search => $replace) {
        str_replace('%' . $search . '%', $replace, $retValue);
      }
      return $retValue;
    } else {
      return $key;
    }
  }

  function getLocale(): string
  {
    return $this->locale;
  }

  function setLocale(string $locale): void
  {
    if ($this->locale != $locale) {
      $this->i18nArray = $this->getFileContent($locale);
    }
  }

  private function getFileContent(string $locale)
  {
    $pathToDir = dirname(__FILE__, 2) . self::I18N_DIRECTORY;
    $straightAway = $pathToDir . $locale . '.json';
    if (file_exists($straightAway)) {
      return json_decode(file_get_contents($straightAway), true);
    }
    $firstTwoLetters = $pathToDir . strtolower(substr($locale, 0, 2)) . '.json';
    if (file_exists($firstTwoLetters)) {
      return json_decode(file_get_contents($firstTwoLetters), true);
    }
    $fallback = $pathToDir . 'en.json';
    return json_decode(file_get_contents($fallback));
  }
}
