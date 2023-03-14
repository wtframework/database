<?php

declare(strict_types=1);

namespace WTFramework\Database;

use WTFramework\Config\Config;
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
use WTFramework\SQL\Statement;

abstract class DB
{

  protected static ?array $config = null;
  protected static array $connections = [];

  public static function connection(
    string $name = null,
    string $alias = null
  ): Connection
  {

    $name ??= self::default();

    $config = self::config()[$name] ?? [];

    if (is_string($dbms = $config['dbms'] ?? ''))
    {
      $dbms = DBMS::from($dbms);
    }

    return self::$connections[$alias ?? $name] ??= new Connection(
      pdo: PDO::get(config: $config),
      dbms: $dbms
    );

  }

  protected static function config(): array
  {
    return self::$config ??= (array) Config::get(key: 'database');
  }

  protected static function default(): ?string
  {
    return self::config()['default'] ?? null;
  }

  public static function unprepared(string|Statement $stmt): Response
  {
    return self::connection()->unprepared(stmt: $stmt);
  }

  public static function prepare(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {

    return self::connection()->prepare(
      stmt: $stmt,
      bindings: $bindings
    );

  }

  public static function execute(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): Response
  {

    return self::prepare(
      stmt: $stmt,
      bindings: $bindings
    )->execute();

  }

  public static function get(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): ?\stdClass
  {

    return self::execute(
      stmt: $stmt,
      bindings: $bindings
    )->get();

  }

  public static function all(
    string|Statement $stmt,
    string|int|array $bindings = null
  ): array
  {

    return self::execute(
      stmt: $stmt,
      bindings: $bindings
    )->all();

  }

  public static function alter(): Alter
  {
    return self::connection()->alter();
  }

  public static function create(): Create
  {
    return self::connection()->create();
  }

  public static function delete(): Delete
  {
    return self::connection()->delete();
  }

  public static function drop(): Drop
  {
    return self::connection()->drop();
  }

  public static function insert(): Insert
  {
    return self::connection()->insert();
  }

  public static function replace(): Replace
  {
    return self::connection()->replace();
  }

  public static function select(): Select
  {
    return self::connection()->select();
  }

  public static function truncate(): Truncate
  {
    return self::connection()->truncate();
  }

  public static function update(): Update
  {
    return self::connection()->update();
  }

  public static function column(string $name): Column
  {
    return self::connection()->column(name: $name);
  }

  public static function constraint(string $name = null): Constraint
  {
    return self::connection()->constraint(name: $name);
  }

  public static function transaction(\Closure $callback): Connection
  {
    return self::connection()->transaction(callback: $callback);
  }

  public static function beginTransaction(): void
  {
    self::connection()->beginTransaction();
  }

  public static function commit(): void
  {
    self::connection()->commit();
  }

  public static function rollBack(): void
  {
    self::connection()->rollBack();
  }

}