<?php

declare(strict_types=1);

namespace WTFramework\Database\Traits;

use WTFramework\Database\Connection as DatabaseConnection;
use WTFramework\Database\Response;

trait Connection
{

  public function __construct(public readonly DatabaseConnection $connection)
  {
    $this->dbms = $connection->dbms;
  }

  public function unprepared(): Response
  {
    return $this->connection->unprepared(stmt: $this);
  }

  public function prepare(): Response
  {
    return $this->connection->prepare(stmt: $this);
  }

  public function execute(): Response
  {
    return $this->prepare()->execute();
  }

  public function get(): ?object
  {
    return $this->execute()->get();
  }

  public function all(): array
  {
    return $this->execute()->all();
  }

}