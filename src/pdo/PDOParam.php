<?php

namespace pdo;

use TypeError;

class PDOParam
{
  protected string $name;
  protected $value;
  protected $type;

  function __construct(string $name, $value, $type)
  {
    switch ($type) {
      case \PDO::PARAM_BOOL:
        if (gettype($value) !== 'boolean') {
          throw new TypeError('value should be boolean, but is typeof ' . gettype($value));
        }
        break;
      case \PDO::PARAM_NULL:
        if (gettype($value) !== 'NULL') {
          throw new TypeError('value should be null, but is typeof ' . gettype($value));
        }
        break;
      case \PDO::PARAM_INT:
        if (gettype($value) !== 'integer') {
          throw new TypeError('value should be int, but is typeof ' . gettype($value));
        }
        break;
      case \PDO::PARAM_STR:
        if (gettype($value) !== 'string') {
          throw new TypeError('value should be string, but is typeof ' . gettype($value));
        }
        break;
      default:
        throw new TypeError('unidentified type given: ' . $type);
    }

    $this->name = $name;
    $this->value = $value;
    $this->type = $type;
  }

  function getName(): string
  {
    return $this->name;
  }

  function getValue()
  {
    return $this->value;
  }

  function getType()
  {
    return $this->type;
  }
}
