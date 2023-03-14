<?php

declare(strict_types=1);

use WTFramework\Database\Connection;
use WTFramework\Database\Response;
use WTFramework\Database\Statements\Select;

$connection = new Connection(pdo: new \PDO('sqlite::memory:'));

it('can execute', function () use ($connection)
{

  expect(
    (new Select($connection))
    ->column(1)
    ->unprepared()
  )
  ->toBeInstanceOf(Response::class);

});

it('can prepare', function () use ($connection)
{

  expect(
    (new Select($connection))
    ->column(1)
    ->prepare()
  )
  ->toBeInstanceOf(Response::class);

});

it('can prepare and execute', function () use ($connection)
{

  expect(
    (new Select($connection))
    ->column(1)
    ->execute()
  )
  ->toBeInstanceOf(Response::class);

});

it('can get record', function () use ($connection)
{

  expect(
    (new Select($connection))
    ->column(1)
    ->get()
  )
  ->toBeInstanceOf(\stdClass::class);

});

it('can get multiple records', function () use ($connection)
{

  expect(
    (new Select($connection))
    ->column(1)
    ->all()
  )
  ->toBeArray();

});