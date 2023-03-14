<?php

declare(strict_types=1);

use WTFramework\Database\Connection;
use WTFramework\Database\Response;
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

$pdo = new \PDO('sqlite::memory:');

it('can get connection', function () use ($pdo)
{

  expect(new Connection($pdo))
  ->toBeInstanceOf(Connection::class);

});

it('can get dbms', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->dbms
  )
  ->toBe(DBMS::SQLite);

});

it('can override dbms', function () use ($pdo)
{

  expect(
    (new Connection(
      $pdo,
      DBMS::MariaDB
    ))
    ->dbms
  )
  ->toBe(DBMS::MariaDB);

});

it('can execute', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->unprepared("SELECT 1")
  )
  ->toBeInstanceOf(Response::class);

});

it('can prepare', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->prepare("SELECT 1")
  )
  ->toBeInstanceOf(Response::class);

});

it('can prepare and execute', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->execute("SELECT 1")
  )
  ->toBeInstanceOf(Response::class);

});

it('can get record', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->get("SELECT 1")
  )
  ->toBeInstanceOf(\stdClass::class);

});

it('can get multiple records', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->all("SELECT 1 UNION SELECT 2")
  )
  ->toBeArray();

});

it('can get alter statement', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->alter()
  )
  ->toBeInstanceOf(Alter::class);

});

it('can get create statement', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->create()
  )
  ->toBeInstanceOf(Create::class);

});

it('can get delete statement', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->delete()
  )
  ->toBeInstanceOf(Delete::class);

});

it('can get drop statement', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->drop()
  )
  ->toBeInstanceOf(Drop::class);

});

it('can get insert statement', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->insert()
  )
  ->toBeInstanceOf(Insert::class);

});

it('can get replace statement', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->replace()
  )
  ->toBeInstanceOf(Replace::class);

});

it('can get select statement', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->select()
  )
  ->toBeInstanceOf(Select::class);

});

it('can get truncate statement', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->truncate()
  )
  ->toBeInstanceOf(Truncate::class);

});

it('can get update statement', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->update()
  )
  ->toBeInstanceOf(Update::class);

});

it('can get column', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->column('test')
  )
  ->toBeInstanceOf(Column::class);

});

it('can get column constraint', function () use ($pdo)
{

  expect(
    (new Connection($pdo))
    ->constraint()
  )
  ->toBeInstanceOf(Constraint::class);

});