<?php

namespace pdo;

use PDOException;

class PDOWrapper
{

  protected \PDO $pdo;
  protected \PDOStatement $pdoStatement;
  protected string $query;

  function __construct($dbName, $dbUser, $dbPass)
  {
    $this->pdo = new \PDO('mysql:host=localhost;dbname=' . $dbName, $dbUser, $dbPass);
    $this->pdo->setAttribute(
      \PDO::ATTR_ERRMODE,
      \PDO::ERRMODE_EXCEPTION
    );
  }

  function setQuery(string $query)
  {
    $this->query = $query;
  }

  function prepareQuery()
  {
    if (!empty($this->query)) {
      $this->pdoStatement = $this->pdo->prepare($this->query);
      if ($this->pdoStatement) {
        return;
      }
    }
    $this->query = null;
    throw new PDOException('no query provided or query is not a valid SQL statement');
  }

  function doQuery(string $query = null)
  {
    if(!is_null($query)) {
      $this->setQuery($query);
    }
    $this->pdoStatement = $this->pdo->query($this->query);
  }

  function bindParameters(array $pdoParams)
  {
    if (!($this->pdoStatement instanceof \PDOStatement) || $this->pdoStatement->errorCode() > 0) {
      throw new PDOException('PDO Error');
    }
    foreach ($pdoParams as $pdoParam) {
      if (!($pdoParam instanceof PDOParam)) {
        throw new PDOException('must provide PDOParam');
      }
      if (!$this->pdoStatement->bindValue($pdoParam->getName(), $pdoParam->getValue(), $pdoParam->getType())) {
        throw new PDOException("Parameter '{$pdoParam->getName()}' with value '{$pdoParam->getValue()}' and type '{$pdoParam->getType()}' could not be bound.");
      }
    }
  }

  function executePreparedStatement($params = null)
  {
    $this->pdoStatement->execute($params);
  }

  function getLastInsertedId(): int
  {
    return $this->pdo->lastInserId;
  }

  function getResultArray($fetchStyle = \PDO::FETCH_ASSOC)
  {
    return $this->pdoStatement->fetchAll($fetchStyle);
  }
}
