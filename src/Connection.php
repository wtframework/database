<?php

declare(strict_types=1);

namespace WTFramework\Database;

use WTFramework\Database\Statements\Alter;
use WTFramework\Database\Statements\Create;
use WTFramework\Database\Statements\Delete;
use WTFramework\Database\Statements\Drop;
use WTFramework\Database\Statements\Insert;
use WTFramework\Database\Statements\Replace;
use WTFramework\Database\Statements\Select;
use WTFramework\Database\Statements\Truncate;
use WTFramework\Database\Statements\Update;
use WTFramework\SQL\Column;
use WTFramework\SQL\Constraint;
use WTFramework\SQL\DBMS;
use WTFramework\SQL\Interfaces\HasBindings;
use WTFramework\SQL\Statement;

class Connection
{

  public readonly DBMS $dbms;

  public function __construct(
    public readonly \PDO $pdo,
    DBMS $dbms = null
  )
  {

    $this->dbms = $dbms ?? DBMS::from(
      $pdo->getAttribute(\PDO::ATTR_DRIVER_NAME)
    );

  }

  public function unprepared(string|Statement $stmt): Response
  {

    $response = new Response(
      connection: $this,
      stmt: $this->pdo->query((string) $stmt)
    );

    return $response;

  }

  public function prepare(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {

    $response = new Response(
      connection: $this,
      stmt: $this->pdo->prepare((string) $stmt)
    );

    if ($stmt instanceof HasBindings)
    {
      $bindings = $stmt->bindings();
    }

    if (null !== $bindings)
    {
      $response->bind(bindings: $bindings);
    }

    return $response;

  }

  public function execute(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {

    return $this->prepare(
      stmt: $stmt,
      bindings: $bindings
    )->execute();

  }

  public function get(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): ?\stdClass
  {

    return $this->execute(
      stmt: $stmt,
      bindings: $bindings
    )->get();

  }

  public function all(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): array
  {

    return $this->execute(
      stmt: $stmt,
      bindings: $bindings
    )->all();

  }

  public function alter(): Alter
  {
    return new Alter(connection: $this);
  }

  public function create(): Create
  {
    return new Create(connection: $this);
  }

  public function delete(): Delete
  {
    return new Delete(connection: $this);
  }

  public function drop(): Drop
  {
    return new Drop(connection: $this);
  }

  public function insert(): Insert
  {
    return new Insert(connection: $this);
  }

  public function replace(): Replace
  {
    return new Replace(connection: $this);
  }

  public function select(): Select
  {
    return new Select(connection: $this);
  }

  public function truncate(): Truncate
  {
    return new Truncate(connection: $this);
  }

  public function update(): Update
  {
    return new Update(connection: $this);
  }

  public function column(string $name): Column
  {

    return new Column(
      dbms: $this->dbms,
      name: $name
    );

  }

  public function constraint(string $name = null): Constraint
  {

    return new Constraint(
      dbms: $this->dbms,
      name: $name
    );

  }

  public function transaction(\Closure $callback): self
  {

    $this->beginTransaction();

    try
    {

      $callback();

      $this->commit();

      return $this;

    }

    catch (\Exception $e)
    {

      $this->rollback();

      throw $e;

    }

  }

  public function beginTransaction(): void
  {
    $this->pdo->beginTransaction();
  }

  public function commit(): void
  {
    $this->pdo->commit();
  }

  public function rollBack(): void
  {
    $this->pdo->rollBack();
  }

}